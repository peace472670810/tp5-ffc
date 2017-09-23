<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/7/6
 * Time: 11:41
 * 前台下注  这边统一都不使用session 了
 */

namespace app\Service\order\business;
use think\Db;
use think\image\Exception;
use think\Log;
use crate\crateDB;
use Nocache\mcache;
use app\Service\order\model\tryOrder;
use app\Service\order\model\betOrder;
use app\Service\order\business\generationId;
class play
{
    public static $error_code = [
        '3000000200' => '网络异常，用户已经退出登录，下注失败',
        '3000000201' => '彩种玩法信息有误，下注失败',
        '3000000202' => '网络繁忙，请稍后再试！',
        '3000000203' => '用户已被冻结不允许下注！',
        '3000000204' => '获取投注记录参数有误！',
        '3000000205' => '获取追号记录参数有误！',
        '3000000206' => '当期投注已结束，请在下期开盘后投注！',
        '3000000207' => '追号期数有误！',
        '3000000208' => '注单详情参数有误！',
        '3000000209' => '期数有误！',
        '3000000210' => '订单不存在！',
        '3000000211' => '参数有误！',
        '3000000212' => '订单玩法有误！',
        '3000000213' => '彩种参数有误！',
        '3000000214' => '奖金组有误！',
        '3000000215' => '期数与追号期数有误！',
        '3000000216' => '盘口信息有误！',
        '3000000217' => '追号订单有误！',
        '3000000218' => '追号不存在或者有误！',
        '3000000219' => '追号注单不存在！',
        '3000000220' => '追号注单期数有误！',
        '3000000221' => '追号注单ID有误！',
        '3000000222' => '撤单奖期有部分以及处于开盘或者已开盘，请重新选择！',
        '3000000223' => '不存在改追号注单',
        '3000000224' => '网络异常，撤单失败！',
        '3000000225' => '该追号注单不存在该奖期！',
        '3000000226' => '注单有误！',
        '3000000227' => '不存在该注单！',
        '3000000228' => '不存在该追号！',
        '3000000229' => '追号输入的号码有误！',
        '3000000230' => '下注输入的号码有误！',
        '3000000231' => '单笔投注金额不能超过100万！',
        '3000000232' => '试玩不可以进行追号！',
        '3000000233' => '单笔追号金额不能超过100万！',
        '3000000234' => '单笔注单不能超过5000倍！',
        '3000000235' => 'DS API订单参数无效',
        '3000000236'=>'追号是否已经完成，不可以撤单',
        '3000000237' => '该彩种暂时停止下注！',
        '3000000238' => '同一时间内不能重复下注！',
        '3000000239' => '同一时间内追号不能重复下注！',
        '3000000240' => '您无权查看该注单！',
        '3000000241' => '您无权查看该追号注单！',
    ];
    public $orderModes = [
        '1'=>'2元',
        '0.5'=>'1元',
        '0.1'=>'2角',
        '0.01'=>'2分',
    ];
    private $crate = null;
    private $dns = null;
    private $conn = null;
    private $memcache = null;
    /**
     * 验证彩种id
     * @param $lid
     * @return bool
     */
    public function checkLotteryId($lid)
    {
        $arr = [
            '2' => '重庆时时彩',
            '26' => '山东11选5',
            '8' => '新疆时时彩',
            '27' => ' 江西11选5',
            '24' => '广东11选5',
            '14' => '天津时时彩',
            '28' => '福彩3D',
            '29' => '排列三/五',
            '9' => '江苏快三',
            '30' => '湖北快3',
            '6' => ' 北京赛车'];
        if (empty($arr[$lid])) {
            return false;
        } else {
            return $arr[$lid];
        }
    }
    /**
     * 连接crateDb
     */
    public  function connectCrate()
    {
        if(empty($this->conn)){
            $this->dns = config('crate_conf');
            $this->crate = new crateDB(['dns' => $this->dns]);
            $this->conn = $this->crate->getCrateConnection();
        }
    }
    public function __construct()
    {
        $this->memcache = new mcache();
    }

    /**
     * 订单ID生成
     */
    public function getOrderId($uid = 0){
        $data =['stub'=>date('Y-m-d H:i:s',time())];
//        $time = date("Y-m-d H:i:s");
        $mysql = [
            // 数据库类型
            'type'        => 'mysql',
            // 数据库连接DSN配置
            'dsn'         => '',
            // 服务器地址
            'hostname'    => '10.10.197.2',
            // 数据库名
            'database'    => 'ds_ffc_new',
            // 数据库用户名
            'username'    => 'ffc_new',
            // 数据库密码
            'password'    => 'qweqweqwe123',
            // 数据库连接端口
            'hostport'    => '',
            // 数据库连接参数
            'params'      => [],
            // 数据库编码默认采用utf8
            'charset'     => 'utf8',
            // 数据库表前缀
            'prefix'      => 'ffc_',
        ];
        $db = Db::connect($mysql);
//        $db->query("replace into ffc_IdGenerator(stub) select '{$time}'");
//        $id = $db->getLastInsID();
        $id = $db->table('ffc_IdGenerator')->insertGetId($data);
//        $id = generationId::generateParticle($uid);
        $db->close();
        return $id;
    }

