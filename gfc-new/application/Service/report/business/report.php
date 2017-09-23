<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/14
 * Time: 11:49
 */

namespace app\Service\report\business;
use app\Service\report\model\orderReport;
use think\Exception;

class report
{
    public  static $error_code = [
        '120000001' => '请输入要查询的时间！',
        '120000002' => '开始时间不能大于结束时间',
        '120000003' => '用户层级有误！',
        '120000004' => '用户名不能为空！',
        '120000005' => '越层级查询！非法！！',
        '120000006' => '没有权限查看该会员',
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
        $data = $this->dataFilter($arr, 1);
        if(is_array($data)){
            $list = $this->report_model->getReportList($data);
            return put_encode($list, '', '');
        }
        //halt($data);
        return $data;
    }

    /**
     * 数据过滤
     * op 1 交付  2 会员  3 会员详情列表
     */
    public function dataFilter($arr, $op = 1)
    {
        try {
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
                    if(!empty($arr['u_level'])){
                        if ( !is_numeric($arr['u_level']) ) {
                            throw new Exception(self::$error_code['120000003'], '120000003');
                        }
                    }

                    if($arr['u_level'] > $arr['sess_level']){
                        throw new Exception(self::$error_code['120000005'], '120000005');
                    }
                    $data['bytype']=$arr['bytype'];
                    $data['u_level'] =$arr['u_level'];
                    $data['u_username'] = $arr['u_username'];
                    $data['sess_level'] = $arr['sess_level'];
                    $data['sess_name'] = $arr['sess_name'];
                    break;
                case 2 :           
                    if(!empty($arr['u_level'])){
                        if ( !is_numeric($arr['u_level']) ) {
                            throw new Exception(self::$error_code['120000003'], '120000003');
                        }
                    }
                    if (empty($arr['u_username'])) {
                        throw new Exception(self::$error_code['120000004'], '120000004');
                    }

                    if (!empty($arr['name'])) {
                        $data['name'] = $arr['name'];
                    }
                    $data['bytype']=$arr['bytype'];
                    $data['u_level'] = $arr['u_level']; 
                    $data['u_username'] = $arr['u_username'];
                    break;
                case 3 :
                    if (empty($arr['u_username'])) {
                        throw new Exception(self::$error_code['120000004'], '120000004');
                    }
                    $data['bytype']=$arr['bytype'];
                    $data['o_username'] = $arr['u_username'];
                    $data['sess_level'] = $arr['sess_level']; 
                    $data['sess_name'] = $arr['sess_name'];
                    break;
            }
            return $data;
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }

    /**
     *会员详情列表
     */
    public function getReportDetail($arr = [])
    {
        try {
            $data = $this->dataFilter($arr, 3);
            if(is_array($data)){
                $list = $this->report_model->getorderDetail($data);
            }else{
                return  $data;
            }    
            $list = $this->report_model->getorderDetail($data);
            if(empty($list)){
                throw new Exception(self::$error_code['120000006'], '120000006');
            }
            return put_encode($list, '', '');
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }

    /**
     * 会员报表
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