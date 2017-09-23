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

        $where='';
        $data ='';
        $list = [];
        $page = empty($arr['page']) ? 0 : $arr['page'];
        if (!empty($arr['start_time']) && !empty($arr['end_time'])) {
            $arr['start_time']=strtotime($arr['start_time'])*1000;
            $arr['end_time']=strtotime($arr['end_time'])*1000;
            $where.=" o_draw_time between '{$arr['start_time']}' and '{$arr['end_time']}'";
        }
        //层级查询权限
        if($arr['sess_level'] != '5' ){
            $where.=" and o_top{$arr['sess_level']} = '{$arr['sess_name']}' ";
        }
        //从页面往下跳转进入下级
        if( !empty($arr['u_level']) && !empty($arr['u_username']) ){
            $shu=$arr['u_level']-1;
            $where.=" and o_top{$arr['u_level']} = '{$arr['u_username']}' ";
            //会员报表
            if($shu == 0){
                $sql="select o_username, sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1, sum(o_counts) as counts,sum(o_win5) as o_win5,sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1,sum(o_amounts) as o_amount,sum(o_wins) as wins,sum(o_amounts5) as o_amount5,sum(o_amounts4) as o_amount4,sum(o_amounts3) as o_amount3,sum(o_amounts2) as o_amount2,sum(o_amounts1) as o_amount1,sum(o_result) as o_result from  ffc_order_report where o_deleteflag = 0  and ".$where." group by  o_username ";

                $sq="select count(*) as counts from (select o_username from ffc_order_report where o_deleteflag = 0 and " . $where." GROUP  BY  o_username )  as tmp";

            }else{
            //其他层级报表
                $sql="select o_top{$shu}, sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1, sum(o_counts) as counts,sum(o_win5) as o_win5,sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1,sum(o_amounts) as o_amount,sum(o_wins) as wins,sum(o_amounts5) as o_amount5,sum(o_amounts4) as o_amount4,sum(o_amounts3) as o_amount3,sum(o_amounts2) as o_amount2,sum(o_amounts1) as o_amount1,sum(o_result) as o_result from ffc_order_report where  o_deleteflag=0 and ".$where." group by  o_top{$shu} ";
                
                 $sq="select count(*) as counts from (select o_top{$shu} from ffc_order_report where o_deleteflag = 0 and " . $where." GROUP  BY  o_top{$shu} )  as tmp";


           //$sq=" select count(DISTINCT o_top{$shu}) as counts, o_top{$shu}  from ffc_order_report where  o_deleteflag=0 and ".$where." group by  o_top{$shu} ";

            }

        }else{
            //从二级导航栏进入
            $shu=$arr['sess_level']-1;
            if($shu == 0){
                //会员报表
                $sql="select o_username, sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1, sum(o_counts) as counts,sum(o_win5) as o_win5,sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1,sum(o_amounts) as o_amount,sum(o_wins) as wins,sum(o_amounts5) as o_amount5,sum(o_amounts4) as o_amount4,sum(o_amounts3) as o_amount3,sum(o_amounts2) as o_amount2,sum(o_amounts1) as o_amount1,sum(o_result) as o_result from ffc_order_report where  o_deleteflag=0 and ".$where." group by  o_username ";

                $sq="select count(*) as counts from (select o_username from ffc_order_report where o_deleteflag = 0 and " . $where." GROUP  BY  o_username )  as tmp";
            }else{
                //其他层级报表
                $sql="select o_top{$shu} ,sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1, sum(o_counts) as counts,sum(o_win5) as o_win5,sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1,sum(o_amounts) as o_amount,sum(o_wins) as wins,sum(o_amounts5) as o_amount5,sum(o_amounts4) as o_amount4,sum(o_amounts3) as o_amount3,sum(o_amounts2) as o_amount2,sum(o_amounts1) as o_amount1,sum(o_result) as o_result from ffc_order_report where  o_deleteflag=0 and ".$where." group by  o_top{$shu} ";
                  
                $sq="select count(*) as counts from (select o_top{$shu} from ffc_order_report where o_deleteflag = 0 and " . $where." GROUP  BY  o_top{$shu} )  as tmp";

                //$sq=" select count(DISTINCT o_top{$shu}) as counts, o_top{$shu}  from ffc_order_report where  o_deleteflag=0 and ".$where." group by  o_top{$shu} ";

            }
        }
        switch ($arr['bytype']) {
                    case'1'://投注金额
                         $sql .=" order by o_amount  ";
                        break;
                    case '2'://投注金额
                         $sql .=" order by o_amount desc ";
                        break;
                    case '3'://结果
                         $sql .=" order by o_result  ";
                        break;
                    case '4'://结果
                         $sql .=" order by o_result desc ";
                        break;
                    default:
                        break;
                }
        $page = $arr['page'];
        $start = $page*$arr['pagecount'];
        $countdata=$this->conn->query($sq);
        if(empty($countdata)){
            return false;
        }else{
            $countdata = $countdata->fetch();

        }
        $count = $countdata['counts'];
        $sql .=" limit  ".$arr['pagecount']." offset ".$start;
        $res = $this->conn->query($sql);
        if ($res) {
            $dataes['list'] = $res->fetchAll();
            $dataes['page']['count'] = $count;
            $dataes['page']['totalpage'] = ceil($count/$arr['pagecount']);
            $dataes['page']['pre'] = ($page - 1) <= 0 ? 0 : ($page - 1);
            $dataes['page']['next'] = $page + 1;
            $dataes['page']['start'] = $arr['pagecount'] * $page + 1;
            $dataes['page']['end'] = $arr['pagecount'] * ($page + 1);
            $dataes['text'] = $this->getOne($where);
        } else{
            return $res;
        }
        return $dataes;


    }

    /**
     * 会员详情列表
     */
    public function getorderDetail($data = [])
    { 
        $arr = [];
        $where = " where o_deleteflag = 0 and o_is_cancel = 0  and  o_username='{$data['o_username']}'";
        if (!empty($data['start_time']) && !empty($data['end_time'])) {

            $start_time=strtotime($data['start_time'])*1000;
            $end_time=strtotime($data['end_time'])*1000;
            $where .= " and o_draw_time between '{$start_time}' and '{$end_time}'";
        }
        switch ($data['sess_level']) {
            case '5':
                $where .= "";
                break;
            case '4':
                $where .= " and  o_top4 = '{$data['sess_name']}'  ";
                break;
            case '3':
                $where .= " and  o_top3 = '{$data['sess_name']}'  ";
                break;
            case '2':
                $where .= " and  o_top2 = '{$data['sess_name']}'  ";
                break;
            case '1':
                $where .= " and  o_top1 = '{$data['sess_name']}'  ";
                break;
            default:
                return false;
                break;
        }
        $page = $data['page'];
        $start = $page*$data['pagecount'];
        $sqlcount = "select count(*) from ffc_order".$where;
        $sql = "select  * from  ffc_order ".$where;
        switch ($data['bytype']) {
                    case'1'://投注金额
                         $sql .=" order by o_amount  ";
                        break;
                    case '2'://投注金额
                         $sql .=" order by o_amount desc ";
                        break;
                    case '3'://奖期截止时间
                         $sql .=" order by o_draw_time  ";
                        break;
                    case '4'://奖期截止时间
                         $sql .=" order by o_draw_time desc ";
                        break;
                    case '5'://中奖金额
                        $sql  .=" order by o_wins  ";
                        break;
                    case '6'://中奖金额
                         $sql .=" order by o_wins desc ";
                        break;
                    default:
                        break;
                }
        
        $sql .=" limit  ".$data['pagecount']." offset ".$start;
        try {
            $countdata = $this->conn->query($sqlcount);
            if(empty($countdata)){
                return false;
            }
            $countdata = $countdata->fetch();
            $count = $countdata['count(*)'];
            $res = $this->conn->query($sql);
            if($res){
                $arr['list'] = $res->fetchAll();
                $arr['page']['count'] = $count;
                $arr['page']['totalpage'] = ceil($count/$data['pagecount']);
                $arr['page']['pre'] = ($page - 1) <= 0 ? 0 : ($page - 1);
                $arr['page']['next'] = $page + 1;
                $arr['page']['start'] = $data['pagecount'] * $page + 1;
                $arr['page']['end'] = $data['pagecount'] * ($page + 1);
                foreach ($arr['list'] as $key => $value) {
                    $arr['list'][$key]['o_amount']    = bcdiv($value['o_amount'], 1000000,4);
                    $arr['list'][$key]['o_amount1']   = bcdiv($value['o_amount1'], 1000000,4);
                    $arr['list'][$key]['o_amount2']   = bcdiv($value['o_amount2'], 1000000,4);
                    $arr['list'][$key]['o_amount3']   = bcdiv($value['o_amount3'], 1000000,4);
                    $arr['list'][$key]['o_amount4']   = bcdiv($value['o_amount4'], 1000000,4);
                    $arr['list'][$key]['o_amount5']   = bcdiv($value['o_amount5'], 1000000,4);
                    $arr['list'][$key]['o_add_time']  = date('Y-m-d H:i:s',(bcdiv($value['o_add_time'],1000)));
                    $arr['list'][$key]['o_draw_time'] = date('Y-m-d H:i:s',(bcdiv($value['o_draw_time'],1000)));
                    if($value['o_wins'] !== 0){
                        $arr['list'][$key]['o_wins']  = bcdiv($value['o_wins'], 1000000,4);
                    }
                }
                return  $arr;
            }
            return false;
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
        switch ($data['u_level']) {
            case '5':
                $where = " ";
                break;
            case '4':
                $where = " and  o_top4 = '{$data['u_username']}'  ";
                break;
            case '3':
                $where = " and  o_top3 = '{$data['u_username']}'  ";
                break;
            case '2':
                $where = " and  o_top2 = '{$data['u_username']}'  ";
                break;
            case '1':
                $where = " and  o_top1 = '{$data['u_username']}'  ";
                break;
            default:
                return false;
                break;
        }
        if(!empty($data['name'])){
           $where .= " and o_username = '{$data['name']}' ";
        }
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $start_time=strtotime($data['start_time'])*1000;
            $end_time=strtotime($data['end_time'])*1000;
            $where .= " and o_draw_time between '{$start_time}' and '{$end_time}'";
        }
        $page = $data['page'];
        $start = $page*$data['pagecount'];
        $sqlcount = "select count(*) from (select o_username from ffc_order_report where o_deleteflag = 0 " . $where." GROUP  BY  o_username )  as tmp";
        $sql = " select o_username as u_username,sum(o_counts) as counts,sum(o_amounts) as amount,sum(o_wins) as wins,sum(o_result)as result from  ffc_order_report where o_deleteflag = 0 " . $where . " group by o_username";
        
        switch ($data['bytype']) {
                    case'1'://投注金额
                         $sql .=" order by amount  ";
                        break;
                    case '2'://投注金额
                         $sql .=" order by amount desc ";
                        break;
                    case '3'://奖期截止时间
                         $sql .=" order by wins  ";
                        break;
                    case '4'://奖期截止时间
                         $sql .=" order by wins desc ";
                        break;
                    case '5'://中奖金额
                        $sql  .=" order by result  ";
                        break;
                    case '6'://中奖金额
                         $sql .=" order by result desc ";
                        break;
                    case '7'://订单量
                        $sql  .=" order by counts  ";
                        break;
                    case '8'://订单量
                         $sql .=" order by counts desc ";
                        break;
                    default:
                        break;
                }
        $sql .=" limit  ".$data['pagecount']." offset ".$start;
        try {
            $countdata = $this->conn->query($sqlcount);
            if(empty($countdata)){
                return false;
            }
            $countdata = $countdata->fetch();
            $count = $countdata['count(*)'];
            $res = $this->conn->query($sql);
            if($res){
                $arr['list'] = $res->fetchAll();
                $arr['page']['count'] = $count;
                $arr['page']['totalpage'] = ceil($count/$data['pagecount']);
                $arr['page']['pre'] = ($page - 1) <= 0 ? 0 : ($page - 1);
                $arr['page']['next'] = $page + 1;
                $arr['page']['start'] = $data['pagecount'] * $page + 1;
                $arr['page']['end'] = $data['pagecount'] * ($page + 1);
            }
            return $arr;
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * 汇总数据
     */
    public function getOne($where){
        $sql="select sum(o_counts) as counts,sum(o_win5) as o_win5,sum(o_win4) as o_win4,sum(o_win3) as o_win3,sum(o_win2) as o_win2,sum(o_win1) as o_win1,sum(o_amounts) as o_amount,sum(o_wins) as wins,sum(o_amounts5) as o_amount5,sum(o_amounts4) as o_amount4,sum(o_amounts3) as o_amount3,sum(o_amounts2) as o_amount2,sum(o_amounts1) as o_amount1 from  ffc_order_report where o_deleteflag = 0  and ". $where;
        $data = $this->conn->query($sql);
        if($data){
            return $data->fetch();
        }
        return false;
    }

}