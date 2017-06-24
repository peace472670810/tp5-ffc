<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/14
 * Time: 11:49
 */

namespace app\Service\report\business;
use app\Service\report\model\orderReport;
use think\image\Exception;

class report
{
    public  static $error_code = [
        '120000001' => '请输入要查询的时间！',
        '120000002' => '开始时间不能大于结束时间',
        '120000003' => '用户层级有误！',
        '120000004' => '用户名不能为空！',
    ];
    public $report_model = null;
    public  function  __construct()
    {
        $this->report_model = new orderReport();
    }

    /**
     * 获取交付报表列表
     * @param array $data
     */
    public function getReportList($arr = [])
    {
        try {
            $data = $this->dataFilter($arr, 1);
            $list = $this->report_model->getReportList($data);
            return put_encode($list, '', '');
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }

    /**
     * 数据过滤
     * op 1 交付  2 会员  3 注单详情
     */
    public function dataFilter($arr, $op = 1)
    {
        $data = [];
        if (empty($arr['start_time']) || empty($arr['end_time'])) {
            throw new Exception(self::$error_code['120000001'], '120000001');
        }
        $data['start_time'] = $arr['start_time'];
        $data['end_time'] = $arr['end_time'];
        if (strtotime($data['end_time']) < strtotime($data['start_time'])) {
            throw new Exception(self::$error_code['120000002'], '120000002');
        }
        if ($arr['time_type']) {
            $data['start_time'] = date('Y-m-d H:i:s', strtotime($data['start_time']) + 12 * 60 * 60);
            $data['end_time'] = date('Y-m-d H:i:s', strtotime($data['end_time']) + 12 * 60 * 60);
        }
        $data['page'] = empty($arr['page']) ? 0 : $arr['page'];
        $data['pagecount'] = DEFAULT_PER_PAGE;
        switch ($op) {
            case 1 :
            case 2 :
                $data['u_level'] = $arr['u_level'];
                if (!is_numeric($data['u_level'])) {
                    throw new Exception(self::$error_code['120000003'], '120000003');
                }
                $data['u_level'] = $arr['u_level'];
                $data['top_name'] = 'u_top_' . $data['u_level'];
                $data['ffc_top_name'] = 'ffc_top_' . $data['u_level'];
                if (empty($arr['u_username'])) {
                    throw new Exception(self::$error_code['120000004'], '120000004');
                }
                $data['top_value'] = $arr['u_username'];
                break;
            case 3 :
                $data['ffc_username'] = $arr['u_username'];
                break;
        }
        return $data;
    }

    /**
     *注单详情
     */
    public function getReportDetail($arr = [])
    {
        try {
            $data = $this->dataFilter($arr, 3);
            $list = $this->report_model->getorderDetail($data);
            return put_encode($list, '', '');
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }

    /**
     * 用户报表
     */
    public function userReportList($arr = [])
    {
        try {
            $data = $this->dataFilter($arr, 2);
            $list = $this->report_model->userReportList($data);
            return put_encode($list, '', '');
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }
}