    /**
     * sha 256 加密后再进行  rsa公钥加密
     *id+uid+username+lid+mgId+issue+singleNum+multiple+modes+amount+pan+odd+code+addTime+drawTime  + key
     */
    protected function getRsaCode($o_id,$u_id,$username,$lid,$mgId,$issue,$singleNum,$multiple,$modes,$amount,$pan,$odd,$code,$addTime,$drawTime){
        $key = 'key';
        $sha_key = $o_id.$u_id.$username.$lid.$mgId.$issue.$singleNum.$multiple.$modes.$amount.$pan.$odd.$code.$addTime.$drawTime.$key;
        $sha_256 = hash('sha256',$sha_key);
        $public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCRohzGP2V/LHQsAlxDS/cxea5m7NVGD+3mkiaw7d70NSSGpgqibXO4Fy4ogzVL9ctKd2UqgrkgvSie7UBlQSCIdpUtzy1+cYUJsMM6jNw1UFO4ff5zd2OTvhRqAibVrsV/0KY9rf0HvyPckZbddAfRO0sQlg2LTJaaexIVynZAtQIDAQAB
-----END PUBLIC KEY-----';
        $pu_key = openssl_pkey_get_public($public_key);
        openssl_public_encrypt($sha_256,$encrypted,$pu_key);//公钥加密
        return  base64_encode($encrypted);
    }
    /**
     *  md5(base64_encode(hash('sha256',拼接的字符串.'pojiecaonima')));
     *  o_id
     * o_u_id
     * o_username
     * o_top_5  o_top_4  o_top_3  o_top_2  o_top_1
     * u_proportion_5  u_proportion_4 u_proportion_3  u_proportion_2  u_proportion_1
     * o_lid
     * o_m_id
     * o_mg_id
     * o_issue
     * o_trace_id
     * o_single_num
     * o_multiple
     * o_modes
     * o_amount
     * o_wins
     * o_win1  o_win2  o_win3  o_win4 o_win5
     * o_pan  o_odd  o_code  o_hash_value  o_add_time  o_u_ip  o_proxy_ip  o_server_ip
     * pc前台下注
     *
     * hash 顺序   /**
     *
    o_id
    o_username
    o_lid
    o_issue
    o_mg_id
    o_trace_id
    o_single_num
    o_multiple
    o_modes
    o_amount
    o_wins
    o_odd
    o_pan
    o_code
    o_is_jiesuan
    o_is_pay
     */
    public function Buy($data = []){
//        $t1 = microtime(true);
        $user = $data['user'];
        if(empty($user)){
            return  put_encode(false,'3000000200',self::$error_code['3000000200']);
        }
        $panKou = ['a','b','c','d'];
        //查看盘口信息
        if(empty($data['odd'])||(!in_array($data['odd'],$panKou))){
            return  put_encode(false,'3000000216',self::$error_code['3000000216']);
        }
 //       //再查一次用户信息  优化减少mysql 消耗 其他地方已经做了
//        $info = json_decode(forwarding('lotteryForwarding', '\app\Service\users\business\frontUsers', 'getUseInfo', ['username'=>$user['u_username']]),true);
//        $user = $info['data'];
//        //判断用户是否正常
//        if($user['u_status'] != '8'){
//            return  put_encode(false,'3000000203',self::$error_code['3000000203']);
//        }
        $now = date('Y-m-d H:i:s');
        //判断彩种是否在运营
        $conf = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\config', 'getLidStatus', ['lid'=>$data['lotteryId']]), true);
        if(!$conf['data']){
            return  put_encode(false,'3000000237',self::$error_code['3000000237']);
        }
        //判断当前奖期是否存在以及状态
        $issue = $this->memcache->get('play','lot'.$data['lotteryId'].$data['issue']);
        if(empty($issue)){
            $issue = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getIusse', ['lid'=>$data['lotteryId'],'issue'=>$data['issue'],'time'=>$now]),true);
            $this->memcache->set('play','lot'.$data['lotteryId'].$data['issue'],$issue,1);
        }
        //用户下注唯一key 保证不提交两次重复注单
        $onlyKey = $this->memcache->get('UserOrderKey',$user['u_username']);
        if(empty($onlyKey)){
            $onlyKey = md5($data['REMOTE_ADDR'].$user['u_username'].$data['lotteryId'].$data['issue'].$data['modes'].$data['codes'].$data['multiple'].$data['odd']);
            $this->memcache->set('UserOrderKey',$user['u_username'],$onlyKey,1);
        }else{
            return  put_encode(false,'3000000238',self::$error_code['3000000238']);
        }
        $issue = $issue['data'];
        if(empty($issue)){
            return  put_encode(false,'3000000206',self::$error_code['3000000206']);
        }
        try{
            $sameData = [
                'o_u_id' => $user['u_id'],
                'o_username' => $user['u_username'],
                'o_top_4' => $user['u_top_4'],
                'o_top_3' => $user['u_top_3'],
                'o_top_2' => $user['u_top_2'],
                'o_top_1' => $user['u_top_1'],
                'u_proportion_5' => $user['u_proportion_5'],
                'u_proportion_4' => $user['u_proportion_4'],
                'u_proportion_3' => $user['u_proportion_3'],
                'u_proportion_2' => $user['u_proportion_2'],
                'u_proportion_1' => $user['u_proportion_1'],
                'o_pan' => $data['odd'],
                'o_lid' => $data['lotteryId'],
                'o_modes' => $data['modes'],
                'o_issue' =>$data['issue'],
                'o_trace_id' =>0,
                'o_multiple' => $data['multiple'],
                'o_u_ip' =>empty($data['REMOTE_ADDR'])?'':$data['REMOTE_ADDR'],
                'o_server_ip' =>empty($data['SERVER_ADDR'])?'':$data['SERVER_ADDR'],
                'o_proxy_ip' =>empty($data['SERVER_ADDR'])?'':$data['SERVER_ADDR'],
                'o_draw_time'=>$issue['ds_time_draw'],
            ];
            if($data['multiple']>5000){
                return  put_encode(false,'3000000234',self::$error_code['3000000234']);
            }

            $methods = forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getMethodBylidshowId', ['lid'=>$data['lotteryId']]);
            if(empty($methods)){
                return  put_encode(false,'3000000201',self::$error_code['3000000201']);
            }
            $codes = explode('#',$data['codes']);
            $orders = [];
            $insertorder = [];
            $mgs = [];
            $groups = [];
            foreach ($codes as $k=>$v){
                $code['mid'] = substr($v,0,strpos($v,':'));
                $mgs[$k]['mg_id'] = $methods[$code['mid']]['m_mg_id'];
                $mgs[$k]['code'] = substr($v,strpos($v,':')+1);
                $mgs[$k]['m_id'] = substr($v,0,strpos($v,':'));
                $groups[$k] = $mgs[$k]['mg_id'];
            }
            $mgcode = [];
            $groups = array_unique($groups);
            sort($groups);
            foreach ($groups as $k=>$v){
                foreach ($mgs as $key=>$val){
                    if($v == $val['mg_id']){
                        $mg_id =  $val['mg_id'];
                        $mgcode[$mg_id][$key]['mid'] = $val['m_id'];
                        $mgcode[$mg_id][$key]['number'] = $val['code'];
                    }
                }
            }
            $mcode = [];
            $midsPrize = '';
            $m = 0;
            foreach ($mgcode as $k=>$v){
                $orders[$k]['o_id'] = $this->getOrderId($user['u_id']);
                $code = $v;
                sort($code);
                $orders[$k]['o_code'] = json_encode($code);
                $orders[$k]['o_single_num'] = 0;
                $orderOdds = [];

                foreach ($v as $key=>$val){//计算一个玩法组的合并注单
                    $numbers = explode('|',$val['number']);
                    $nums = 0;
                    foreach ($numbers as $value){
                        $nums += $this->getCodeNums( $val['mid'],$value);
                    }
                    $orders[$k]['o_single_num'] += $nums;//注数
                    $oddPrizes = $this->getPrizeLevelByOdd($val['mid'],$data['odd']);
                    if(empty($oddPrizes)){
                        throw  new Exception('玩法:'.$val['mid'].'赔率参数有误','3000002211');
                    }
                    $orderOdds[] = ['mid'=>$val['mid'],'odd'=>$oddPrizes];//盘口赔率
                    //记录玩法号码  去进行封锁值验证
                    $mcode[$m]['f_mid'] = $val['mid'];
                    $mcode[$m]['f_issue'] = $data['issue'];
                    $mcode[$m]['f_code'] = $val['number'];
                    $mcode[$m]['f_amount'] = round($oddPrizes[0]['jiner']*$data['modes']*$data['multiple'],4);//最大获奖金额
                    $m++;
                    $midsPrize .=$val['mid'].",";//记录玩法id
                }
                $orders[$k]['o_amount'] = round(2*$data['modes']* $orders[$k]['o_single_num']*$data['multiple'],4);//本次订单总金额 精确到小数点后四位验证
                if($orders[$k]['o_amount'] <=0){
                    return put_encode(false,'3000000230',self::$error_code['3000000230']);
                }
                $orders[$k]['o_odd'] = json_encode($orderOdds);
                $orders[$k]['o_mg_id'] = $k;
                $orders[$k]['o_add_time'] = $now;
                $orders[$k] = array_merge($sameData,$orders[$k]);
                $hash_value = md5(base64_encode(hash('sha256','pojiecaonima'. $orders[$k]['o_id'].$user['u_username'].$data['lotteryId'].$data['issue'].$orders[$k]['o_mg_id'].'0'. $orders[$k]['o_single_num'].$data['multiple'].$data['modes'].$orders[$k]['o_amount'].'0'. $orders[$k]['o_odd'].$data['odd'].$orders[$k]['o_code'].'0'.'0')));
                $rsa = $this->getRsaCode($orders[$k]['o_id'],$user['u_id'],$user['u_username'],$data['lotteryId'],$orders[$k]['o_mg_id'],$data['issue'],$orders[$k]['o_single_num'],$data['multiple'],$data['modes'],$orders[$k]['o_amount'],$orders[$k]['o_pan'],$orders[$k]['o_odd'],$orders[$k]['o_code'],$orders[$k]['o_add_time'],$orders[$k]['o_draw_time']);
                $orders[$k]['o_rsa'] = $rsa;
//                Log::record('rsa加密：'.$rsa,'error');
//                Log::record('加密字符串:'.'pojiecaonima'. $orders[$k]['o_id'].$user['u_username'].$data['lotteryId'].$data['issue'].$orders[$k]['o_mg_id'].'0'. $orders[$k]['o_single_num'].$data['multiple'].$data['modes'].$orders[$k]['o_amount'].'0'. $orders[$k]['o_odd'].$data['odd'].$orders[$k]['o_code'].'0'.'0','mysql_error');
//                Log::record('hash_value:'.$hash_value,'mysql_error');
                $orders[$k]['o_hash_value'] = $hash_value;
                if($orders[$k]['o_amount']>=999999){
                    return  put_encode(false,'3000000231',self::$error_code['3000000231']);
                }
                //实占金额
                $orders[$k]['o_amount5'] = round($orders[$k]['o_amount']*$user['u_proportion_5']/100,4);
                $orders[$k]['o_amount4'] = round($orders[$k]['o_amount']*$user['u_proportion_4']/100,4);
                $orders[$k]['o_amount3'] = round($orders[$k]['o_amount']*$user['u_proportion_3']/100,4);
                $orders[$k]['o_amount2'] = round($orders[$k]['o_amount']*$user['u_proportion_2']/100,4);
                $orders[$k]['o_amount1'] = round($orders[$k]['o_amount']*$user['u_proportion_1']/100,4);
                $insertorder[$k]['orders'] =  $orders[$k];
                $insertorder[$k]['table'] = "ffc_order_".$data['lotteryId']."_". $orders[$k]['o_mg_id']."_".(mode10Issues($orders[$k]['o_issue']));
            }
            //进行封锁值验证  issue lid mid number amount  checkLocks
            $checkLocks = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\flocks', 'checkLocks', ['lid'=>$data['lotteryId'],'list'=>$mcode,'issue'=>$data['issue'],'mids'=>rtrim($midsPrize,',')]),true);
            if(!$checkLocks['data']){
                return  put_encode(false,$checkLocks['error_code'],$checkLocks['message']);
            }
            //判断是否是正式会员或者是测试会员
            if($user['u_is_test'] == '1'){
                //玩法组相同的分一起插入
                $betModel = new betOrder();
                $modelData['orders'] = $orders;
                $modelData['insertorder'] = $insertorder;
                $modelData['lotteryId'] = $data['lotteryId'];

                $res = $betModel->orderInsert($modelData,$now,$user['u_site_id'],unwrapUsername($user['u_username']),$user['u_id'],$data['lotteryId']);
                if(!empty($res['error_code'])){
                    return  put_encode(false,$res['error_code'],$res['message']);
                }
                if($res){
                    return put_encode($res,'','');
                }
                return  put_encode(false,'3000000202',self::$error_code['3000000202']);
            }else{
                //切换试玩库
                $tryModel = new tryOrder();
                $modelData['orders'] = $orders;
                $modelData['insertorder'] = $insertorder;
                $modelData['lotteryId'] = $data['lotteryId'];
                $res = $tryModel->orderInsert($modelData,$now,$user['u_site_id'],unwrapUsername($user['u_username']),$user['u_id'],$data['lotteryId']);
                if(!empty($res['error_code'])){
                    return  put_encode(false,$res['error_code'],$res['message']);
                }
                if($res){
                    return put_encode($res,'','');
                }
                return  put_encode(false,'3000000202',self::$error_code['3000000202']);
            }
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),'下注异常：code:'.$e->getCode().'；message：'.$e->getMessage());
        }
    }

    /**
     * 获取注数
     */
    public  function getCodeNums($m_id,$code){
        $nums = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getCodeNums', ['m_id'=> $m_id,'code'=>$code]),true);
        if ($nums['data']){
            return $nums['data'];
        }else{
         throw  new Exception('所选的号码:'.$code.'不符合规定','3000002200');
        }
    }
    /**
     * 获取奖金组
     */
    public  function getPrizeLevelByOdd($m_id,$odd){
        $prizes = $this->memcache->get('userOrder',$m_id.'buy'.$odd);
        if(empty($prizes)){
            $prizes = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\prizes', 'getPrizeByOdd', ['m_id'=> $m_id,'odd'=> $odd]),true);
            $this->memcache->set('userOrder',$m_id.'buy'.$odd,$prizes,10);
        }
        return $prizes['data'];
    }
    /**
     * pc端追号
     */
    public function Trace($data = []){
//        $t1 = microtime(true);
        $user = $data['user'];
        //用户下注唯一key 保证不提交两次重复注单
        $onlyKey = $this->memcache->get('UserTraceOrderKey',$user['u_username']);
        if(empty($onlyKey)){
            if(empty($data['traceData'])){
                $onlyKey = md5($data['REMOTE_ADDR'].$user['u_username'].$data['lotteryId'].$data['issue'].$data['modes'].$data['codes'].json_encode($data['traceCount']).$data['odd'].$data['stopOnWin']);
            }else{
                $onlyKey = md5($data['REMOTE_ADDR'].$user['u_username'].$data['lotteryId'].$data['issue'].$data['modes'].$data['codes'].json_encode($data['traceData']).$data['odd'].$data['stopOnWin']);
            }
            $this->memcache->set('UserTraceOrderKey',$user['u_username'],$onlyKey,1);
        }else{
            return  put_encode(false,'3000000239',self::$error_code['3000000239']);
        }
        if(empty($user)){
            return  put_encode(false,'3000000200',self::$error_code['3000000200']);
        }
        if($user['u_is_test'] != '1'){
            return  put_encode(false,'3000000232',self::$error_code['3000000232']);
        }
        $now = date('Y-m-d H:i:s');
        //如果是手机端的普通追号 $traceData 为空 要改变下
        if(empty($data['traceData'])){
            $issues = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getMobileTraceIsssue', ['lid'=>$data['lotteryId'],'traceCount'=>$data['traceCount']]),true);
            $issues = $issues['data'];
            $traceCount = count($issues);
            if($traceCount!=$data['traceCount']){
                return put_encode(false,'','可追奖期为'.$traceCount.'期,追号期数填写有误，请重新选择进行追号');
            }
            foreach ($issues as $k => $v){
                $data['traceData'][$k]['issue'] = $v['ds_qishu'];
                $data['traceData'][$k]['multiple'] = $data['multiple'];
            }
        }
        //判断彩种是否在运营
        $conf = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\config', 'getLidStatus', ['lid'=>$data['lotteryId']]), true);
        if(!$conf['data']){
            return  put_encode(false,'3000000237',self::$error_code['3000000237']);
        }
//        //再查一次用户信息
//        $info = json_decode(forwarding('lotteryForwarding', '\app\Service\users\business\frontUsers', 'getUseInfo', ['username'=>$user['u_username']]),true);
//        $user = $info['data'];
//        //判断用户是否正常
//        if($user['u_status'] != '8'){
//            return  put_encode(false,'3000000203',self::$error_code['3000000203']);
//        }
        $methods = forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getMethodBylidshowId', ['lid'=>$data['lotteryId']]);
        if(empty($methods)){
            return  put_encode(false,'3000000201',self::$error_code['3000000201']);
        }
        try{
            $sameData = [
                'o_u_id' => $user['u_id'],
                'o_username' => $user['u_username'],
                'o_top_4' => $user['u_top_4'],
                'o_top_3' => $user['u_top_3'],
                'o_top_2' => $user['u_top_2'],
                'o_top_1' => $user['u_top_1'],
                'u_proportion_5' => $user['u_proportion_5'],
                'u_proportion_4' => $user['u_proportion_4'],
                'u_proportion_3' => $user['u_proportion_3'],
                'u_proportion_2' => $user['u_proportion_2'],
                'u_proportion_1' => $user['u_proportion_1'],
                'o_pan' => $data['odd'],
                'o_lid' => $data['lotteryId'],
                'o_modes' => $data['modes'],
                'o_u_ip' =>$data['REMOTE_ADDR'],
                'o_server_ip' =>$data['SERVER_ADDR'],
                'o_proxy_ip' =>$data['SERVER_ADDR'],
            ];
            $traceSame = [
                't_id' => $this->getOrderId($user['u_id']),
                't_u_id' =>  $user['u_id'],
                't_username' => $user['u_username'],
                't_top_4' => $user['u_top_4'],
                't_top_3' => $user['u_top_3'],
                't_top_2' => $user['u_top_2'],
                't_top_1' => $user['u_top_1'],
                't_lid' => $data['lotteryId'],
                't_modes' => $data['modes'],
                't_pan' => $data['odd'],
                't_stop_on_win'=>$data['stopOnWin'],
                't_uip' =>$data['REMOTE_ADDR'],
                't_proxy_ip' =>$data['SERVER_ADDR'],
            ];
            $codes = explode('#',$data['codes']);
            $mgs = [];
            $groups = [];
            foreach ($codes as $k=>$v){
                $code['mid'] = substr($v,0,strpos($v,':'));
                $mgs[$k]['mg_id'] = $methods[$code['mid']]['m_mg_id'];
                $mgs[$k]['code'] = substr($v,strpos($v,':')+1);
                $mgs[$k]['m_id'] = substr($v,0,strpos($v,':'));
                $groups[$k] = $mgs[$k]['mg_id'];
            }
            $mgcode = [];
            $groups = array_unique($groups);
            sort($groups);
            $traceSame = array_merge($traceSame,['t_mg_id'=> implode(',',$groups)], ['t_detail'=> json_encode($mgs)]);
            foreach ($groups as $k=>$v){
                foreach ($mgs as $key=>$val){
                    if($v == $val['mg_id']){
                        $mg_id =  $val['mg_id'];
                        $mgcode[$mg_id][$key]['mid'] = $val['m_id'];
                        $mgcode[$mg_id][$key]['number'] = $val['code'];
                    }
                }
            }
            $traceData = $data['traceData'];
            $issue_number = '';
            $total_multiple = 0;
            foreach ($traceData as $k=>$v){
                $issue_number .=$v['issue'].',';
                $total_multiple += $v['multiple'];
            }
            $issue_number = rtrim($issue_number,',');
            //判断当前奖期是否存在以及状态
            $issues = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getTraceIusse', ['lid'=>$data['lotteryId'],'issue'=>$issue_number]),true);
            $issues = $issues['data'];
            if(empty($issues)){
                return  put_encode(false,'3000000206',self::$error_code['3000000206']);
            }
            if(count($issues) != count($traceData)){
                return  put_encode(false,'3000000207',self::$error_code['3000000207']);
            }
            $orders = [];
            $traceNums = 0;
            $t_total_amount = 0;
            $mcode = [];
            $m = 0;
            $midsPrize = '';
          //生成一期注单 未加hash_value
            foreach ($mgcode as $k=>$v){
                $code = $v;
                sort($code);
                $orders[$k]['o_code'] = json_encode($code);
                $orders[$k]['o_single_num'] = 0;
                $orderOdds = [];
                foreach ($v as $key=>$val){
                    $numbers = explode('|',$val['number']);
                    $nums = 0;
                    foreach ($numbers as $value){
                        $nums += $this->getCodeNums( $val['mid'],$value);
                    }
                    $traceNums +=$nums;
                    $orders[$k]['o_single_num'] += $nums;//注数
                    $oddPrizes = $this->getPrizeLevelByOdd($val['mid'],$data['odd']);
                    if(empty($oddPrizes)){
                        throw  new Exception('玩法:'.$val['mid'].'赔率参数有误','3000002211');
                    }
                    $orderOdds[] = ['mid'=>$val['mid'],'odd'=>$oddPrizes];//盘口赔率
                    //记录玩法号码  去进行封锁值验证
                    $mcode[$m]['f_mid'] = $val['mid'];
                    $mcode[$m]['f_issue'] = $traceData[0]['issue'];
                    $mcode[$m]['f_code'] = $val['number'];
                    $mcode[$m]['f_amount'] = round($oddPrizes[0]['jiner']*$data['modes']*$traceData[0]['multiple'],4);//最大获奖金额
                    $m++;
                    $midsPrize .=$val['mid'].",";//记录玩法id
                }
                $orders[$k]['o_trace_id'] = $traceSame['t_id'];
                $orders[$k]['o_odd'] = json_encode($orderOdds);
                $orders[$k]['o_mg_id'] = $k;
                $orders[$k]['o_add_time'] = $now;
                $orders[$k] = array_merge($orders[$k],$sameData);
            }
            //第一期加封锁值判断
            //进行封锁值验证  issue lid mid number amount  checkLocks
            $checkLocks = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\flocks', 'checkLocks', ['lid'=>$data['lotteryId'],'list'=>$mcode,'issue'=>$data['issue'],'mids'=>rtrim($midsPrize,',')]),true);
            if(!$checkLocks['data']){
                return  put_encode(false,$checkLocks['error_code'],$checkLocks['message']);
            }
            //生成追号单
            $trace = [];
            $traceTimes = count($traceData);
            $trace['t_issue_number'] = $issue_number;
            $trace['t_total_multiple'] = $total_multiple;
            $trace['t_single_num'] = $traceNums;
            $trace['t_trace_times'] = $traceTimes;
            $trace['t_add_time'] = $now;
            $trace['t_start_issue'] = $traceData[0]['issue'];
            $trace = array_merge($trace,$traceSame);
            //获取倍数和hash_value 期数  o_id  以及生成每一期注单  生成注单总金额
            //$issues 与traceData 顺序不能乱 注意****
            $traceOrder = [];
            $orderTables = [];
            sort($issues);
            foreach ($traceData as $k=>$v){
                $multiple = $v['multiple'];
                $issue = $issues[$k];
                foreach ($orders as $key=>$val){
                    $orders[$key]['o_id'] = $this->getOrderId($user['u_id']);
                    $orders[$key]['o_issue'] = $issue['ds_qishu'];
                    $orders[$key]['o_draw_time'] = $issue['ds_time_draw'];
                    $orders[$key]['o_multiple'] = intval($multiple);
                    if( $multiple>5000){
                        return  put_encode(false,'3000000234',self::$error_code['3000000234']);
                    }
                    $orders[$key]['o_amount'] = round(2*$data['modes']* $orders[$key]['o_single_num']*$multiple,4);
                    if($orders[$key]['o_amount'] <=0){
                        return  put_encode(false,'3000000229',self::$error_code['3000000229']);
                    }
                    $rsa = $this->getRsaCode($orders[$key]['o_id'],$user['u_id'],$user['u_username'],$data['lotteryId'],$orders[$key]['o_mg_id'],$orders[$key]['o_issue'],$orders[$key]['o_single_num'],$multiple,$data['modes'],$orders[$key]['o_amount'],$data['odd'],$orders[$key]['o_odd'],$orders[$key]['o_code'],$orders[$key]['o_add_time'],$orders[$key]['o_draw_time']);
                    $orders[$key]['o_rsa'] = $rsa;
//                    Log::record('rsa加密：'.$rsa,'error');
                    $hash_value = md5(base64_encode(hash('sha256','pojiecaonima'. $orders[$key]['o_id'].$user['u_username'].$data['lotteryId']. $orders[$key]['o_issue'].$orders[$key]['o_mg_id'].$orders[$key]['o_trace_id']. $orders[$key]['o_single_num'].$multiple.$data['modes'].$orders[$key]['o_amount'].'0'. $orders[$key]['o_odd'].$data['odd'].$orders[$key]['o_code'].'0'.'0')));
//                    Log::record('追号加密串:'.'pojiecaonima'. $orders[$key]['o_id'].$user['u_username'].$data['lotteryId']. $orders[$key]['o_issue'].$orders[$key]['o_mg_id'].$orders[$key]['o_trace_id']. $orders[$key]['o_single_num'].$multiple.$data['modes'].$orders[$key]['o_amount'].'0'. $orders[$key]['o_odd'].$data['odd'].$orders[$key]['o_code'].'0'.'0','mysql_error');
//                    Log::record('hash_value'.$hash_value,'mysql_error');
//                    Log::record('彩种ID:'.$data['lotteryId'],'mysql_error');
//                    Log::record('奖期::'.$orders[$key]['o_issue'],'mysql_error');
                    $orders[$key]['o_hash_value'] = $hash_value;
                    $orderTables[] = "ffc_order_".$data['lotteryId'].'_'.$val['o_mg_id'].'_'.mode10Issues($orders[$key]['o_issue']);
                    $t_total_amount +=  $orders[$key]['o_amount'];
                    //实占金额
                    $orders[$key]['o_amount5'] = round($orders[$key]['o_amount']*$user['u_proportion_5']/100,4);
                    $orders[$key]['o_amount4'] = round($orders[$key]['o_amount']*$user['u_proportion_4']/100,4);
                    $orders[$key]['o_amount3'] = round($orders[$key]['o_amount']*$user['u_proportion_3']/100,4);
                    $orders[$key]['o_amount2'] = round($orders[$key]['o_amount']*$user['u_proportion_2']/100,4);
                    $orders[$key]['o_amount1'] = round($orders[$key]['o_amount']*$user['u_proportion_1']/100,4);
                    $traceOrder[] = $orders[$key];
                }
            }
            $trace['t_total_amount'] = round($t_total_amount,4);
            if($t_total_amount>=999999){
                return  put_encode(false,'3000000233',self::$error_code['3000000233']);
            }
            $orders = null;//不用了清空
            //表相同的注单放到同一个数组中
            $insetTables = array_unique($orderTables);
            sort($insetTables);
            $insertTraceOrder = [];
            foreach ($insetTables as $k=>$v){
                foreach ($traceOrder as $key=>$val){
                    $name =  "ffc_order_".$val['o_lid'].'_'.$val['o_mg_id'].'_'.mode10Issues($val['o_issue']);
                    if($v == $name){
                        $insertTraceOrder[$k]['orders'][] = $val;
                        $insertTraceOrder[$k]['table'] = $name;
                    }
                }
            }
            $modelData['trace'] = $trace;
            $modelData['orders'] = $traceOrder;
            $modelData['insertOrders'] = $insertTraceOrder;
            $modelData['lotteryId'] = $data['lotteryId'];
//            $t3 = microtime(true);
            $betModel = new betOrder();
            $res = $betModel->traceOrderInsert($modelData,$now,$user['u_site_id'],unwrapUsername($user['u_username']),$user['u_id'],$data['lotteryId']);
            if(!empty($res['error_code'])){
                return put_encode(false,$res['error_code'],$res['message']);
            }
//            Log::record('总耗时：'.($t3-$t1),'error');
            if($res){
                return put_encode($res,'','');
            }
            return  put_encode(false,'3000000202',self::$error_code['3000000202']);
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }
    /**
     * 获取投注记录 mobile 端
     * 当前期的在临时注单表获取
     * 晚期结算了的从crateDB获取
     */
    public function getMobileBuyRecord($data = []){
        try{
            $user = $data['user'];
            if(empty($user)){
                throw new  Exception('3000000200',self::$error_code['3000000200']);
            }
            if(empty($data['lid'])){
                throw new Exception('3000000204',self::$error_code['3000000204']);
            }
            $betData['lid'] = $data['lid'];
            $betData['username'] = $data['username'];
            $betData['day'] = $data['day'];
            $betData['curPage'] = $data['curPage'] - 1;
            $time  = strtotime(date('Y-m-d')) - ($data['day']-1)*60*60*24;
            $betData['time'] = date('Y-m-d H:i:s',$time);
            $orders = [];
            //先到临时表查询
            if($data['day'] <= 0){//未结算注单
                if($user['u_is_test'] == 1){//正式会员
                    $betOrder = new  betOrder();
                    $list = $betOrder->mobileBuyRecord($betData);
                }else{//试玩
                    $tryOrder = new  tryOrder();
                    $list = $tryOrder->mobileBuyRecord($betData);
                }
                if(!empty($list)){
                    foreach ($list as $k=>$v){
                        if($v['o_is_cancel'] > 0){
                            switch ($v['o_is_cancel']) {
                                case '1':
                                    $prizeStatus = '用户撤单';
                                    break;
                                case '2':
                                    $prizeStatus = '追中撤单';
                                    break;
                                case '3':
                                    $prizeStatus = '出号撤单';
                                    break;
                                case '4':
                                    $prizeStatus = '未开撤单';
                                    break;
                                case '9':
                                    $prizeStatus = '系统撤单';
                                    break;
                                case '5':
                                    $prizeStatus = '追中撤单';
                                    break;
                            }
                        }else if($v['o_is_jiesuan']==0){
                            $prizeStatus = '未开奖';
                        }else if($v['o_is_jiesuan']==1){
                            $prizeStatus = '已中奖';
                        }else if($v['o_is_jiesuan']==2){
                            $prizeStatus = '未中奖';
                        }
                        $wrapId = orderWrapId($v['o_id'],$v['o_issue'],$v['o_lid']);
                        $orders[$k] = [
                            'prjID' => $v['o_id'],
                            'issue' => $v['o_issue'],
                            'wrapId' => $wrapId,
                            'traceId' =>$v['o_trace_id'],
                            'create_time' => $v['o_add_time'],
                            'code' => $v['o_code'],
                            'modes' => $v['o_modes'],
                            'multiple' => $v['o_multiple'],
                            'mg_id' => $v['o_mg_id'],
                            'lottery_id' => $v['o_lid'],
                            'amount' => $v['o_amount'],
                            'prizeStatus' => $prizeStatus,
                            'prize' => $v['o_wins'],
                            'detailUrl' =>'?issue='.$v['o_issue'].'&mg_id='.$v['o_mg_id'].'&traceId='.$v['o_trace_id'].'&lid='.$v['o_lid'].'&wrapId='.$wrapId,
                        ];
                    }
                }
            }else{//已经结算注单
                $this->connectCrate();
                $start = 10*$data['curPage'];
                $betTime = strtotime($betData['time']);
                if($user['u_is_test'] == 1){//正式会员
                    $crateTable = 'ffc_order';
                }else{
                    $crateTable = 'ffc_order_istest';
                }
                $cratesql = "select * from $crateTable  where o_lid={$data['lid']} AND  o_username='{$data['username']}' AND o_add_time>$betTime ORDER BY o_add_time DESC limit 10 offset  $start";
                $crateData = $this->conn->query($cratesql);
                $list = $crateData->fetchAll();
                if(!empty($list)){
                    foreach ($list as $k=>$v){
                        if($v['o_is_cancel'] > 0){
                            switch ($v['o_is_cancel']) {
                                case '1':
                                    $prizeStatus = '用户撤单';
                                    break;
                                case '2':
                                    $prizeStatus = '追中撤单';
                                    break;
                                case '3':
                                    $prizeStatus = '出号撤单';
                                    break;
                                case '4':
                                    $prizeStatus = '未开撤单';
                                    break;
                                case '9':
                                    $prizeStatus = '系统撤单';
                                    break;
                                case '5':
                                    $prizeStatus = '追中撤单';
                                    break;
                            }
                        }else if($v['o_is_jiesuan']==0){
                            $prizeStatus = '未开奖';
                        }else if($v['o_is_jiesuan']==1){
                            $prizeStatus = '已中奖';
                        }else if($v['o_is_jiesuan']==2){
                            $prizeStatus = '未中奖';
                        }
                        $wrapId = orderWrapId($v['o_id'],$v['o_issue'],$v['o_lid']);
                        $orders[$k] = [
                            'prjID' => $v['o_id'],
                            'issue' => $v['o_issue'],
                            'wrapId' => $wrapId,
                            'traceId' =>$v['o_trace_id'],
                            'create_time' => date('Y-m-d H:i:s',$v['o_add_time']/1000),
                            'code' => $v['o_code'],
                            'modes' => $v['o_modes'],
                            'multiple' => $v['o_multiple'],
                            'mg_id' => $v['o_mg_id'],
                            'lottery_id' => $v['o_lid'],
                            'amount' => round($v['o_amount']/1000000,4),
                            'prizeStatus' => $prizeStatus,
                            'prize' => $v['o_wins'],
                            'detailUrl' =>'?issue='.$v['o_issue'].'&mg_id='.$v['o_mg_id'].'&traceId='.$v['o_trace_id'].'&lid='.$v['o_lid'].'&wrapId='.$wrapId,
                        ];
                    }
                }
            }
            return put_encode($orders,'','');
        }catch (Exception $e){
            Log::record($e->getMessage(),'error');
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }
    /**
     * 获取投注记录 pc 端
     * 当前期的在临时注单表获取
     * 晚期结算了的从crateDB获取
     */
    public function getBuyRecord($data = []){
        try{
            $user = $data['user'];
            if(empty($user)){
                throw new  Exception('3000000200',self::$error_code['3000000200']);
            }
            if(empty($data['lid'])){
                throw new Exception('3000000204',self::$error_code['3000000204']);
            }
            if($user['u_is_test'] == 1){//正式会员
                $betData['lid'] = $data['lid'];
                $betData['username'] = $data['username'];
                $betOrder = new  betOrder();
                $curlist = $betOrder->getBuyRecord($betData);
            }else{//试玩
                $betData['lid'] = $data['lid'];
                $betData['username'] = $data['username'];
                $tryOrder = new  tryOrder();
                $curlist = $tryOrder->getBuyRecord($betData);
            }
//            $count = count($curlist);
            $last = [];
//            if($count<10){
//                $count = 10 - $count;
//                $this->connectCrate();
//                if($user['u_is_test'] == 1) {//正式会员
//                    $table = 'ffc_order';
//                }else{
//                    $table = 'ffc_order_istest';
//                }
//                $cratesql = "select o_username,o_id,code,o_multiple,o_amount,o_issue,o_lid,o_mg_id,o_is_cancel,o_is_jiesuan,o_wins,o_add_time  from $table where o_lid={$data['lid']} and o_username='{$data['username']}' and o_trace_id=0 order by o_add_time DESC  limit $count";
//                $last = $this->conn->query($cratesql);
//            }
            $orders = [];
//            Log::record($last,'error');
            if(empty($curlist)){
                $list = $last;
            }else{
                $list = empty($last)?$curlist: array_merge($curlist,$last);
            }
            if(!empty($list)){
                foreach ($list as $k=>$v){
                    if($v['o_is_cancel'] > 0){
                        switch ($v['cancel_status']) {
                            case '1':
                                $prizeStatus = '用户撤单';
                                break;
                            case '2':
                                $prizeStatus = '追中撤单';
                                break;
                            case '3':
                                $prizeStatus = '出号撤单';
                                break;
                            case '4':
                                $prizeStatus = '未开撤单';
                                break;
                            case '9':
                                $prizeStatus = '系统撤单';
                                break;
                            case '5':
                                $prizeStatus = '追中撤单';
                                break;
                        }
                    }else if($v['o_is_jiesuan']==0){
                        $prizeStatus = '未开奖';
                    }else if($v['o_is_jiesuan']==1){
                        $prizeStatus = '已中奖';
                    }else if($v['o_is_jiesuan']==2){
                        $prizeStatus = '未中奖';
                    }
                    $wrapId = orderWrapId($v['o_id'],$v['o_issue'],$v['o_lid']);
                    $orders[$k] = [
                        'prjID' => $v['o_id'],
                        'issue' => $v['o_issue'],
                        'wrapId' => $wrapId,
                        'create_time' => $v['o_add_time'],
                        'code' => $v['o_code'],
                        'multiple' => $v['o_multiple'],
                        'amount' => $v['o_amount'],
                        'prizeStatus' => $prizeStatus,
                        'prize' => $v['o_wins'],
                        'detailUrl' => url('Game/orderDetail').'?issue='.$v['o_issue'].'&mg_id='.$v['o_mg_id'].'&lid='.$v['o_lid'].'&wrapId='.$wrapId,
                    ];
                }
                }
                return put_encode($orders,'','');
        }catch (Exception $e){
            Log::record($e->getMessage(),'error');
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 获取追号记录
     */
    public function getTraceRecord($data = []){
        try{
            if(empty($data['lid'])){
                throw new Exception('3000000204',self::$error_code['3000000204']);
            }
            $traceData['username'] = $data['username'];
            $traceData['lid'] = $data['lid'];
            $traceData['limit'] = 10;
            $betOrder = new  betOrder();
            $tracelist = $betOrder->traceRecord($traceData);
            $projects = [];
            if(!empty($tracelist)){
                foreach ($tracelist as $v) {
                    $states = '';
                    if ($v['t_status'] == 0) {
                        $states = '未开始';
                    } elseif ($v['t_status'] == 1) {
                        $states = '正在进行';
                    } elseif ($v['t_status'] == 2) {
                        $states = '已完成';
                    } elseif ($v['t_status'] == 3) {
                        $states = '已取消';
                    }
                    $states .= '(' . $v['t_finish_times'] . '/' . $v['t_trace_times'] . ')';
                    $wrapId = orderWrapId($v['t_id'], $v['t_start_issue'], $v['t_lid']);
                    $projects[] = array(
                        'start_issue' => $v['t_start_issue'],
                        'total_amount' => $v['t_total_amount'],
                        'states' => $states,
                        'wrap_id' => $wrapId,
                        'detailUrl' => url('Game/traceDetail').'?issue='.$v['t_start_issue'].'&lid='.$v['t_lid'].'&wrapId='.$wrapId,
                    );
                }
            }
            return put_encode($projects,'','');
        }catch (Exception $e){
            Log::record($e->getMessage(),'error');
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 手机端订单详情
     * @param array $data
     */
    public function mobileOrderDetail($data = []){
        try{

            $user = $data['user'];
            if(!$this->checkLotteryId($data['lid'])){
                return  put_encode(false,'3000000213',self::$error_code['3000000213']);
            }
            if(empty($user)){
                return  put_encode(false,'3000000200',self::$error_code['3000000200']);
            }
            if(empty($data['mg_id'])||empty($data['lid'])||empty($data['wrap_id'])){
                return  put_encode(false,'3000000208',self::$error_code['3000000208']);
            }
            $o_id = unOrderWrapId($data['wrap_id']);
            if(empty($o_id)){
                return   put_encode(false,'3000000211',self::$error_code['3000000211']);
            }

            if(!preg_match('`^\d+$`',$data['lid'],$match)){
                return   put_encode(false,'3000000211',self::$error_code['3000000211']);
            }
            $method_groups = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getMethodList', ['mg_id'=>$data['mg_id']]),true);
            $method_groups = $method_groups['data'];
            if(!$method_groups){
                return   put_encode(false,'3000000212',self::$error_code['3000000212']);
            }
            $betData['lid'] = $data['lid'];
            $betData['o_id'] = $o_id;
            $betData['issue'] = $data['issue'];
            $betData['mg_id'] = $data['mg_id'];

            if($user['u_is_test'] == 1){//正式会员
                $betOrder = new  betOrder();
                $res = $betOrder->orderDetail($betData);
            }else{//试玩
                $tryOrder = new  tryOrder();
                $res = $tryOrder->orderDetail($betData);
            }
            if($res['o_username'] != $user['u_username']){
                return  put_encode(false,'3000000240',self::$error_code['3000000240']);
            }
            $issueDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getIusseByIssue', ['lid'=>$data['lid'],'issue'=>$res['o_issue']]),true);
            if(empty($issueDetail)){
                return  put_encode(false,'3000000208',self::$error_code['3000000208']);
            }

            $res['m_cname'] = '';
            $res['o_sn'] = $data['wrap_id'];
            $modes = $this->orderModes;
            $res['o_amount'] = number_format($res['o_amount'],4);
            $res['o_wins'] = number_format($res['o_wins'],4);

            $res['modeName'] = $modes[$res['o_modes']];
            $res['draw_code'] = $issueDetail['data']['ds_balls'];
            $res['draw_code'] = empty($res['draw_code'])?'暂未开奖': $res['draw_code'];
            $res['trace_status'] = $res['o_trace_id'] == 0?'否':'是';
            if(!$res['o_is_cancel']){
                switch ($res['o_is_jiesuan']){
                    case 0:
                        $res['prize_status'] = '未判断';
                        break;
                    case 1:
                        $res['prize_status'] = '中奖';
                        break;
                    case 2:
                        $res['prize_status'] = '未中奖';
                        break;
                }
            }else{
                switch ($res['o_is_cancel']){
                    case 0:
                        $res['prize_status'] = '未撤单';
                        break;
                    case 1:
                        $res['prize_status'] = '用户撤单';
                        break;
                    case 2:
                        $res['prize_status'] = '追中撤单';
                        break;
                    case 3:
                        $res['prize_status'] = '出号撤单';
                        break;
                    case 4:
                        $res['prize_status'] = '未开撤单';
                        break;
                    case 9:
                        $res['prize_status'] = '管理员撤单';
                        break;
                    case 5:
                        $res['prize_status'] = '追中撤单';
                        break;
                }
            }
            //下注内容描述
            $codes = json_decode($res['o_code'],true);
            foreach ($codes as $k=>$v){
                foreach ($method_groups as $val){
                    if($v['mid'] == $val['m_id']){
                        $codes[$k]['name'] = $val['m_cname'];
                    }
                }
            }
            foreach ($codes as $k=>$v){
                $numbers = explode('|',$v['number']);
                $codes[$k]['nums'] = 0;
                foreach ($numbers as $val){
                    $codes[$k]['nums'] += $this->getCodeNums($v['mid'],$val);
                }
                $codes[$k]['amount'] = 2*$codes[$k]['nums']*$res['o_modes']*$res['o_multiple'];
            }
            $res['code_detail'] = $codes;
            //玩法奖金描述
            $odds = json_decode($res['o_odd'],true);
            $odd_detail = '';
            foreach ($odds as $k=>$v){
               foreach ($method_groups as $val){
                   if($v['mid'] == $val['m_id']){
                       $odd_detail .= $val['m_cname'].":";
                   }
               }
                foreach ($v['odd'] as $value){
                    $odd_detail .= $value['level']."等奖奖金".$value['jiner'].",";
                }
                $odd_detail =  rtrim($odd_detail,',').";";
            }
            $res['odd_detail'] = $odd_detail;
            $res['lidName'] = $this->checkLotteryId($res['o_lid']);

            return  put_encode($res,'','');
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 手机端追号注单详情
     */
    public function mobileTraceDetail($data = []){
        try{
            $user = $data['user'];
            if(empty($user)){
                return  put_encode(false,'3000000200',self::$error_code['3000000200']);
            }
            $t_id = $data['trace_id'];
            if(empty($t_id)){
                return   put_encode(false,'3000000211',self::$error_code['3000000211']);
            }
            $betOrder = new  betOrder();
            $res = $betOrder->traceDetail(['t_id'=>$t_id]);
            if(empty($res)){
                return   put_encode(false,'3000000218',self::$error_code['3000000218']);
            }
            $res['wrap_id'] = orderWrapId($res['t_id'],$res['t_start_issue'],$res['t_lid']);
            $modes = $this->orderModes;
            $res['t_modes'] = $modes[$res['t_modes']];
            if($res['t_stop_on_win'] == 1){
                $res['t_stop'] = '是';
            }else if($res['t_stop_on_win'] == 2){
                $res['t_stop'] = '出号撤单';
            }else if($res['t_stop_on_win'] == 0){
                $res['t_stop'] = '否';
            }else{
                $res['t_stop'] = '追号注单异常';
            }
            switch ($res['t_status']){
                case 0:
                    $res['status'] = '未开始';
                    break;
                case 1:
                    $res['status'] = '正在进行';
                    break;
                case 2:
                    $res['status'] = '已完成';
                    break;
                case 3:
                    $res['status'] = '已取消';
                    break;
            }
            $detail = json_decode($res['t_detail'],true);
            $content = [];
            foreach ($detail as $k=>$v){
                $content[$k]['m_id'] = $v['m_id'];//
                $methoGroupdDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\method_groups', 'getMethodGroupDetail', ['lid'=>$res['t_lid'],'mg_id'=>$v['mg_id']]),true);
                $content[$k]['mg_name'] = $methoGroupdDetail['data']['mg_name'];
                $methodDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getMothodDetail', ['lid'=>$res['t_lid'],'m_id'=>$v['m_id']]),true);
                $content[$k]['m_name'] = $methodDetail['data']['m_cname'];
                $content[$k]['mg_id'] = $v['mg_id'];
                $content[$k]['number'] = $v['code'];
                $content[$k]['nums'] = 0;
                $codes = explode('|',$v['code']);
                $codenums = 0;
                foreach ($codes as $key=>$val){
                    $codenums += $this->getCodeNums($v['m_id'],$val);
                    $content[$k]['nums'] = $codenums;
                }
            }
            $orderlist =  explode(',',$res['t_issue_number']);
            $issueList = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getTraceIusse', ['lid'=>$res['t_lid'],'issue'=>$res['t_issue_number'],'status'=>1]),true);
            $issueList = $issueList['data'];
            $mgnums = count(explode(',',$res['t_mg_id']));
            if(count($issueList) != count($orderlist)){
                $issueList = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getHadTraceIusse', ['lid'=>$res['t_lid'],'issue'=>$res['t_issue_number']]),true);
                $issueList = $issueList['data'];
                if(count($issueList) != count($orderlist)){
                    return  put_encode(false,'3000000215',self::$error_code['3000000215']);
                }
            }
            foreach ($issueList as $k=>$v){
                $issueList[$k]['total_prize'] = 0;
                $issueList[$k]['total_amount'] = 0;
                $issueList[$k]['multiple'] = 0;
                $issueList[$k]['total_nums'] = 0;
                $nums = 0;
                $list = $betOrder->traceDetailByIusseList(['t_id'=>$t_id,'lid'=>$res['t_lid'],'issue'=>$v['ds_qishu'],'mg_ids'=>$res['t_mg_id']]);
                $issueList[$k]['total_nums'] = count($list);
                foreach ($list as $val){
                    $issueList[$k]['total_amount'] += $val['o_amount'];
                    $issueList[$k]['multiple'] = +$val['o_multiple'];
                    if(empty($val['o_is_cancel'])) {
                        $nums++;
                        $issueList[$k]['total_prize'] += $val['o_wins'];

                        switch ($val['o_is_jiesuan']) {
                            case 0:
                                $issueList[$k]['status'] = '未判断';
                                break;
                            case 1:
                                $issueList[$k]['status'] = '中奖';
                                break;
                            case 2:
                                $issueList[$k]['status'] = '未中奖';
                                break;
                        }
                        if($issueList[$k]['total_prize'] > 0){//一期多笔注单 其中有一笔中奖
                            $issueList[$k]['status'] = '中奖';
                        }
                    }else{
                        switch ($val['o_is_cancel']){
                            case 0:
                                $issueList[$k]['status'] = '未撤单';
                                break;
                            case 1:
                                $issueList[$k]['status'] = '用户撤单';
                                break;
                            case 2:
                                $issueList[$k]['status'] = '追中撤单';
                                break;
                            case 3:
                                $issueList[$k]['status'] = '出号撤单';
                                break;
                            case 4:
                                $issueList[$k]['status'] = '未开撤单';
                                break;
                            case 9:
                                $issueList[$k]['status'] = '管理员撤单';
                                break;
                            case 5:
                                $issueList[$k]['status'] = '追中撤单';
                                break;
                        }
                    }
                }
                if(!empty($v['ds_state'])){
                    switch ($v['ds_state']){
                        case 0:
                            $issueList[$k]['issue_status'] = '暂未开盘';
                            break;
                        case 1:
                            $issueList[$k]['issue_status'] = '正在开盘中';
                            break;
                        default:
                            $issueList[$k]['issue_status'] = '已经封盘';
                    }
                }else{
                    $issueList[$k]['issue_status'] = '暂未开盘';
                }
                if($res['t_status']>=2){//已经完成或者已经取消
                    $issueList[$k]['cancel_status'] = 0;
                }else{
                    if($v['ds_state'] == 0){
                        $issueList[$k]['cancel_status'] = 1;//还未开始 或者正在进行中
                        if( $issueList[$k]['status']  == '用户撤单'){
                            $issueList[$k]['cancel_status'] = 0;
                        }
                    }else{
                        $issueList[$k]['cancel_status'] = 0;
                    }
                }
            }
            $res['order'] =  $issueList;
            $res['detail'] = $content;
            $res['lidName'] = $this->checkLotteryId($res['t_lid']);
            return  put_encode($res,'','');
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }
    /**
     * pc端
     * 获取订单详情
     */
    public function orderDetail($data = []){
        try{
            $user = $data['user'];
            if(!$this->checkLotteryId($data['lid'])){
                return  put_encode(false,'3000000213',self::$error_code['3000000213']);
            }
            if(empty($user)){
                return  put_encode(false,'3000000200',self::$error_code['3000000200']);
            }
            if(empty($data['issue'])||empty($data['mg_id'])||empty($data['lid'])||empty($data['wrapId'])){
                return  put_encode(false,'3000000208',self::$error_code['3000000208']);
            }
            if(!preg_match('`^\d+$`',$data['issue'],$match)){
                return   put_encode(false,'3000000209',self::$error_code['3000000209']);
            }
            $o_id = unOrderWrapId($data['wrapId']);

            if(empty($o_id)){
                return   put_encode(false,'3000000211',self::$error_code['3000000211']);
            }
            if(!preg_match('`^\d+$`',$data['lid'],$match)){
                return   put_encode(false,'3000000211',self::$error_code['3000000211']);
            }
            $method_groups = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getMethodList', ['mg_id'=>$data['mg_id']]),true);
            $method_groups = $method_groups['data'];
            if(!$method_groups){
                return   put_encode(false,'3000000212',self::$error_code['3000000212']);
            }
            $issueDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getIusseByIssue', ['lid'=>$data['lid'],'issue'=>$data['issue']]),true);
            if(empty($issueDetail)){
                return  put_encode(false,'3000000208',self::$error_code['3000000208']);
            }
            $betData['lid'] = $data['lid'];
            $betData['o_id'] = $o_id;
            $betData['mg_id'] = $data['mg_id'];
            $betData['issue'] = $data['issue'];
            if($user['u_is_test'] == 1){//正式会员
                //直接去注单表查
                $betOrder = new  betOrder();
                $res = $betOrder->orderDetail($betData);
            }else{//试玩
                $tryOrder = new  tryOrder();
                $res = $tryOrder->orderDetail($betData);
            }
            if($res['o_username'] != $user['u_username']){
                return  put_encode(false,'3000000240',self::$error_code['3000000240']);
            }
            $res['m_cname'] = '';
            $res['o_sn'] = $data['wrapId'];
            $modes = $this->orderModes;
            $res['modeName'] = $modes[$res['o_modes']];
            $res['draw_code'] = $issueDetail['data']['ds_balls'];
            $res['trace_status'] = $res['o_trace_id'] == 0?'否':'是';
            if(!$res['o_is_cancel']){
                switch ($res['o_is_jiesuan']){
                    case 0:
                        $res['prize_status'] = '未判断';
                        break;
                    case 1:
                        $res['prize_status'] = '中奖';
                        break;
                    case 2:
                        $res['prize_status'] = '未中奖';
                        break;
                }
            }else{
                switch ($res['o_is_cancel']){
                    case 0:
                        $res['prize_status'] = '未撤单';
                        break;
                    case 1:
                        $res['prize_status'] = '用户撤单';
                        break;
                    case 2:
                        $res['prize_status'] = '追中撤单';
                        break;
                    case 3:
                        $res['prize_status'] = '出号撤单';
                        break;
                    case 4:
                        $res['prize_status'] = '未开撤单';
                        break;
                    case 9:
                        $res['prize_status'] = '管理员撤单';
                        break;
                    case 5:
                        $res['prize_status'] = '追中撤单';
                        break;

                }
            }
                $methodsName = [];//记录下方法名 为下面使用方便
                $codes = json_decode($res['o_code'],true);
                foreach ($codes as $k=>$v){
                    foreach ($method_groups as $val){
                        if($v['mid'] == $val['m_id']){
                            $codes[$k]['name'] = $val['m_cname'];
                            $methodsName[$v['mid']] = $val['m_cname'];
                        }
                    }
                }
                foreach ($codes as $k=>$v){
                    $numbers = explode('|',$v['number']);
                    $codes[$k]['nums'] = 0;
                    foreach ($numbers as $val){
                        $codes[$k]['nums'] += $this->getCodeNums($v['mid'],$val);
                    }
                    $codes[$k]['amount'] = 2*$codes[$k]['nums']*$res['o_modes']*$res['o_multiple'];
                }
                $res['code_detail'] = $codes;
            $prizeList = json_decode($res['o_hit_detail'],true);
//            dump($prizeList);
            //中奖详情描述
            $prize_detail = [];
            if($res['o_is_jiesuan'] == 1){
                $j=0;
                foreach ($prizeList as $v){
                    if(!empty($v['hit'])){
                        foreach ($v['hit'] as $val){
                            $prize_detail[$j]['m_name'] = $methodsName[$v['mid']];
                            $prize_detail[$j]['number'] = '号码：'.$v['number'];
                            $prize_detail[$j]['count'] = $val['count'].'注';
                            $prize_detail[$j]['level'] = $val['level'].'等奖';
                            $j++;
                        }
                    }
                }
            }
            $res['prize_detail'] = $prize_detail;
            //玩法奖金描述
            $odds = json_decode($res['o_odd'],true);
            $odd_detail = [];
            $i=0;
            foreach ($odds as $k=>$v){
                foreach ($method_groups as $val){
                    if($v['mid'] == $val['m_id']){
                        $odd_detail[$i]['m_cname']= $val['m_cname'];
                    }
                }
                $odd_detail[$i]['detail'] = '';
                foreach ($v['odd'] as $value){
                    $odd_detail[$i]['detail'] .= $value['level']."等奖奖金".$value['jiner'].",";
                }
                $i++;
            }
            $res['odd_detail'] = $odd_detail;
            $res['lidName'] = $this->checkLotteryId($res['o_lid']);
            return  put_encode($res,'','');
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }
    /**
     * pc端
     * 获取追号详情
     */
    public function traceDetail($data = []){
        try{
            $user = $data['user'];
            if(empty($data['lid'])){
                return  put_encode(false,'3000000213',self::$error_code['3000000213']);
            }
            if(!$this->checkLotteryId($data['lid'])){
                return  put_encode(false,'3000000213',self::$error_code['3000000213']);
            }
            if(empty($user)){
                return  put_encode(false,'3000000200',self::$error_code['3000000200']);
            }
            if(!preg_match('`^\d+$`',$data['issue'],$match)){
                return   put_encode(false,'3000000209',self::$error_code['3000000209']);
            }
            $t_id = unOrderWrapId($data['wrapId']);
            if(empty($t_id)){
                return   put_encode(false,'3000000211',self::$error_code['3000000211']);
            }
            if(!preg_match('`^\d+$`',$data['lid'],$match)){
                return   put_encode(false,'3000000211',self::$error_code['3000000211']);
            }
            $issueDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getIusseByIssue', ['lid'=>$data['lid'],'issue'=>$data['issue']]),true);
            if(empty($issueDetail['data'])){
                return  put_encode(false,'3000000208',self::$error_code['3000000208']);
            }
            $betOrder = new  betOrder();
            $res = $betOrder->traceDetail(['t_id'=>$t_id]);
            if(empty($res)){
                return   put_encode(false,'3000000218',self::$error_code['3000000218']);
            }

            $res['wrapId'] = $data['wrapId'];
            $modes = $this->orderModes;
            $res['t_modes'] = $modes[$res['t_modes']];
            if($res['t_stop_on_win'] == 1){
                $res['t_stop'] = '是';
            }else if($res['t_stop_on_win'] == 2){
                $res['t_stop'] = '出号撤单';
            }else if($res['t_stop_on_win'] == 0){
                $res['t_stop'] = '否';
            }else{
                $res['t_stop'] = '追号注单异常';
            }
            switch ($res['t_status']){
                case 0:
                    $res['status'] = '未开始';
                    break;
                case 1:
                    $res['status'] = '正在进行';
                    break;
                case 2:
                    $res['status'] = '已完成';
                    break;
                case 3:
                    $res['status'] = '已取消';
                    break;
            }

            $detail = json_decode($res['t_detail'],true);
            if (empty($detail)){
                return  put_encode(false,'3000000217',self::$error_code['3000000217']);
            }
            $content = [];
            foreach ($detail as $k=>$v){
                $content[$k]['m_id'] = $v['m_id'];//
                $methoGroupdDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\method_groups', 'getMethodGroupDetail', ['lid'=>$res['t_lid'],'mg_id'=>$v['mg_id']]),true);
                $content[$k]['mg_name'] = $methoGroupdDetail['data']['mg_name'];
                $methodDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getMothodDetail', ['lid'=>$res['t_lid'],'m_id'=>$v['m_id']]),true);
                $content[$k]['m_name'] = $methodDetail['data']['m_cname'];
                $content[$k]['mg_id'] = $v['mg_id'];
                $content[$k]['number'] = $v['code'];
                $content[$k]['nums'] = 0;
                $codes = explode('|',$v['code']);
                $codenums = 0;
                foreach ($codes as $key=>$val){
                    $codenums += $this->getCodeNums($v['m_id'],$val);
                    $content[$k]['nums'] = $codenums;
                }
            }
            $orderlist = explode(',',$res['t_issue_number']);
            //判断是当天追号还是昨天以前的追号
            $issueList = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getTraceIusse', ['lid'=>$res['t_lid'],'issue'=>$res['t_issue_number'],'status'=>1]),true);
            $issueList = $issueList['data'];
            $mgnums = count(explode(',',$res['t_mg_id']));
            if(count($issueList) !=count($orderlist)){
                $issueList = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getHadTraceIusse', ['lid'=>$res['t_lid'],'issue'=>$res['t_issue_number']]),true);
                $issueList = $issueList['data'];
                if(count($issueList) != count($orderlist)){
                    return  put_encode(false,'3000000215',self::$error_code['3000000215']);
                }
            }

            //20170727053,20170727054,20170727055,20170727056,20170727057 134
            foreach ($issueList as $k=>$v){
                $issueList[$k]['total_prize'] = 0;
                $issueList[$k]['total_amount'] = 0;
                $issueList[$k]['multiple'] = 0;
                $issueList[$k]['total_nums'] = 0;
                $nums = 0;
                $list = $betOrder->traceDetailByIusseList(['t_id'=>$t_id,'lid'=>$res['t_lid'],'issue'=>$v['ds_qishu'],'mg_ids'=>$res['t_mg_id']]);
                $issueList[$k]['total_nums'] = count($list);
                foreach ($list as $val){
                    $issueList[$k]['total_amount'] += $val['o_amount'];
                    $issueList[$k]['multiple'] = +$val['o_multiple'];
                    if(empty($val['o_is_cancel'])) {
                        $nums++;
                        $issueList[$k]['total_prize'] += $val['o_wins'];

                        switch ($val['o_is_jiesuan']) {
                            case 0:
                                $issueList[$k]['status'] = '未判断';
                                break;
                            case 1:
                                $issueList[$k]['status'] = '中奖';
                                break;
                            case 2:
                                $issueList[$k]['status'] = '未中奖';
                                break;
                        }
                        if($issueList[$k]['total_prize'] > 0){//一期多笔注单 其中有一笔中奖
                            $issueList[$k]['status'] = '中奖';
                        }
                    }else{
                        switch ($val['o_is_cancel']){
                            case 0:
                                $issueList[$k]['status'] = '未撤单';
                                break;
                            case 1:
                                $issueList[$k]['status'] = '用户撤单';
                                break;
                            case 2:
                                $issueList[$k]['status'] = '追中撤单';
                                break;
                            case 3:
                                $issueList[$k]['status'] = '出号撤单';
                                break;
                            case 4:
                                $issueList[$k]['status'] = '未开撤单';
                                break;
                            case 9:
                                $issueList[$k]['status'] = '管理员撤单';
                                break;
                            case 5:
                                $issueList[$k]['status'] = '追中撤单';
                                break;
                        }
                    }
                }

                if(!empty($v['ds_state'])){
                    switch ($v['ds_state']){
                        case 0:
                            $issueList[$k]['issue_status'] = '暂未开盘';
                            break;
                        case 1:
                            $issueList[$k]['issue_status'] = '正在开盘中';
                            break;
                        default:
                            $issueList[$k]['issue_status'] = '已经封盘';
                    }
                }else{
                    $issueList[$k]['issue_status'] = '暂未开盘';
                }
//                halt($res['t_status']);
                 if($res['t_status']>=2){//已经完成或者已经取消
                     $issueList[$k]['cancel_status'] = 0;
                 }else{
                     if(empty($v['ds_state'])){
                         $issueList[$k]['cancel_status'] = 1;//还未开始 或者正在进行中
                         if( $issueList[$k]['status']  == '用户撤单'){
                             $issueList[$k]['cancel_status'] = 0;
                         }
                     }else{
                         $issueList[$k]['cancel_status'] = 0;
                     }
                 }
            }

            $res['order'] =  $issueList;
            $res['detail'] = $content;
            $res['lidName'] = $this->checkLotteryId($res['t_lid']);
            return  put_encode($res,'','');
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 每期内追号里面的注单详情  一期有多个注单的情况
     */
    public function getTraceOrderDetail($data = []){
        $user = $data['user'];
        if(empty($user)){
            return  put_encode(false,'3000000200',self::$error_code['3000000200']);
        }
        if(empty($data['issue'])){
            return  put_encode(false,'3000000220',self::$error_code['3000000220']);
        }
        $issue = $data['issue'];
        if(empty($data['trace_id'])){
            return  put_encode(false,'3000000221',self::$error_code['3000000221']);
        }
        //1.去追号表查看该追号注单
        $t_id = $data['trace_id'];
        $betOrder = new  betOrder();
        $res = $betOrder->traceDetail(['t_id'=>$t_id]);
        if(empty($res)){
            return   put_encode(false,'3000000218',self::$error_code['3000000218']);
        }
        if(!in_array($issue,explode(',',$res['t_issue_number']))){
            return   put_encode(false,'3000000225',self::$error_code['3000000225']);
        }
        if($res['t_username'] != $user['u_username']){
            return  put_encode(false,'3000000241',self::$error_code['3000000241']);
        }
        //2.根据追号表存在该期 然后根据期数 玩法组id 去对应得注单表查看注单
        $arr['issue'] = $issue;
        $arr['mg_id'] = explode(',',$res['t_mg_id']);
        $arr['lid'] = $res['t_lid'];
        $arr['trace_id'] = $t_id;
        $list = $betOrder->TraceOrderDetail($arr);
        if(empty($list)){
            return   put_encode(false,'3000000226',self::$error_code['3000000226']);
        }
        foreach ($list as $k => $v){
            $list[$k]['o_sn'] = orderWrapId($v['o_id'],$v['o_issue'],$v['o_lid']);
            $modes = $this->orderModes;
            $list[$k]['modeName'] = $modes[$v['o_modes']];
            $list[$k]['trace_status'] = empty($v['o_trace_id'])?'否':'是';
            switch ($v['o_is_cancel']){
                        case 0:
                            $list[$k]['prize_status'] = '未撤单';
                            break;
                        case 1:
                            $list[$k]['prize_status'] = '用户撤单';
                            break;
                        case 2:
                            $list[$k]['prize_status'] = '追中撤单';
                            break;
                        case 3:
                            $list[$k]['prize_status'] = '出号撤单';
                            break;
                        case 4:
                            $list[$k]['prize_status'] = '未开撤单';
                            break;
                        case 9:
                            $list[$k]['prize_status'] = '管理员撤单';
                            break;
                        case 5:
                            $list[$k]['prize_status'] = '追中撤单';
                            break;
                    }
            $list[$k]['draw_code'] = '';
            $list[$k]['lidName'] = $this->checkLotteryId($res['t_lid']);
        }
        return put_encode($list,'','');
    }
    /**
     * 取消追号注单
     */
    public function cancelTrace($data = []){
        $user = $data['user'];
        if(empty($user)){
            return  put_encode(false,'3000000200',self::$error_code['3000000200']);
        }
        //再查一次用户信息
        $info = json_decode(forwarding('lotteryForwarding', '\app\Service\users\business\frontUsers', 'getUseInfo', ['username'=>$user['u_username']]),true);
        $user = $info['data'];
        //判断用户是否正常
        if($user['u_status'] != '8'){
            return  put_encode(false,'3000000203',self::$error_code['3000000203']);
        }
        if(empty($data['issues'])){
            return  put_encode(false,'3000000220',self::$error_code['3000000220']);
        }
        if(empty($data['trace_id'])){
            return  put_encode(false,'3000000221',self::$error_code['3000000221']);
        }
        //1.先去追号表查追号情况  判断可以追的期数
        $trace_id = $data['trace_id'];
        $betOrder = new  betOrder();
        $res = $betOrder->traceDetail(['t_id'=>$trace_id]);
        if(empty($res)){
            return  put_encode(false,'3000000223',self::$error_code['3000000223']);
        }
        //判断追号是否已经完成
        if($res['t_status']>=2){
            return  put_encode(false,'3000000236',self::$error_code['3000000236']);
        }
        if(!is_array($data['issues'])){
            $issues = rtrim($data['issues'],',');
        }else{
            $issues = implode(',',$data['issues']);
        }
        //2.将传过来的期数 比对是否存在以及是否可以撤单
        //去盘口表里面查奖期  确认奖期是否符合撤单的情况  getTraceIusseByIssues
        $issueList = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getTraceIusseByIssues', ['lid'=>$res['t_lid'],'issue'=>$issues]),true);
        $issueList = $issueList['data'];
        $issuesArr = explode(',',$issues);
        if(count($issueList) != count($issuesArr)){
            return  put_encode(false,'3000000222',self::$error_code['3000000222']);
        }
        //3.进行撤单操作 撤销临时表以及注单表
        $arr['issue'] =  $issuesArr;
        $arr['trace_id'] =  $trace_id;
        $arr['lid'] =  $res['t_lid'];
        $arr['mg_ids'] = $res['t_mg_id'];
        $cancelTrace = $betOrder->cancelTrace($arr,$user['u_site_id'],unwrapUsername($user['u_username']),$user['u_id']);
        if($cancelTrace){
            return put_encode(true,'','');
        }else{
            return put_encode(false,'3000000224',self::$error_code['3000000224']);
        }
    }
    /**
     * 获取更多投注记录
     *  is_pay 0 未结算  未结算去临时注单表查询
     *  is_pay 1 已经结算  已经结算去crateDB 查询
     */
    public function moreBuyRecord($data = []){
        $user = $data['user'];
        $betOrder = new  betOrder();
        $tryOrder = new tryOrder();
        if(empty($user)){
            return  put_encode(false,'3000000227',self::$error_code['3000000227']);
        }
        $data['username'] = $user['u_username'];
        $data['o_id'] = 0;
        if(!empty($data['wrap_id'])){
            $o_id = unOrderWrapId($data['wrap_id']);
            if(!$o_id){
                return  put_encode(false,'3000000227',self::$error_code['3000000227']);
            }
            $data['o_id'] = $o_id;
        }
        $res = [];
        $res['amount'] = 0;
        if(!empty($data['is_pay'])){//未结算
            $data['page'] = empty($data['page'])?0:$data['page'];
            if($user['u_is_test'] == 1){  //正式会员
                $arr = $betOrder->orderList($data);
            }else{//测试会员
                $arr = $tryOrder->orderList($data);
            }
            $list = $arr['list'];
            foreach ($list as $k=>$v){
                $list[$k]['wrap_id'] = orderWrapId($v['o_id'],$v['o_issue'],$v['o_lid']);
                $modes = $this->orderModes;
                $list[$k]['modes'] = empty($modes[$v['o_modes']])?'模式有误':$modes[$v['o_modes']];
                $list[$k]['is_trace'] = $v['o_trace_id'] == 0?'否':'是';
                $lidDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\lottery', 'getLottery',$v['o_lid']),true);
                $list[$k]['lidName'] = $lidDetail['data']['cname'];
                //是否撤单(0未撤单 1用户撤单 2追中撤单 3出号撤单 4未开撤单 9管理员撤单
                switch ($v['o_is_cancel']){
                    case 0:
                        $list[$k]['status'] = '未撤单';
                        break;
                    case 1:
                        $list[$k]['status'] = '用户撤单';
                        break;
                    case 2:
                        $list[$k]['status'] = '追中撤单';
                        break;
                    case 3:
                        $list[$k]['status'] = '出号撤单';
                        break;
                    case 4:
                        $list[$k]['status'] = '未开撤单';
                        break;
                    case 9:
                        $list[$k]['status'] = '管理员撤单';
                        break;
                    case 5:
                        $list[$k]['status'] = '追中撤单';
                        break;
                }
                $res['amount'] += $v['o_amount'];
            }
            $res['list'] = $list;
            $page['count'] = $arr['count'];
            $page['countPage'] = ceil($page['count']/10);
            $page['curPage'] = $data['page']+1;
            $page['pre'] = ($data['page']-1) < 0?0:($data['page']-1);
            $page['next'] = ($data['page']>= $page['countPage']-1)? ($page['countPage']-1):($data['page']+1);
            $page['last'] = $page['countPage']-1;
            $page['lid'] = $data['lid'];
            $page['start_time'] = $data['start_time'];
            $page['end_time'] = $data['end_time'];
            $page['is_pay'] = $data['is_pay'];
            $res['wrap_id'] = $data['wrap_id'];
            if(empty($data['o_id'])){
                $res['page'] = $this->recordPage($page);
            }else{
                $res['page'] = '';
            }
            return  put_encode($res,'','');
        }else{//已经结算 到crateDB 查看
            $page = empty($data['page'])?0:$data['page'];
            $this->connectCrate();
            if($user['u_is_test'] == 1){  //正式会员
                $table = 'ffc_order';
            }else{//测试会员
                $table = 'ffc_order_istest';
            }
            $where = '';
            if(!empty($data['start_time']) && !empty($data['end_time'])){
                $cpage['start_time'] = $data['start_time'];
                $cpage['end_time'] = $data['end_time'];
                $data['start_time'] = strtotime($data['start_time'])*1000;
                $data['end_time'] = date('Y-m-d H:i:s',strtotime($data['end_time'])+60*60*24);
                $data['end_time'] = strtotime($data['end_time'])* 1000;
                $where .=" and o_add_time> {$data['start_time']} and o_add_time<{$data['end_time']} ";
            }
            if(!empty($o_id)){
                $where .=" and o_id=$o_id ";
            }
            $start = abs(10*$page);
            //"select * from `ffc_orders_temp` where o_lid={$data['lid']} AND  o_username='{$data['username']}' $where order by o_add_time DESC limit $start,10"

            $cratesql = "select * from $table where o_lid={$data['lid']} AND  o_username='{$data['username']}' and  o_deleteflag=0   $where  ORDER  BY  o_add_time DESC  limit 10 offset  $start";
            $crateData = $this->conn->query($cratesql);
            $list = $crateData->fetchAll();
            $crateCountSql = "select count(*) from $table where o_lid={$data['lid']} AND  o_username='{$data['username']}' and  o_deleteflag=0     $where  limit 1";
            $countData = $this->conn->query($crateCountSql);
            $count = $countData->fetch();
            foreach ($list as $k=>$v){
                $list[$k]['wrap_id'] = orderWrapId($v['o_id'],$v['o_issue'],$v['o_lid']);
                $modes = $this->orderModes;
                $o_modes = "{$v['o_modes']}";
                $list[$k]['modes'] = empty($modes[$o_modes])?'模式有误':$modes[$o_modes];
                $list[$k]['is_trace'] = $v['o_trace_id'] == 0?'否':'是';
                $lidDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\lottery', 'getLottery',$v['o_lid']),true);
                $list[$k]['lidName'] = $lidDetail['data']['cname'];
                $list[$k]['o_amount'] = round($v['o_amount']/1000000,4);
                $list[$k]['o_wins'] = round($v['o_wins']/1000000,4);
                $list[$k]['o_add_time'] = date('Y-m-d H:i:s',$list[$k]['o_add_time']/1000);
                //是否撤单(0未撤单 1用户撤单 2追中撤单 3出号撤单 4未开撤单 9管理员撤单
                switch ($v['o_is_cancel']){
                    case 0:
                        if($v['o_is_jiesuan'] == 0 ){
                            $list[$k]['status'] = '未判断';
                        }else if($v['o_is_jiesuan'] == 1){
                            $list[$k]['status'] = '中奖';
                        }else if($v['o_is_jiesuan'] == 2){
                            $list[$k]['status'] = '未中奖';
                        }
                        break;
                    case 1:
                        $list[$k]['status'] = '用户撤单';
                        break;
                    case 2:
                        $list[$k]['status'] = '追中撤单';
                        break;
                    case 3:
                        $list[$k]['status'] = '出号撤单';
                        break;
                    case 4:
                        $list[$k]['status'] = '未开撤单';
                        break;
                    case 9:
                        $list[$k]['status'] = '管理员撤单';
                        break;
                    case 5:
                        $list[$k]['status'] = '追中撤单';
                        break;
                }
                $res['amount'] += $list[$k]['o_amount'];
            }

            $res['list'] = $list;
            $cpage['count'] = $count[0];
            $cpage['countPage'] = ceil($cpage['count']/10);
            $cpage['curPage'] = $data['page']+1;
            $cpage['pre'] = ($data['page']-1) < 0?0:($data['page']-1);
            $cpage['next'] = ($data['page']>= $cpage['countPage']-1)? ($cpage['countPage']-1):($data['page']+1);
            $cpage['last'] = $cpage['countPage']-1;
            $cpage['lid'] = $data['lid'];
            $cpage['is_pay'] = $data['is_pay'];
            $res['wrap_id'] = $data['wrap_id'];
            if(empty($data['o_id'])){
                $res['page'] = $this->recordPage($cpage);
            }else{
                $res['page'] = '';
            }
            return  put_encode($res,'','');
        }
    }

    /**
     * 获取更多记录分页
     */
    public function recordPage($data = []){
        if($data['curPage'] < 0){

        }
          $str = '  <div class="Page">
                        <div id="pageList">['.$data['curPage'].'/'.$data['countPage'].'] 总计'.$data['count'].'条记录
                            <span class="curPage">'.$data['curPage'].'&nbsp;</span>';
        if($data['curPage']<$data['countPage']){
            $str .= '<a href="?start_time='.$data['start_time'].'&end_time='.$data['end_time'].'&curPage='.$data['curPage'].'&is_pay='.$data['is_pay'].'&lid='.$data['lid'].'">['.($data['curPage']+1).']</a>&nbsp;&nbsp;';
        }
          $str .='  <a href="?start_time='.$data['start_time'].'&end_time='.$data['end_time'].'&curPage='.$data['pre'].'&is_pay='.$data['is_pay'].'&lid='.$data['lid'].'">上一页</a>&nbsp;
                    <a href="?start_time='.$data['start_time'].'&end_time='.$data['end_time'].'&curPage='.$data['next'].'&is_pay='.$data['is_pay'].'&lid='.$data['lid'].'">下一页</a>&nbsp;
                    <a href="?start_time='.$data['start_time'].'&end_time='.$data['end_time'].'&curPage=0'.'&is_pay='.$data['is_pay'].'&lid='.$data['lid'].'">首页</a>&nbsp;
                    <a href="?start_time='.$data['start_time'].'&end_time='.$data['end_time'].'&curPage='. $data['last'].'&is_pay='.$data['is_pay'].'&lid='.$data['lid'].'">尾页</a>
                </div>
            </div>';
        return $str;
    }
    /**
     * 获取更多追号记录
     */
    public function moreTraceRecord($data = []){
        $user = $data['user'];
        $betOrder = new  betOrder();
        if(empty($user)){
            return  put_encode(false,'3000000227',self::$error_code['3000000227']);
        }
        $data['username'] = $user['u_username'];
        if(!empty($data['wrap_id'])){
            $t_id = unOrderWrapId($data['wrap_id']);
            if(!$t_id){
                return  put_encode(false,'3000000228',self::$error_code['3000000228']);
            }
            $data['t_id'] = $t_id;
        }
        $t_id = empty($data['t_id'])?0:$data['t_id'];
        $res = $betOrder->moreTraceRecord($data);
        $res['amount'] = 0;
        $list = $res['list'];
        foreach ($list as $k=>$v){
            $lidDetail = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\lottery', 'getLottery',$v['t_lid']),true);
            $list[$k]['lidName'] = $lidDetail['data']['cname'];
             $list[$k]['status'] = '';
                if ($v['t_status'] == 0) {
                    $list[$k]['status'] = '未开始';
                } elseif ($v['t_status'] == 1) {
                    $list[$k]['status'] = '正在进行';
                } elseif ($v['t_status'] == 2) {
                    $list[$k]['status'] = '已完成';
                } elseif ($v['t_status'] == 3) {
                    $list[$k]['status'] = '已取消';
                }
                $list[$k]['t_stop'] = ($list[$k]['t_stop_on_win'] == 1)?'是':'否';
                $list[$k]['status_time'] = '(' . $v['t_finish_times'] . '/' . $v['t_trace_times'] . ')';
                $list[$k]['wrap_id'] = orderWrapId($v['t_id'], $v['t_start_issue'], $v['t_lid']);
                $list[$k]['url'] = url('Game/traceDetail').'?issue='.$v['t_start_issue'].'&lid='.$v['t_lid'].'&wrapId='. $list[$k]['wrap_id'];
                $modes = $this->orderModes;
                $o_modes = "{$v['t_modes']}";
                $list[$k]['modes'] = empty($modes[$o_modes])?'模式有误':$modes[$o_modes];
                $res['amount'] += $v['t_total_amount'];
        }
        $cpage['start_time'] = $data['start_time'];
        $cpage['end_time'] = $data['end_time'];
        $res['list'] = $list;
        $cpage['count'] = $res['count'];
        $cpage['countPage'] = ceil($cpage['count']/10);
        $cpage['curPage'] = $data['page']+1;
        $cpage['pre'] = ($data['page']-1) < 0?0:($data['page']-1);
        $cpage['next'] = ($data['page']>= $cpage['countPage']-1)? ($cpage['countPage']-1):($data['page']+1);
        $cpage['last'] = $cpage['countPage']-1;
        $cpage['lid'] = $data['lid'];
        $cpage['is_pay'] = 0;
        $res['wrap_id'] = $data['wrap_id'];
        if(empty($data['t_id'])){
            $res['page'] = $this->recordPage($cpage);
        }else{
            $res['page'] = '';
        }
        return put_encode($res,'','');
    }
}