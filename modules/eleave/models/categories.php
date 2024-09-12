<?php
/**
 * @filesource modules/eleave/models/categories.php
 *
 * @copyright 2016 Goragod.com
 * @license https://www.kotchasan.com/license/
 *
 * @see https://www.kotchasan.com/
 */

namespace Eleave\Categories;

/**
 * module=eleave-categories
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Index\Categories\Model
{
    /**
     * เมธอดเมื่อมีการบันทึกข้อมูลเรียบร้อยแล้ว
     *
     * @param string $type
     * @param array $login
     */
    protected function onSaved($type, $login)
    {
        // หมวดหมู่ของโมดูล
        $category = \Eleave\Category\Model::create();
        // บันทึกการดำเนินการบันทึกหมวดหมู่
        \Index\Log\Model::add(0, 'eleave', 'Save', '{LNG_Save} '.$category->name($type), $login['id']);
    }
}
