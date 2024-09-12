<?php
/**
 * @filesource modules/eleave/models/statistics.php
 *
 * @copyright 2016 Goragod.com
 * @license https://www.kotchasan.com/license/
 *
 * @see https://www.kotchasan.com/
 */

namespace Eleave\Statistics;

use Kotchasan\Database\Sql;

/**
 * module=eleave-statistics
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * สรุปประวัติการลารายบุคคล
     *
     * @param array $params
     *
     * @return array
     */
    public static function execute($params)
    {
        $where = [
            ['F.leave_id', 'I.id'],
            ['F.member_id', $params['member_id']],
            ['F.status', 1],
            ['I.published', 1]
        ];
        if (!empty($params['from'])) {
            $where[] = ['F.start_date', '>=', $params['from']];
        }
        if (!empty($params['to'])) {
            $where[] = ['F.start_date', '<=', $params['to']];
        }
        return static::createQuery()
            ->select('I.topic', 'I.num_days', Sql::SUM('days', 'days'))
            ->from('leave I')
            ->join('leave_items F', 'LEFT', $where)
            ->groupBy('I.topic')
            ->cacheOn()
            ->execute();
    }
}
