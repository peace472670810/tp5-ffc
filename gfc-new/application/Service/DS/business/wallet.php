<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/19
 * Time: 17:20
 * 钱包地址访问接口
 */

namespace app\Service\DS\business;
use think\image\Exception;
use think\Log;

class wallet
{
    public  static  $error_code = [
        '100000' => 'OK',
        '110001' => '钱包中心系统错误',
        '110002' => '钱包中心账号异常',
        '110009' => '钱包中心参数错误',
        '110010' => '钱包中心用户未找到',
        '110011' => '钱包中心用户已退出',
        '110012' => '钱包中心用户余额不足',
        '110013' => '钱包中心鉴权失败，md5加密解密不对',
        '110014' => '钱包中心没有权限',
        '110015' => '钱包中心重复提交请求',
        '110018' => '钱包中心注单不存在',
        'money is not enough' => '钱包中心余额不足',
        '100001' => '钱包中心余额不足',
        '110006' => '钱包中心user is not start ,this account is not use',
//        '110002' => '钱包中心this account is unusual( 发生情况数据库被手动修改用户金额)',
        '112007' => '用户名不能为空！',
        '10011033' =>'平台用户名参数不对',
        '10011034' =>'平台用户名参数不对',
        '3000000235' => 'DS API订单参数无效',
    ];

    const DS_ACTION_CANCEL_WIN = 5;
    const DS_ACTION_LOSE = 3;
    const DS_ACTION_WIN = 2;
    const DS_TRANSID = "DS";
    const DS_LOTTO_TYPE = 2;
    const DS_USER_PASS = 'ds123456';
    const DS_TOPTREE_USER = 'mysiteadmin';
    const DS_TOKEN_LIVE = 600;
    public static  $DS_ACTION_BUY = 1;//下注
    public static $DS_ACTION_CANCEL = 4;//追号撤单
    public  static  $DS_TRANSID = 'DS';
    //彩种简称
    static $GAME_NAME_MAP = array(
        2  => '重庆时时彩' ,
        26 =>'山东11选5',
        8  => '新疆时时彩',
        27 => '江西11选5',
        24 => '广东11选5',
        14 =>'天津时时彩',
        28 =>'福彩3D',
        29 =>'排列三/五',
        9 => '江苏快三',
        6 =>'北京赛车',
        30 =>'湖北快3',
    );

    /**
    2  重庆时时彩  52002
    26 山东11选5 52001
    8  新疆时时彩 52007
    27 江西11选5 52005
    24 广东11选5 52006
    14 天津时时彩 52012
    28 福彩3D  52009
    29 排列三/五  52010
    9  江苏快三 52008
    30 湖北快3 52016
    6  北京赛车 52015
     *
     *
     * //        2  => 'CQSSC' ,
    //        26 =>'SD11Y',
    //        8  => 'XJSSC',
    //        27 => 'JX115',
    //        24 => 'GD115',
    //        14 =>'TJSSC',
    //        28 =>'FC3D',
    //        29 =>'P3P5',
    //        9 => 'JSKS',
    //        6 =>'PK10',
    //        30 =>'HBKS',
     *
     *
     *
     *
     *
     * 52001:山东11选5
     * 52002:重庆时时彩
     * 52003:黑龙江时时彩
     * 52004:重庆11选5
     * 52005:江西11选5
     * 52006:广东11选5
     * 52007:新疆时时彩
     * 52008:江苏快三
     * 52009:福彩3D
     * 52010:体彩P3P5
     * 52011:分分彩
     * 52012:天津时时彩
     * 52013:快三分分彩
     * 52016 湖北快三
     *
     * lottery_id    名称    显示名称    类型    单期周期    允许录号时间    奖期规则    排序    状态    操作
     * 2    CQSSC    重庆时时彩    数字类型    300  600  300    30  30  30    Ymd-[n3]|1,1,0    100    使用中    修改  玩法组  奖金组  奖期
     * 26    SD11Y    山东11选5    乐透同区型    600    60    Ymd-[n3]|0,0,0    100    使用中    修改  玩法组  奖金组  奖期
     * 3    HLJSSC    黑龙江时时彩    数字类型    600    30    [n7]|1,1,1    100    使用中    修改  玩法组  奖金组  奖期
     * 8    XJSSC    新疆时时彩    数字类型    600    30    Ymd-[n2]|0,0,0    100    使用中    修改  玩法组  奖金组  奖期
     * 5    CQ115    重庆11选5    乐透同区型    600    30    Ymd-[n3]|0,0,0    100    禁用    修改  玩法组  奖金组  奖期
     * 27    JX115    江西11选5    乐透同区型    600    30    Ymd-[n3]|0,0,0    100    使用中    修改  玩法组  奖金组  奖期
     * 24    GD115    广东11选5    乐透同区型    600    30    Ymd-[n3]|0,0,0    100    使用中    修改  玩法组  奖金组  奖期
     * 14    TJSSC    天津时时彩    数字类型    600    30    Ymd-[n3]|0,0,0    100    使用中    修改  玩法组  奖金组  奖期
     * 28    3D    福彩3D    低频3D    36000    300    [n7]|1,1,1    100    使用中    修改  玩法组  奖金组  奖期
     * 10    P3P5    体彩P3P5    数字类型    36000    300    [n7]|1,1,1    100    使用中    修改  玩法组  奖金组  奖期
     * 11    YZFFC    DS分分彩    数字类型    60  60    0  0    Ymd-[n4]|1,1,0    100    使用中    修改  玩法组  奖金组  奖期
     * 9    JSKS    江苏快三    快三型    600    30    Ymd-[n3]|1,1,0    100    使用中    修改  玩法组  奖金组  奖期
     * 13    KSFFC    快三分分彩    快三型    60  60    0  0    Ymd-[n4]|1,1,0    100    使用中    修改  玩法组  奖金组  奖期
     * @var type
     */

