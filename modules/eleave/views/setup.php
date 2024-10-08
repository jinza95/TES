<?php
/**
 * @filesource modules/eleave/views/setup.php
 *
 * @copyright 2016 Goragod.com
 * @license https://www.kotchasan.com/license/
 *
 * @see https://www.kotchasan.com/
 */

namespace Eleave\Setup;

use Kotchasan\DataTable;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=eleave-setup
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * @var array
     */
    private $publisheds;
    /**
     * รายการประเภทการลา
     *
     * @param Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        $this->publisheds = Language::get('PUBLISHEDS');
        // URL สำหรับส่งให้ตาราง
        $uri = $request->createUriWithGlobals(WEB_URL.'index.php');
        // ตาราง
        $table = new DataTable([
            /* Uri */
            'uri' => $uri,
            /* Model */
            'model' => \Eleave\Setup\Model::toDataTable(),
            /* รายการต่อหน้า */
            'perPage' => $request->cookie('eleaveSetup_perPage', 30)->toInt(),
            /* เรียงลำดับ */
            'sort' => 'id DESC',
            /* ฟังก์ชั่นจัดรูปแบบการแสดงผลแถวของตาราง */
            'onRow' => [$this, 'onRow'],
            /* คอลัมน์ที่ไม่ต้องแสดงผล */
            'hideColumns' => ['id'],
            /* ตั้งค่าการกระทำของของตัวเลือกต่างๆ ด้านล่างตาราง ซึ่งจะใช้ร่วมกับการขีดถูกเลือกแถว */
            'action' => 'index.php/eleave/model/setup/action',
            'actionCallback' => 'dataTableActionCallback',
            'actions' => [
                [
                    'id' => 'action',
                    'class' => 'ok',
                    'text' => '{LNG_With selected}',
                    'options' => [
                        'delete' => '{LNG_Delete}'
                    ]
                ]
            ],
            /* คอลัมน์ที่สามารถค้นหาได้ */
            'searchColumns' => ['topic', 'document_no'],
            /* ส่วนหัวของตาราง และการเรียงลำดับ (thead) */
            'headers' => [
                'topic' => [
                    'text' => '{LNG_Leave type}'
                ],
                'num_days' => [
                    'text' => '{LNG_Number of leave days}',
                    'class' => 'center'
                ],
                'published' => [
                    'text' => ''
                ]
            ],
            /* รูปแบบการแสดงผลของคอลัมน์ (tbody) */
            'cols' => [
                'num_days' => [
                    'class' => 'center'
                ],
                'published' => [
                    'class' => 'center'
                ]
            ],
            /* ปุ่มแสดงในแต่ละแถว */
            'buttons' => [
                'edit' => [
                    'class' => 'icon-edit button green',
                    'href' => $uri->createBackUri(['module' => 'eleave-write', 'id' => ':id']),
                    'text' => '{LNG_Edit}'
                ]
            ],
            /* ปุ่มเพิ่ม */
            'addNew' => [
                'class' => 'float_button icon-new',
                'href' => $uri->createBackUri(['module' => 'eleave-write']),
                'title' => '{LNG_Add} {LNG_Leave type}'
            ]
        ]);
        // save cookie
        setcookie('eleaveSetup_perPage', $table->perPage, time() + 2592000, '/', HOST, HTTPS, true);
        // คืนค่า HTML
        return $table->render();
    }

    /**
     * จัดรูปแบบการแสดงผลในแต่ละแถว.
     *
     * @param array $item
     *
     * @return array
     */
    public function onRow($item, $o, $prop)
    {
        $item['num_days'] = $item['num_days'] == 0 ? '{LNG_Unlimited}' : $item['num_days'];
        $item['published'] = '<a id=published_'.$item['id'].' class="icon-published'.$item['published'].'" title="'.$this->publisheds[$item['published']].'"></a>';
        return $item;
    }
}
