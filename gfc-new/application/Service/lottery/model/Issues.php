<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/31
 * Time: 11:16
 */

namespace app\Service\lottery\model;
use think\Model;
class Issues extends  Model
{
    /**
     * 获取奖期列表
     */
    public function getIssueList($data = []){

        $sql = "SELECT * FROM `ffc_issues` WHERE 1";
        $i_lid = $data['lid'];
        if ($i_lid > 0) {
            $sql .= " AND i_lid = " . intval($i_lid);
        }
        if (is_array($data['belong_date']) && count($data['belong_date']) == 2) {
            $sql .= " AND i_belong_date >='{$data['belong_date'][0]}' AND i_belong_date <= '{$data['belong_date'][1]}'";
        } elseif ($data['belong_date'] != '') {
            $sql .= " AND i_belong_date = '{$data['belong_date']}'";
        }
        if($data['before_date']){
            $sql .= " AND i_belong_date < '{$data['before_date']}'";
        }
        if ($data['start_sale_time1'] > 0) {
            $sql .= " AND i_start_sale_time > '" . date('Y-m-d H:i:s', $data['start_sale_time1']) . "'";
        }
        if ($data['start_sale_time2'] > 0) {
            $sql .= " AND i_start_sale_time < '" . date('Y-m-d H:i:s', $data['start_sale_time2']) . "'";
        }

        if ($data['end_sale_time1'] > 0) {
            $sql .= " AND i_end_sale_time > '" . date('Y-m-d H:i:s', $data['end_sale_time1']) . "'";
        }
        if ($data['end_sale_time2'] > 0) {
            $sql .= " AND i_end_sale_time < '" . date('Y-m-d H:i:s', $data['end_sale_time2']) . "'";
        }
        if (!empty($data['status_code'])) {
            $sql .= " AND i_status_code={$data['status_code']}";
        }
        if ($data['order_by']) {
            $sql .= " ORDER BY {$data['order_by']} ";
        } else {
            $sql .= " ORDER BY i_id DESC ";
        }
        if ($data['start'] > -1) {
            $sql .= " LIMIT {$data['start']}, {$data['amount']}";
        }
        return $this->query($sql);
    }
    /**
     * 生成奖期
     */
    public function addIussus($data = []){

    }

    /**
     *修改期数状态
     */
    public function editStatus($data = []){

    }

}