<?php
namespace app\Service\order\business;
use app\Service\DS\business\adminWallet as DS;
use app\Service\lottery\business\config;
use think\image\Exception;
use app\Service\order\model\Order as orderData;
use app\Service\lottery\business\methods as methodsOne;
use app\Service\drawhistory\business\drawhistory as drawhistory_model;

class Order
{
    public $model = null;
    static $RECORD_URL= null;
    public function __construct()
    {
        $this->model = new orderData();
    }

    public static $error_code = [
        '3000000' => '参数非法!',
        '3000001' => '没有查询到订单!',
        '3000002' => '没有权限查看该订单详情!',
        '3000003' => '订单编号错误!',
        '3000004' => '彩种编号错误!',
        '3000005' => '追号编号不符合规则!',
        '3000006' => '没有权限查看该订单!',
        '3000007' => '订单不存在!',
        '3000008' => '订单不存在或者订单已派彩!',
        '3000009' => '订单编号错误！',
        '3000010' => '查询等级不够！',
        '3000011' => '网站ID不能为空！',
        '3000012' => '查询开始时间不能为空！',
        '3000013' => '查询结束时间不能为空！',
        '3000014' => '查询用户名不能为空！',
        '3000015' => '转账类型不能为空！',
        '3000016' => '网站ID错误！',
    ];

