<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/14
 * Time: 11:47
 * 专门配置连接crateDB
 */

namespace app\Service\report\model;
use crate\crateDB;
use think\Db;
use think\image\Exception;

class orderReport
{
    private $crate = null;
    private $dns = null;
    private $conn = null;

    /**
     * 初始化连接crateDB
     * orderReport constructor.
     * @param array $arr
     */
    public function __construct($arr = [])
    {
        $this->dns = config('crate_conf');
        $this->crate = new crateDB(['dns' => $this->dns]);
        $this->conn = $this->crate->getCrateConnection();
    }

    /**
     * 获取报表列表
     * @param array $arr
     */
    public function getReportList($arr = [])
    {
        $data = [];
        $list = [];
        $page = empty($arr['page']) ? 0 : $arr['page'];
        $where = " and u_level={$arr['u_level']}-1 and {$arr['top_name']} = '{$arr['top_value']}' ";
        $sqlcount = "select count(*) from ffc_users where 1 " . $where;
        $count = Db::query($sqlcount);
        $data['page']['count'] = $count[0]['count(*)'];
        $data['page']['totalpage'] = ceil($data['page']['count'] / DEFAULT_PER_PAGE);
        $data['page']['pre'] = ($page - 1) <= 0 ? 0 : ($page - 1);
        $data['page']['next'] = $page + 1;
        $data['page']['start'] = $arr['pagecount'] * $page + 1;
        $data['page']['end'] = $arr['pagecount'] * ($page + 1);
        $sql = "select u_id,u_username,u_level from ffc_users where 1 " . $where;
        $sql .= " limit " . $arr['pagecount'] * $page . "," . $arr['pagecount'];
        $res = Db::query($sql);
        if (!empty($res)) {
            foreach ($res as $k => $v) {
                $top_name = 'ffc_top_' . $v['u_level'];
                $report = $this->getUsetReport($top_name, $v['u_username'], $arr['start_time'], $arr['end_time']);
                $data['list'][] = array_merge($v, $report);
            }
            return $data;
        } else {
            return [];
        }

    }

    /**
     * 注单详情
     */
    public function getorderDetail($data = [])
    {
        $arr = [];
        $where = " where  ffc_username='{$data['ffc_username']}'";
        if (!empty($start_time) && !empty($end_time)) {
            $where .= " and ffc_draw_time >='{$data['start_time']}' and ffc_draw_time>'{$data['end_time']}'  ";
        }
        $page = $data['page'];
        $start = $page*$data['pagecount']+1;
        $sqlcount = "select count(*) from ffc_order".$where;
        $sql = "select  * from  ffc_order ".$where;
        try {
            $countdata = $this->conn->query($sqlcount);
            $countdata = $countdata->fetch();
            $count = $countdata['count(*)'];
            $res = $this->conn->query($sql);
            $arr['list'] = $res->fetchAll();
            $arr['page']['count'] = $count;
            $arr['page']['totalpage'] = ceil($count/$data['pagecount']);
            $arr['page']['pre'] = ($page - 1) <= 0 ? 0 : ($page - 1);
            $arr['page']['next'] = $page + 1;
            $arr['page']['start'] = $data['pagecount'] * $page + 1;
            $arr['page']['end'] = $data['pagecount'] * ($page + 1);
            return $arr;
        } catch (Exception $e) {
            return false;
        }

    }

    /**
     * 用户报表
     */
    public function userReportList($data = [])
    {
        $arr = [];
        $where = " where  {$data['ffc_top_name']}='{$data['top_value']}'";
        if (!empty($start_time) && !empty($end_time)) {
            $where .= " and ffc_draw_time >='{$data['start_time']}' and ffc_draw_time>'{$data['end_time']}'  ";
        }
        $page = $data['page'];
        $start = $page*$data['pagecount']+1;
        $sqlcount = "select count(*) from (select ffc_username from ffc_order_report " . $where." GROUP  BY  ffc_username ) as tmp";
        $sql = " select ffc_username as u_username,sum(ffc_counts) as counts,sum(ffc_results_5) as results_5,sum(ffc_results_4) as results_4,sum(ffc_results_3) as results_3,sum(ffc_results_2) as results_2,sum(ffc_results_1) as results_1,sum(ffc_amount) as amount,sum(ffc_prize) as prize,sum(ffc_wins) as wins from  ffc_order_report " . $where . " group by ffc_username";
        $sql .=" limit  ".$data['pagecount']." offset ".$start;
        try {
            $countdata = $this->conn->query($sqlcount);
            $countdata = $countdata->fetch();
            $count = $countdata['count(*)'];
            $res = $this->conn->query($sql);
            $arr['list'] = $res->fetchAll();
            $arr['page']['count'] = $count;
            $arr['page']['totalpage'] = ceil($count/$data['pagecount']);
            $arr['page']['pre'] = ($page - 1) <= 0 ? 0 : ($page - 1);
            $arr['page']['next'] = $page + 1;
            $arr['page']['start'] = $data['pagecount'] * $page + 1;
            $arr['page']['end'] = $data['pagecount'] * ($page + 1);
            return $arr;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 获取指定的层级用户报表总和
     * @param array $data
     */
    protected function getUsetReport($topname = '', $u_username = '', $start_time = '', $end_time = '')
    {
        $where = " where   $topname = '{$u_username}'";
        if (!empty($start_time) && !empty($end_time)) {
            $where .= " and ffc_draw_time >='$start_time' and ffc_draw_time>'{$end_time}'  ";
        }
        $sql = "select sum(ffc_counts) as counts,sum(ffc_results_5) as results_5,sum(ffc_results_4) as results_4,sum(ffc_results_3) as results_3,sum(ffc_results_2) as results_2,sum(ffc_results_1) as results_1,sum(ffc_amount) as amount,sum(ffc_prize) as prize,sum(ffc_wins) as wins from  ffc_order_report   " . $where;
        try {
            $data = $this->conn->query($sql);
            if ($data) {
                $report = $data->fetchAll();
            } else {
                $report['counts'] = 0;
                $report['results_5'] = 0;
                $report['results_4'] = 0;
                $report['results_3'] = 0;
                $report['results_2'] = 0;
                $report['results_1'] = 0;
                $report['amount'] = 0;
                $report['prize'] = 0;
                $report['wins'] = 0;
            }
            return $report;
        } catch (Exception $e) {
            return false;
        }
    }
}