    /**

    原来的
    1 重庆时时彩
    2 山东11选5
    4 新疆时时彩
    6 江西11选5
    7 广东11选5
    8 天津时时彩
    9 福彩3D
    10 排列三/五
    12  江苏快三
    17 湖北快3
    16 北京赛车
     *
     */
    static $GAME_TRANSFOR_MAP = array(
        '2' => '52002',
        '26' => '52001',
        '8' => '52007',
        '27' => '52005',
        '24' => '52006',
        '14' => '52012',
        '28' => '52009',
        '29' => '52010',
        '9' => '52008',
        '30' => '52016',
        '6' => '52015',
    );
    /**
     * 获取钱包
     * @param array $data
     */
    public function getBalance($data = []){
        $post = [];
        try{
            if(empty($data['username'])){
                throw new Exception(self::$error_code['112007'],'112007');
            }
            $url = config('wallet_address');
            $post['user'] = $data['username'];
            $post['siteId'] = $data['siteId'];
            $post['fromLotto'] = self::DS_LOTTO_TYPE;
            $res = json_decode($this->walletRomate($post,$url),true);
//            Log::record($res,'java_error');
            return  put_encode($res['data']['money'],'100000',self::$error_code['100000']);
        }catch (Exception $e){
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
    }
    /**
     * 平台订单撤单
     * username
     * lid
     * siteId
     * time
     * orders 注单遗漏和追号都是用这个撤单
     * @param array $data
     */
    public function cancelOrder($data = []){
        try {
            $arr = [];
            $now = strtotime($data['time']) * 1000;//传过去的是毫秒  生成注单的时间
            $arr['user'] = $data['username'];
            $userId = $data['u_id'];
            $lid = $data['lid'];
            $arr['fromLotto'] = self::DS_LOTTO_TYPE;
            $arr['siteId'] = $data['siteId'];
            $arr['transId'] = $this->buildTransId($userId, $lid);
            $arr['key'] = $this->buildKey($arr['transId'], $arr['user']);
            $arr['date'] = $now;
            $orderList = $data['orders'];
            $arr['order'] = [];
            $i = 0;
            foreach ($orderList as $k => $v) {
                $arr['order'][$i]['hash'] = $v['o_id'];
                $arr['order'][$i]['info'] = '';
                $arr['order'][$i]['item'] = '';
                $arr['order'][$i]['lotto'] = self::$GAME_NAME_MAP[$lid];
                $arr['order'][$i]['lottoType'] = self::$GAME_TRANSFOR_MAP[$lid];
                $arr['order'][$i]['money'] = $v['o_amount'];
                $arr['order'][$i]['odds'] = $v['o_odd'];
                $arr['order'][$i]['play'] = $v['o_code'];
                $arr['order'][$i]['playAmount'] = $v['o_amount'];
                $arr['order'][$i]['playMode'] = $v['o_modes'];
                $arr['order'][$i]['playMultiple'] = $v['o_multiple'];
                $arr['order'][$i]['playSum'] = $v['o_single_num'];
                $arr['order'][$i]['playWin'] = 0;
                $arr['order'][$i]['qishu'] = $v['o_issue'];
                $arr['order'][$i]['state'] = self::$DS_ACTION_CANCEL;
                $arr['order'][$i]['validMoney'] = $v['o_amount'];
                $arr['order'][$i]['winMoney'] = 0;
                $arr['order'][$i]['drawTime'] = $v['o_draw_time'];
                $i++;
            }
            $url = config('wallte_order_address');
//            Log::record(json_encode($arr),'error');
            $res = $this->walletRomate($arr, $url);
            $res = json_decode($res,true);
            if (!isset($res['code'])) {
                Log::record('错误代码不存在,撤单注单提交:'.json_encode($arr),'error');
                return put_encode(false,'110002',self::$error_code['110002']);
            }
            if($res['code'] == '100000'){
                return  put_encode(true,'100000',self::$error_code['100000']);
            }else{
                Log::record('钱包中心撤单：'.json_encode($res),'error');
                return put_encode(false,$res['code'],$res['message']);
            }
        }catch (Exception $e){
            Log::record("平台撤单访问钱包接口错误信息：".$e->getMessage()."\n ".'java_error'."\n链接：".$url,'java_error');
            return put_encode(false,'','钱包接口错误');
        }
    }
    /**
     * 平台订单生成
     * username
     * lid
     * siteId
     * time
     * orders
     * @param array $data
     */
    public function sendOrder($data = []){
            $arr = [];
            $now = strtotime($data['time']) * 1000;//传过去的是毫秒  生成注单的时间
            $arr['user'] = $data['username'];
            $userId = $data['u_id'];
            $lid = $data['lid'];
            $arr['fromLotto'] = self::DS_LOTTO_TYPE;
            $arr['siteId'] = $data['siteId'];
            $arr['transId'] = $this->buildTransId($userId, $lid);
            $arr['key'] = $this->buildKey($arr['transId'], $arr['user']);
            $arr['date'] = $now;
            $orderList = $data['orders'];
            $arr['order'] = [];
            $i = 0;
            foreach ($orderList as $k => $v) {
                $arr['order'][$i]['hash'] = $v['o_id'];
                $arr['order'][$i]['info'] = '';
                $arr['order'][$i]['item'] = '';
                $arr['order'][$i]['lotto'] = self::$GAME_NAME_MAP[$lid];
                $arr['order'][$i]['lottoType'] = self::$GAME_TRANSFOR_MAP[$lid];
                $arr['order'][$i]['money'] = $v['o_amount'];
                $arr['order'][$i]['odds'] = $v['o_odd'];
                $arr['order'][$i]['play'] = $v['o_code'];
                $arr['order'][$i]['playAmount'] = $v['o_amount'];
                $arr['order'][$i]['playMode'] = $v['o_modes'];
                $arr['order'][$i]['playMultiple'] = $v['o_multiple'];
                $arr['order'][$i]['playSum'] = $v['o_single_num'];
                $arr['order'][$i]['playWin'] = 0;
                $arr['order'][$i]['qishu'] = $v['o_issue'];
                $arr['order'][$i]['state'] = self::$DS_ACTION_BUY;
                $arr['order'][$i]['validMoney'] = $v['o_amount'];
                $arr['order'][$i]['winMoney'] = 0;
                $arr['order'][$i]['drawTime'] = $v['o_draw_time'];
                $i++;
            }
        try {
            $url = config('wallte_order_address');
            $res = $this->walletRomate($arr, $url);
//            Log::record(json_encode($arr),'error');
            $res = json_decode($res,true);
            if (!isset($res['code'])) {
                Log::record('错误码不存在,钱包服务器异常,注单数据:'.json_encode($arr),'error');
                return put_encode(1,$arr['transId'],'钱包中心连接失败！');
            }else if($res['code'] == 100000){
                return  put_encode(3,$arr['transId'],self::$error_code['100000']);
            }else if($res['code'] == 110012){
                return  put_encode(2,'110012','用户余额不足！');
            }else{
                Log::record('钱包中心下注:'.json_encode($res),'error');
                return  put_encode(2,$arr['transId'],"钱包中心错误，下注失败！");
            }
        }catch (Exception $e){
            Log::record("平台下注访问钱包接口错误信息：".$e->getMessage()."\n "."\n链接：".$url,'java_error');
            return put_encode(0,$arr['transId'],$e->getMessage());
        }
    }

    /**
     * 改变订单状态接口
     * @param array $data
     */
    public function editOrder($data = []){

    }
    /**
     *远程连接
     * @param $data
     * @param $url
     */
    public function walletRomate($data,$url){
        $post = json_encode($data);
        $s = curl_init();
        curl_setopt($s, CURLOPT_URL, $url);
        curl_setopt($s, CURLOPT_TIMEOUT, 7);
        curl_setopt($s, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($s, CURLOPT_MAXREDIRS, 1);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($s, CURLOPT_POST, true);
        curl_setopt($s, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($s);
        $status = curl_getinfo($s, CURLINFO_HTTP_CODE);
        $curlError = curl_error($s);
//        Log::record($curlError,'error');
        //500 服务器超时情况  扣钱了但是没有返回
        curl_close($s);
//        if($status === 500){
//            Log::record("平台接口响应超时信息：".json_encode($curlError)."\n http状态码：".$status.'java_error'."\n链接：".$url ,'error');
//            return '1010101010';
//        }
        if(!$res){
            Log::record("平台接口错误信息：".json_encode($curlError)."\n http状态码：".$status.'java_error'."\n链接：".$url ,'error');
            return false;
        }
        return $res;
    }


    /**
     * 生成远程注单
     * @param $packageId 注单ID
     * @param $lotteryName 彩种名字
     * @param $lotteryId 彩种id
     * @param $issue 期数
     * @param $state 订单状态： 1：下注 2：派彩赢加款 3：派彩输扣款 4：订单取消  5 回滚
     * @param $amount 下注金额
     * @param $win 获奖金额 下注默认都是0
     * @param $item
     * @param $play 下注内容
     * @param $odds 盘口
     * @param $info 玩法内容
     * @param $playMode 模式
     * @param $playSum 单倍注数
     * @param $playMultiple 倍数
     * @param $playAmount 下注金额
     * @param $playWin 赢钱金额
     * @return array
     * @throws Exception
     */
    public function buildDsOrder($packageId, $lotteryName, $lotteryId, $issue, $state, $amount, $win, $item, $play, $odds, $info, $playMode, $playSum, $playMultiple, $playAmount, $playWin)
    {
        if (empty($packageId) || empty($issue) || empty($lotteryId) || empty($state)) {
            throw new Exception('3000000235',self::$error_code['3000000235']);
        }
        $order = array();
        $order['hash'] = $packageId;
        $order['lotto'] = $lotteryName;
        $order['lottoType'] = '';
        $order['qishu'] = $issue;
        $order['state'] = $state;
        $order['validMoney'] = $amount;
        $order['money'] = $amount;
        $order['winMoney'] = $win;
        $order['item'] = $item;
        $order['play'] = $play;
        $order['odds'] = $odds;
        $order['info'] = $info;
        $order['playMode'] = $playMode;
        $order['playSum'] = $playSum;
        $order['playMultiple'] = $playMultiple;
        $order['playAmount'] = $playAmount;
        $order['playWin'] = $playWin;
        //不必要的字段
        foreach ($order as $k => $v) {
            if (empty($v) && $v != 0) {
                unset($order[$k]);
            }
        }
        return $order;
    }

    public function buildKey($transId, $user)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $len = strlen($chars);
        $a = '';
        for ($i = 0; $i < 5; $i++) {
            $a .= $chars[rand(0, $len - 1)];
        }
        $b = '';
        for ($i = 0; $i < 6; $i++) {
            $b .= $chars[rand(0, $len - 1)];
        }
        return $a . md5($user . $transId) . $b;
    }

    /**
     * 创建独一无二的交互id
     */
    public function buildTransId($userId,$lid )
    {
        return self::$DS_TRANSID . $userId . '_' .$lid. time().rand(0,1000).rand(0,1000).rand(0,1000). '_' . self::$DS_ACTION_BUY;
    }
}