    /**
     * 注单搜索
     * @param $data
     * @return string
     */
    public function search($data)
    {
        try {
            if(!empty($data['ffc_id'])  &&  !is_numeric($data['ffc_id']) ){
                throw new Exception(self::$error_code['3000009'], '3000009');
            }
            if($data['order_state'] == 1){//已经派彩
                $table = 'ffc_order';
            }else{
                if(!empty($data['ffc_lid'])){//直接查临时表
                    $table = 'ffc_order_'.$data['ffc_lid'].'_temp';
                }else{//查全部查视图
                    $table = 'ffc_orders_temp';
                }
            }
            $sql = 'select * from '.$table.' where  o_deleteflag = 0  ';
            $sqlcount = 'select count(*) from '.$table.' where o_deleteflag = 0  ';
            $where = '';
                
            if($data['order_state'] == 1) {//已经派彩
                if (!empty($data['start_time'] && !empty($data['end_time']))) {
                    $start_time = strtotime($data['start_time']) * 1000;
                    $end_time = strtotime($data['end_time']) * 1000;
                    $where .= " and o_draw_time between '$start_time' and '$end_time' ";
                }
                }else{
                if (!empty($data['start_time'] && !empty($data['end_time']))) {
                    $start_time = $data['start_time'];
                    $end_time = $data['end_time'];
                    $where .= "and o_draw_time between '$start_time' and '$end_time' ";
                }
            }
                //ffc_id   ffc_lid  ffc_mg_id   ffc_issue   ffc_username

                if(!empty($data['ffc_lid'])){//有彩种才有玩法和奖期
                    $where .=" and o_lid=".$data['ffc_lid'];
                    if(!empty($data['ffc_mg_id'])){
                    $where .=" and o_mg_id=".$data['ffc_mg_id'];
                    }
                    if(!empty($data['ffc_issue'])){
                        $where .=" and o_issue=".$data['ffc_issue'];
                    }
                }
                
                if(!empty($data['ffc_username'])){
                    $where .=" and o_username='{$data['ffc_username']}'";
                }
                //注单订单iD直接覆盖其他条件
                if(!empty($data['ffc_id'])){//订单id
                    $where =" and  o_id=".unOrderWrapId($data['ffc_id']);
                }
                switch ($data['ffc_level']) {
                    case'5'://总公司搜索
                        break;
                    case '4'://分公司搜索
                        $where .= " and o_top_4='{$data['ffc_name']}' ";
                        break;
                    case '3'://股东搜索
                        $where .= " and o_top_3='{$data['ffc_name']}' ";
                        break;
                    case '2'://总代搜索
                        $where .= " and o_top_2='{$data['ffc_name']}' ";
                        break;
                    case '1'://代理搜索
                        $where .= " and o_top_1='{$data['ffc_name']}' ";
                        break;
                    default:
                        throw new Exception(self::$error_code['3000000'], '3000000');
                        break;
                }
                $page = empty($data['page']) ? 0 : $data['page'];
            $sql .= $where;
            $start = $page * DEFAULT_PER_PAGE;
           switch ($data['bytype']) {
                    case'1'://投注金额
                        $sql.="  order by o_amount  ";
                        break;
                    case '2'://投注金额
                        $sql.="  order by o_amount desc ";
                        break;
                    case '3'://奖期截止时间
                        $sql.="  order by o_draw_time  ";
                        break;
                    case '4'://奖期截止时间
                        $sql.="  order by o_draw_time desc ";
                        break;
                    case '5'://中奖金额
                       $sql.="  order by o_wins  ";
                        break;
                    case '6'://中奖金额
                        $sql.="  order by o_wins desc ";
                        break;
                    default:
                        break;
                }
            if($data['order_state'] == 1){//已经派彩
                $sql .= ' limit ' . DEFAULT_PER_PAGE . ' offset ' . $start;
            }else{//还未派彩
                $sql .= ' limit '.$start.','.DEFAULT_PER_PAGE ;
            }
            $sqlcount .= $where;
            //halt($sql);
            $arr = $this->model->getOrder($sql, $sqlcount, $data['order_state']);
            if(empty($arr)){
                 throw new Exception(self::$error_code['3000001'], '3000001');
            }
            $res['page']['count'] = $arr['count'];//总数量
            $res['page']['pre'] = $page<=0?0:$page;//前一页
            $res['page']['next'] = $page + 2;//下一页
            $res['page']['totalPage'] = ceil($res['page']['count'] / DEFAULT_PER_PAGE);//总页数
            $res['page']['start'] = $page*DEFAULT_PER_PAGE;//开始页
            $res['page']['end'] = ($page+ 1)*DEFAULT_PER_PAGE;//结束页
            $list = $arr['list'];
            if($data['order_state'] == 1){//已经派彩
                foreach ($list as $key => $value) {
                    $list[$key]['o_amount'] = bcdiv($value['o_amount'], 1000000, 4);
                    if ($value['o_amount1'] !== 0) {
                        $list[$key]['o_amount1'] = bcdiv($value['o_amount1'], 1000000, 4);
                    }
                    if ($value['o_amount2'] !== 0) {
                        $list[$key]['o_amount2'] = bcdiv($value['o_amount2'], 1000000, 4);
                    }
                    if ($value['o_amount3'] !== 0) {
                        $list[$key]['o_amount3'] = bcdiv($value['o_amount3'], 1000000, 4);
                    }
                    if ($value['o_amount4'] !== 0) {
                        $list[$key]['o_amount4'] = bcdiv($value['o_amount4'], 1000000, 4);
                    }
                    if ($value['o_amount5'] !== 0) {
                        $list[$key]['o_amount5'] = bcdiv($value['o_amount5'], 1000000, 4);
                    }
                    $list[$key]['o_add_time'] = date('Y-m-d H:i:s', ($value['o_add_time'] / 1000));
                    $list[$key]['o_draw_time'] = date('Y-m-d H:i:s', ($value['o_draw_time'] / 1000));
                    if ($value['o_wins'] !== 0) {
                        $list[$key]['o_wins'] = bcdiv($value['o_wins'], 1000000, 4);
                    }
                }
            }
            $res['list'] = $list;
            return put_encode($res, '', '');
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }

    //追号订单
    public function tracelist($data)
    {
        try {
            $sql = "select * from ffc_traces where 1 ";
            $sqlcount = "select count(*) from  ffc_traces where 1 ";
            $where = '';
            if (!empty($data['ffc_id'])) {//根据追号注单
                $data['ffc_id'] = trim($data['ffc_id']);
                $ffc_id = unOrderWrapId($data['ffc_id']);
                if ($ffc_id) {
                    $where .= " and t_id='{$ffc_id}'";
                }
            }
            if (!empty($data['ffc_username'])) {//根据用户名
                $data['ffc_username'] = trim($data['ffc_username']);
                $where .= " and t_username='{$data['ffc_username']}'";
            }
            if (!empty($data['ffc_lid'])) {//根据彩种
                if (is_numeric($data['ffc_lid'])) {
                    $where .= " and t_lid='{$data['ffc_lid']}'";
                } else {
                    throw new Exception(self::$error_code['3000004'], '3000004');
                }
            }
            if (!empty($data['t_start_issue'])) {//根据开始期数
                $where .= " and t_start_issue='{$data['t_start_issue']}'";
            }
            switch ($data['ffc_level']) {//用户层级
                case '5':
                    $where .= " ";
                    break;
                case '4':
                    $where .= " and t_top_4='{$data['ffc_name']}'";
                    break;
                case '3':
                    $where .= " and t_top_3='{$data['ffc_name']}'";
                    break;
                case '2':
                    $where .= " and t_top_2='{$data['ffc_name']}'";
                    break;
                case '1':
                    $where .= " and t_top_1='{$data['ffc_name']}'";
                    break;
                default:
                    throw new Exception(self::$error_code['3000000'], '3000000');
                    break;
            }
            if (!empty($data['start_time']) && !empty($data['end_time'])) {
                $where .= " and t_add_time between '{$data['start_time']}' and '{$data['end_time']}'  ";
            }
            $page = $data['page'];
            $start = $page * DEFAULT_PER_PAGE;;
            $sqlcount .=$where;
            $count = $this->model->query($sqlcount);
             switch ($data['bytype']) {
                    case'1'://投注金额
                         $where .=" order by t_total_amount  ";
                        break;
                    case '2'://投注金额
                         $where .=" order by t_total_amount desc ";
                        break;
                    case '3'://奖期截止时间
                         $where .=" order by t_add_time  ";
                        break;
                    case '4'://奖期截止时间
                         $where .=" order by t_add_time desc ";
                        break;
                    // case '5'://中奖金额
                    //     $where  .=" order by t_wins  ";
                    //     break;
                    // case '6'://中奖金额
                    //      $where .=" order by t_wins desc ";
                        // break;
                    default:
                        break;
                }
            $where.=" limit ".$start.",".DEFAULT_PER_PAGE;
            $sql .=$where;
            $text = $this->model->query($sql);
            $res['page']['count'] = $count[0]['count(*)'];//总数量
            $res['page']['pre'] = $page<=0?0:$page;//前一页
            $res['page']['next'] = $page + 2;//下一页
            $res['page']['totalPage'] = ceil($res['page']['count'] / DEFAULT_PER_PAGE);//总页数
            $res['page']['start'] = $page*DEFAULT_PER_PAGE;//开始页
            $res['page']['end'] = ($page+ 1)*DEFAULT_PER_PAGE;//结束页
            $res['list'] = $text;
            if ($res) {
                return put_encode($res,'','');
            } else {
                return put_encode(false,'','');
            }
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }

    }

    public function traceDetail($data)
    {
        try {
            if (!empty($data['ffc_id'])) {
                if (is_numeric($data['ffc_id'])) {
                    $ffc_id = $data['ffc_id'];
                } else {
                    $data['ffc_id'] = trim($data['ffc_id']);
                    $ffc_id = unOrderWrapId($data['ffc_id']);
                }
                if ($ffc_id) {
                    $sql = "select * from ffc_traces where 1";
                    $sql .= " and t_id='{$ffc_id}'";
                    switch ($data['ffc_level']) {
                        case '5':
                            $sql .= " ";
                            break;
                        case '4':
                            $sql .= " and t_top_4='{$data['ffc_name']}'";
                            break;
                        case '3':
                            $sql .= " and t_top_3='{$data['ffc_name']}'";
                            break;
                        case '2':
                            $sql .= " and t_top_2='{$data['ffc_name']}'";
                            break;
                        case '1':
                            $sql .= " and t_top_1='{$data['ffc_name']}'";
                            break;
                        default:
                            throw new Exception(self::$error_code['3000000'], '3000000');
                            break;
                    }
                    $text = $this->model->query($sql);
                    if ($text) {
                        //halt($text);
                       switch ($data['ffc_level']) {
                        case 1://代理查看权限
                              if($data['ffc_name'] != $text[0]['t_top_1']){
                              throw new Exception(self::$error_code['3000002'], '3000002');}
                            break;
                        case 2://总代理查看权限
                              if($data['ffc_name'] != $text[0]['t_top_2']){
                              throw new Exception(self::$error_code['3000002'], '3000002');}
                            break;
                        case 3://股东查看权限
                              if($data['ffc_name'] != $text[0]['t_top_3']){
                              throw new Exception(self::$error_code['3000002'], '3000002');}
                            break;
                        case 4://分公司查看权限
                              if($data['ffc_name'] != $text[0]['t_top_4']){
                              throw new Exception(self::$error_code['3000002'], '3000002');}
                            break;
                        case 5://总公司查看权限
                             if($data['ffc_name'] != "admin"){
                             throw new Exception(self::$error_code['3000002'], '3000002');}
                            break;
                        default:
                            throw new Exception(self::$error_code['3000002'], '3000002');
                            break;
                        }
                        $text['0']['ffc_id'] = $data['ffc_id'];
                        $text['0']['cname'] = $this->traceCname($text['0']);
                        $text['0']['detail'] = $this->traceMany($text['0']);
                        return $text['0'];
                    } else {
                        throw new Exception(self::$error_code['3000007'], '3000007');
                    }
                } else {
                    throw new Exception(self::$error_code['3000005'], '3000005');
                }
            }
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }

    public function traceCname($data)
    {
        $text = json_decode($data['t_detail'], true);
        $methodsOne = new methodsOne();
        foreach ($text as $ke => $va) {
            $methods['m_id'] = $va['m_id'];
            $m_cname = json_decode($methodsOne->getMothodDetail($methods), true);
            if (!$m_cname['data']) {
                return json_encode($m_cname);
            }
            $text[$ke]['m_cname'] = $m_cname['data']['m_cname'];
            $number = explode('|', $va['code']);
            foreach ($number as $key => $value) {
                global $shuzi;
                $zushu['code'] = $value;
                $zushu['m_id'] = $va['m_id'];
                $shuzi += json_decode($methodsOne->getCodeNums($zushu), true)['data'];
                $text[$ke]['zushu'] = $shuzi;
            }
            unset($GLOBALS['shuzi']);

        }
        return $text;
    }

    public function traceMany($data)
    {

        if ($data['t_status'] == '0') {
            //全部查询sql
            $t_trace_times = $data['t_start_issue'] + $data['t_trace_times'];
            $sql = 'select * from ffc_order_' . $data['t_lid'] . '_temp where 1 and o_trace_id = ' . "'{$data['t_id']}'" . ' and  o_issue between ' . "'{$data['t_start_issue']}'" . ' and ' . "'{$t_trace_times}' and o_deleteflag = 0   order by  o_issue ";
            $text =$this->model->query($sql);
            return $text;
        } else {
            $t_trace_times = $data['t_start_issue'] + $data['t_trace_times'];
            $sql = 'select * from ffc_order where  o_trace_id = ' . "'{$data['t_id']}'" . ' and  o_issue between ' . "'{$data['t_start_issue']}'" . ' and ' . "'{$t_trace_times}' and o_deleteflag = 0   order by  o_issue ";
            $a = $this->model->getOrderDetailFromCrate($sql);
            foreach ($a as $key => $value){
                $a[$key]['o_amount'] = bcdiv($value['o_amount'], 1000000, 4);
                $a[$key]['o_wins'] = bcdiv($value['o_wins'], 1000000, 4);
            }
            $sql = 'select * from ffc_order_' . $data['t_lid'] . '_temp where 1 and o_trace_id = ' . "'{$data['t_id']}'" . ' and  o_issue between ' . "'{$data['t_start_issue']}'" . ' and ' . "'{$t_trace_times}' and o_deleteflag = 0  order by  o_issue ";
            $b = $this->model->query($sql);
            $text = array_merge($a, $b);
            return $text;
        }
    }

    public function traceIssue($text)
    {
        $result = array();
        foreach ($text['detail'] as $key => $info) {
            $result[$info['o_issue']][] = $info;
        }
        $arr = array();
        foreach ($result as $key => $value) {
            foreach ($value as $k => $v) {
                global $o_amount;
                global $o_single_num;
                global $o_wins;
                $arr[$key]['o_multiple'] = $v['o_multiple'];
                $arr[$key]['o_modes'] = $v['o_modes'];
                $arr[$key]['o_issue'] = $v['o_issue'];
                $arr[$key]['o_lid'] = $v['o_lid'];
                $arr[$key]['o_is_cancel'] = $v['o_is_cancel'];
                $arr[$key]['o_is_pay'] = $v['o_is_pay'];
                $o_amount += $v['o_amount'];
                $o_single_num += $v['o_single_num'];
                $o_wins += $v['o_wins'];
            }
            $arr[$key]['o_wins'] = $o_wins;
            $arr[$key]['o_amount'] = $o_amount;
            $arr[$key]['o_single_num'] = $o_single_num;
            unset($GLOBALS['o_amount']);
            unset($GLOBALS['o_single_num']);
            unset($GLOBALS['o_wins']);
        }
        $new = new drawhistory_model();
        foreach ($arr as $key => $value) {
            $data['lid'] = $value['o_lid'];
            $data['qishu'] = $value['o_issue'];
            $arr[$key]['ds_balls'] = $new->orderIssue($data);
        }
        return $arr;
    }

    public function orderDetail($data)
    {
        try {
            $o_id = unOrderWrapId($data['o_id']);
            $lid = $data['lid'];
            $mg_id = $data['mg_id'];
            $issue = $data['issue'];
            $sql = "select * from ffc_order_".$lid."_".$mg_id."_".mode10Issues($issue)." where  o_id= $o_id limit 1";
            $text = $this->model->getOrderDetail($sql);
            if(empty($text)){
               throw new Exception(self::$error_code['3000001'], '3000001');
            }
            switch ($data['ffc_level']) {
                    case 1://代理查看权限
                          if($data['ffc_name'] != $text[0]['o_top_1']){
                          throw new Exception(self::$error_code['3000002'], '3000002');}
                        break;
                    case 2://总代理查看权限
                          if($data['ffc_name'] != $text[0]['o_top_2']){
                          throw new Exception(self::$error_code['3000002'], '3000002');}
                        break;
                    case 3://股东查看权限
                          if($data['ffc_name'] != $text[0]['o_top_3']){
                          throw new Exception(self::$error_code['3000002'], '3000002');}
                        break;
                    case 4://分公司查看权限
                          if($data['ffc_name'] != $text[0]['o_top_4']){
                          throw new Exception(self::$error_code['3000002'], '3000002');}
                        break;
                    case 5://总公司查看权限
                         if($data['ffc_name'] != "admin"){
                         throw new Exception(self::$error_code['3000002'], '3000002');}
                        break;
                    default:
                        throw new Exception(self::$error_code['3000002'], '3000002');
                        break;
                }
            $o_hit_detail = [];
            if(!empty($text['0']['o_hit_detail'])){
                $o_hit_detail = json_decode($text['0']['o_hit_detail'], true);
            }
            $methodsOne = new methodsOne();
            $var=array();
            if (!empty($text['0']['o_wins']) ||$text['0']['o_wins']>0) {
                foreach ($o_hit_detail as $key => $value) {
                    if (!empty($value['hit'])) {
                        $methods['m_id'] = $value['mid'];
                        $m_cname = json_decode($methodsOne->getMothodDetail($methods), true);
                        if (!$m_cname['data']) {
                            return json_encode($m_cname);
                        }
                        $var[$key]['c_name'] = $m_cname['data']['m_cname'];
                        $var[$key]['mid'] = $value['mid'];
                        $var[$key]['number'] = $value['number'];
                        $var[$key]['hit'] = $value['hit'];
                    }
                }
            } 
            $text['0']['o_hit_detail']=$var;     
            $odd = json_decode($text['0']['o_odd'], true);
            $code = json_decode($text['0']['o_code'], true);
            foreach ($code as $k => $v) {
                $methods['m_id'] = $v['mid'];
                $m_cname = json_decode($methodsOne->getMothodDetail($methods), true);
                if (!$m_cname['data']) {
                    return json_encode($m_cname);
                }
                $code[$k]['m_cname'] = $m_cname['data']['m_cname'];
                $number = explode('|', $v['number']);
                foreach ($number as $key => $value) {
                    global $shuzi;
                    $zushu['code'] = $value;
                    $zushu['m_id'] = $v['mid'];
                    $shuzi += json_decode($methodsOne->getCodeNums($zushu), true)['data'];
                    $code[$k]['zushu'] = $shuzi;
                }
                unset($GLOBALS['shuzi']);
                //订单明细
                $code[$k]['jine'] = ($text['0']['o_multiple'] * $code[$k]['zushu'] * $text['0']['o_modes'] * 2);
                //奖金中奖等级说明
                foreach ($odd as $ke => $vo) {
                    if ($v['mid'] == $vo['mid']) {
                        $code[$k]['odd'] = $vo['odd'];
                    }
                }
            }
            $arr['lid'] = $text['0']['o_lid'];
            $arr['qishu'] = $text['0']['o_issue'];
            $new = new drawhistory_model();
            $text['0']['ds_balls'] = $new->orderIssue($arr);

            $text['0']['code'] = $code;
            $text['0']['ffc_id'] = $data['o_id']; 
            return put_encode(true, '', $text['0']);
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }



    //即时订单玩法
    public function getInstant($data)
    {   
        $where='';
        switch ($data['level']) {
                    case'5'://总公司搜索
                        break;
                    case '4'://分公司搜索
                        $where .= " and o_top_4='{$data['u_name']}' ";
                        break;
                    case '3'://股东搜索
                        $where .= " and o_top_3='{$data['u_name']}' ";
                        break;
                    case '2'://总代搜索
                        $where .= " and o_top_2='{$data['u_name']}' ";
                        break;
                    case '1'://代理搜索
                        $where .= " and o_top_1='{$data['u_name']}' ";
                        break;
                    default:
                        throw new Exception(self::$error_code['3000000'], '3000000');
                        break;
        }
        $sql = "select o_lid,o_mg_id,o_issue,count(o_id)as count,sum(o_amount)as o_amount from ffc_order_" . $data['lid'] . "_temp where  1 and o_issue = {$data['issue']} $where group by o_mg_id";
        $data = $this->model->query($sql);
        return $data; 
    }

    //即时订单玩法汇总
    public function countInstant($data)
    {   $where='';
        switch ($data['level']) {
                    case'5'://总公司搜索
                        break;
                    case '4'://分公司搜索
                        $where .= " and o_top_4='{$data['u_name']}' ";
                        break;
                    case '3'://股东搜索
                        $where .= " and o_top_3='{$data['u_name']}' ";
                        break;
                    case '2'://总代搜索
                        $where .= " and o_top_2='{$data['u_name']}' ";
                        break;
                    case '1'://代理搜索
                        $where .= " and o_top_1='{$data['u_name']}' ";
                        break;
                    default:
                        throw new Exception(self::$error_code['3000000'], '3000000');
                        break;
        }
        $sql = "select count(o_id)as counts,sum(o_amount)as o_amounts from ffc_order_" . $data['lid'] . "_temp where  1 and o_issue = {$data['issue']}  $where  ";
        $data = $this->model->query($sql);
        return $data['0'];
    }

    public function groupInstant($data)
    {
        try {
            $where='';
            switch ($data['level']) {
                    case'5'://总公司搜索
                        break;
                    case '4'://分公司搜索
                        $where .= " and o_top_4='{$data['u_name']}' ";
                        break;
                    case '3'://股东搜索
                        $where .= " and o_top_3='{$data['u_name']}' ";
                        break;
                    case '2'://总代搜索
                        $where .= " and o_top_2='{$data['u_name']}' ";
                        break;
                    case '1'://代理搜索
                        $where .= " and o_top_1='{$data['u_name']}' ";
                        break;
                    default:
                        throw new Exception(self::$error_code['3000000'], '3000000');
                        break;
            }     
            if (empty($data['lid']) || empty($data['mg_id']) || empty($data['o_issue'])) {
                return put_encode(true, '', '');
            }
            if (!is_numeric($data['lid']) || !is_numeric($data['mg_id']) || !is_numeric($data['o_issue'])) {
                throw new Exception(self::$error_code['3000000'], '3000000');
            }
            $sql = "select * from ffc_order_" . $data['lid'] . "_temp where  1 and o_issue = {$data['o_issue']}  $where  and o_mg_id={$data['mg_id']}";
            $data = $this->model->query($sql);
            return put_encode(true, '', $data);
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }


    }

    public function transferRecord($data){
        try {
             if(empty($data['siteid'])){
                  throw new Exception(self::$error_code['3000011'], '3000011');
             }
             if(empty($data['start_time'])){
                  throw new Exception(self::$error_code['3000012'], '3000012');
             }
             if(empty($data['end_time'])){
                  throw new Exception(self::$error_code['3000013'], '3000013');
             }
             if(empty($data['username'])){
                 throw new Exception(self::$error_code['3000014'], '3000014');  
             }
             if(!empty($data['page'])){
                $list['page'] = $data['page']+1;
             }
             if(empty($data['type'])){
                throw new Exception(self::$error_code['3000015'], '3000015'); 
             }
             $list['fromKeyType'] = implode(',', $data['type']);
             $list['userInfoIsDetail']='1';
             $list['fromKeyTypeIsTotal']='0';
             $list['username']  =  $data['username'];
             $list['pageSize']  =  DEFAULT_PER_PAGE;
             $list['beginTime'] =  date('Y-m-d H:i:s', strtotime($data['start_time']) - 12 * 60 * 60);
             $list['endTime']   =  date('Y-m-d H:i:s', strtotime($data['end_time']) - 12 * 60 * 60);
             $list['siteId']    =  $data['siteid'];
             $list['fromKey']   =  'ds_money_key';
             $var='ds_money_key'.$list['username'];
             $list['key']   =  'aaaaa'.md5($var).'bbbbbb';
             if($data['ffc_level'] =='5' || $data['ffc_level'] == '4'){
                 $lists= json_encode($list);
                 $DS= new DS();
                 $type=array("Content-Type: application/x-www-form-urlencoded; charset=utf-8");
                 $text=$DS->transfer($lists,config('wallet_order_log'),$type);
                 $text=json_decode($text,true);
                 if($text['code'] === 100000){
                     return put_encode(true, '', $text);
                 }else{
                   throw new Exception(self::$error_code['3000016'].'---'.$text['code'].':'.$text['message'], '3000016');
                 }
             }else{
                  throw new Exception(self::$error_code['3000010'], '3000010');
             }
            } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }


}