<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/31
 * Time: 19:29
 */

namespace app\Service\usersLogs\business;
use app\Service\usersLogs\model\Userlogs as userlogs_model;

class userlogs
{
    /**
     * 错误码
     * @var array
     */
    public static $error_code = [
            '9000010' => '添加sql有误！',
            '9000011' => '删除主键参数错误！',
            '9000012' => 'sql异常',
            '9000013' =>'页数必须为整数！'
        ];
    /**
     * 用户登录日志
     * @var null
     */
    public $logs_model = null;

    /**
     * 初始化
     * userlogs constructor.
     */
    public function __construct()
    {
        $this->logs_model =  new userlogs_model();
    }

    public function addUserLogs($arr = []){
        $data = array(
            'u_id'  => empty($arr['u_id'])?'':$arr['u_id'],
            'u_username'   => empty($arr['u_username'])?'':$arr['u_username'],
            'u_control'    => empty($arr['u_control'])?'':$arr['u_control'],
            'u_action'     => empty($arr['u_action'])?'':$arr['u_action'],
            'u_is_success' => empty($arr['u_is_success'])?0:$arr['u_is_success'],
            'u_remark'     => empty($arr['u_remark'])?'':$arr['u_remark'],
            'u_client_ip'  => empty($arr['u_client_ip'])?'':$arr['u_client_ip'],
            'u_proxy_ip'   => empty($arr['u_proxy_ip'])?'':$arr['u_proxy_ip'],
            'u_domain'     => empty($arr['u_domain'])?'':$arr['u_domain'],
            'u_date'       => date('Y-m-d H:i:s'),
        );
        $res = $this->logs_model->addUserLogs($data);
        if($res){
            return put_encode(true,'','添加成功');
        }
        return put_encode(false,'9000010',self::$error_code['9000010']);
    }

    /**
     * 日志删除 采取主键删除
     * 单个删除和批量删除
     */
    public function removeUserLogs($arr = []){
        $data = [];
        if(is_numeric($arr)){
            $data[] = $arr;
        }else if(is_array($arr)){
            foreach ($arr as $v){
                if(!is_numeric($v)){
                    return put_encode(false,'9000011',self::$error_code['9000011']);
                }
                $data[] = $arr;
            }
        }else{
            return put_encode(false,'9000011',self::$error_code['9000011']);
        }
        if($res = $this->logs_model->removeLogs($data)){
            return  put_encode(true,'','删除成功！');
        }else{
            return put_encode(false,'9000012',self::$error_code['9000012']);
        }
    }

    /**
     * 日志查询
     * ip 查询
     * 日期查询
     * 用户名查询
     * 页数 为空默认第一页
     */
    public function getList($arr = []){
        if(empty($arr)&&is_array($arr)){
            return put_encode(false,'','');
        }
        $data = [];
        $data['u_client_ip'] = empty($arr['u_client_ip'])?'':$arr['u_client_ip'];
        $data['u_username'] = empty($arr['u_username'])?'':$arr['u_username'];
        $start_time = empty($arr['start_time'])?'':$arr['start_time'];
        $end_time = empty($arr['end_time'])?'':$arr['end_time'];
        $page = empty($arr['page'])?0:$arr['page'];
        if(!is_numeric($page)){
            return put_encode(false,'9000013',self::$error_code['9000013']);
        }
        $sql = "select * from `ffc_userlogs`  where 1 ";
        $where = '';
        if(!empty($data['u_client_ip'])){
            $where .= " and  u_client_ip='{$data['u_client_ip']}' ";
        }
        if(!empty($data['u_username'])){
            $where .= " and u_username = '{$data['u_username']}' ";
        }
        if($start_time&&$end_time){
            $where .= " and u_date  between '$start_time' and '$end_time' ";
        }
        $start = DEFAULT_PER_PAGE*$page;
        $sql .= $where." order by u_date desc  limit $start,".DEFAULT_PER_PAGE;
        $list['data'] = $this->logs_model->query($sql);
        if(!empty($list['data'])){
            $sql_count = "select count(*)  from `ffc_userlogs` where 1".$where;
            $pacgecount = $this->logs_model->query($sql_count);
            $list['page']['count'] = $pacgecount[0]['count(*)'];
            $list['page']['total'] = ceil($list['page']['count']/DEFAULT_PER_PAGE);
            $list['page']['pre'] = ($page-1)<=0?0:($page -1);
            $list['page']['next'] = $page+1;
            $list['page']['start'] = $start+1;
            $list['page']['end'] = DEFAULT_PER_PAGE*($page+1);
            return  put_encode($list,'','查询成功');
        }else{
            return put_encode(true,'','');
        }
    }
}