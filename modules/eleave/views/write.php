<?php
/**
 * @filesource modules/eleave/views/write.php
 *
 * @copyright 2016 Goragod.com
 * @license https://www.kotchasan.com/license/
 *
 * @see https://www.kotchasan.com/
 */

namespace Eleave\Write;

use Kotchasan\Html;

/**
 * module=eleave-write
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * ฟอร์มสร้าง/แก้ไข ประเภทการลา
     *
     * @param object $index
     *
     * @return string
     */
    public function render($index)
    {
        $form = Html::create('form', [
            'id' => 'setup_frm',
            'class' => 'setup_frm',
            'autocomplete' => 'off',
            'action' => 'index.php/eleave/model/write/submit',
            'onsubmit' => 'doFormSubmit',
            'ajax' => true,
            'token' => true
        ]);
        $fieldset = $form->add('fieldset', [
            'title' => '{LNG_Details of} {LNG_Leave type}'
        ]);
        // topic
        $fieldset->add('text', [
            'id' => 'topic',
            'labelClass' => 'g-input icon-edit',
            'itemClass' => 'item',
            'label' => '{LNG_Leave type}',
            'maxlength' => 150,
            'value' => isset($index->topic) ? $index->topic : ''
        ]);
        // detail
        $fieldset->add('textarea', [
            'id' => 'detail',
            'labelClass' => 'g-input icon-file',
            'itemClass' => 'item',
            'label' => '{LNG_Leave conditions}',
            'rows' => 5,
            'value' => isset($index->detail) ? $index->detail : ''
        ]);
        // num_days
        $fieldset->add('number', [
            'id' => 'num_days',
            'labelClass' => 'g-input icon-event',
            'itemClass' => 'item',
            'label' => '{LNG_Number of leave days}',
            'unit' => '{LNG_days}',
            'comment' => '{LNG_Enter 0 if you want unlimited leave}',
            'value' => isset($index->num_days) ? $index->num_days : 10
        ]);
        $fieldset = $form->add('fieldset', [
            'class' => 'submit'
        ]);
        // submit
        $fieldset->add('submit', [
            'class' => 'button ok large icon-save',
            'value' => '{LNG_Save}'
        ]);
        // id
        $fieldset->add('hidden', [
            'id' => 'id',
            'value' => $index->id
        ]);
        // คืนค่า HTML
        return $form->render();
    }
}
