<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/30
 * Time: 19:20
 */

namespace app\Service\lottery\business;
use app\Service\DS\business\issue;
use app\Service\lottery\model\Methods as methods_model;
use think\image\Exception;
use app\Service\lottery\business\lottery;
use app\Service\lottery\business\issues;
use think\Log;

class methods
{
    public static  $error_code = [
        '60000000' => '玩法组id参数有误！',
        '60000002' => '玩法参数有误！',
        '60000001' => '不存在该玩法！',
        '60000003' => '彩种lid参数有误！',
    ];
    public  $model = null;
    public $lottery = null;
    public $issue = null;
    //三星包点注数对应表
    static $SXBD = array(
        0 => '1', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '7', 7 => '8', 8 => '10', 9 => '12',
        10 => '13', 11 => '14', 12 => '15', 13 => '15', 14 => '15', 15 => '15', 16 => '14', 17 => '13', 18 => '12',
        19 => '10', 20 => '8', 21 => '7', 22 => '5', 23 => '4', 24 => '3', 25 => '2', 26 => '1', 27 => '1',
    );
    //二星包点注数对应表
    static $EXBD = array(
        0 => '1', 1 => '1', 2 => '2', 3 => '2', 4 => '3', 5 => '3', 6 => '4', 7 => '4', 8 => '5', 9 => '5',
        10 => '5', 11 => '4', 12 => '4', 13 => '3', 14 => '3', 15 => '2', 16 => '2', 17 => '1', 18 => '1',
    );
    static $EXZUHZ = array(
        1 => '1',
        2 => '1',
        3 => '2',
        4 => '2',
        5 => '3',
        6 => '3',
        7 => '4',
        8 => '4',
        9 => '5',
        10 => '4',
        11 => '4',
        12 => '3',
        13 => '3',
        14 => '2',
        15 => '2',
        16 => '1',
        17 => '1',
    );
    //(0-10注数997,26-36注数997,11=>348,12注数415,13注数480,14注数540,15注数592,16注数633,17注数660,18注数670,19注数660,20注数633,21注数592,22注数540,23注数480,24注数415,25注数348)
    static $DM_QXSIZH = array(
        '0-10' => '9',
        '26-36' => '9',
        11 => '1',
        12 => '2',
        13 => '3',
        14 => '4',
        15 => '5',
        16 => '6',
        17 => '7',
        18 => '8',
        19 => '7',
        20 => '6',
        21 => '5',
        22 => '4',
        23 => '3',
        24 => '2',
        25 => '1',
    );
    static $DM_QXEZH = array(
        0 => '1',
        1 => '2',
        2 => '3',
        3 => '4',
        4 => '5',
        5 => '6',
        6 => '7',
        7 => '8',
        8 => '9',
        9 => '10',
        10 => '9',
        11 => '8',
        12 => '7',
        13 => '6',
        14 => '5',
        15 => '4',
        16 => '3',
        17 => '2',
        18 => '1',
    );
    static $SXZXKD = array(
        0 => '10',
        1 => '54',
        2 => '96',
        3 => '126',
        4 => '144',
        5 => '150',
        6 => '144',
        7 => '126',
        8 => '96',
        9 => '54',
    );
    static $EXZXKD = array(
        0 => '10',
        1 => '18',
        2 => '16',
        3 => '14',
        4 => '12',
        5 => '10',
        6 => '8',
        7 => '6',
        8 => '4',
        9 => '2',
    );
    //三星和值注数对应表
    static $SXHZ = array(
        0 => '1', 1 => '3', 2 => '6', 3 => '10', 4 => '15', 5 => '21', 6 => '28', 7 => '36', 8 => '45', 9 => '55', 10 => '63', 11 => '69', 12 => '73', 13 => '75',
        14 => '75', 15 => '73', 16 => '69', 17 => '63', 18 => '55', 19 => '45', 20 => '36', 21 => '28', 22 => '21', 23 => '15', 24 => '10', 25 => '6', 26 => '3', 27 => '1',
    );
    //二星和值注数对应表
    static $EXHZ = array(
        0 => '1', 1 => '2', 2 => '3', 3 => '4', 4 => '5', 5 => '6', 6 => '7', 7 => '8', 8 => '9', 9 => '10',
        10 => '9', 11 => '8', 12 => '7', 13 => '6', 14 => '5', 15 => '4', 16 => '3', 17 => '2', 18 => '1',
    );
    //三星组选和值注数对应表(低频特有)
    static $SXZXHZ = array(
        1 => '1', 2 => '2', 3 => '2', 4 => '4', 5 => '5', 6 => '6', 7 => '8', 8 => '10', 9 => '11', 10 => '13', 11 => '14', 12 => '14', 13 => '15',
        14 => '15', 15 => '14', 16 => '14', 17 => '13', 18 => '11', 19 => '10', 20 => '8', 21 => '6', 22 => '5', 23 => '4', 24 => '2', 25 => '2', 26 => '1',
    );
    //山东定单双 0单5双:750.0000元 (1注) 5单0双:125.0000元 (6注)1单4双:25.0000元 (30注)4单1双:10.0000元 (75注)2单3双:5.0000元 (150注)3单2双:3.7000元 (200注)
    static $SDDDS = array('0单5双', '5单0双', '1单4双', '4单1双', '2单3双', '3单2双');
    //快乐扑克
    static $pokerNumMaps = array(
        1 => 'A', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => 'T', 11 => 'J', 12 => 'Q', 13 => 'K',
    );
    static $pokerSuitMaps = array(
        's' => '黑桃', 'h' => '红桃', 'c' => '梅花', 'd' => '方块',
    );
    static $PK10NUMS = array(
        '01', '02', '03', '04', '05', '06', '07', '08', '09', '10'
    );
    static $SXTSH = array(
        '豹子', '顺子', '对子', '半顺', '杂六',
    );

    /**
     * case 'DM_JSHZ':
    case 'DM_JSETFX':
    case 'DM_JSSTTX':
    case 'DM_JSSTDX':
    case 'DM_KSXT':
    case 'DM_JSEBT':
    case 'DM_KSRXY':
     * @var type
     */
    static $KSSBNUMS = array(
        'DM_KSXT' => array(
            0 => '大',
            1 => '单',
            15 => '小',
            16 => '双',),
        'DM_JSETFX' => array(
            2 => '66*',
            3 => '55*',
            4 => '44*',
            12 => '33*',
            13 => '22*',
            14 => '11*',
        ),
        'DM_JSSTDX' => array(
            5 => '666',
            6 => '555',
            7 => '444',
            8 => '333',
            9 => '222',
            10 => '111',
        ),
        'DM_JSSTTX' => array(
            11 => '111 222 333 444 555 666',),
        'DM_JSHZ' => array(
            17 => '17',
            18 => '16',
            19 => '15',
            20 => '14',
            21 => '13',
            22 => '12',
            23 => '11',
            24 => '10',
            25 => '9',
            26 => '8',
            27 => '7',
            28 => '6',
            29 => '5',
            30 => '4',
        ),
        'DM_JSEBT' => array(
            31 => '5,6',
            32 => '4,6',
            33 => '4,5',
            34 => '3,6',
            35 => '3,5',
            36 => '3,4',
            37 => '2,6',
            38 => '2,5',
            39 => '2,4',
            40 => '2,3',
            41 => '1,6',
            42 => '1,5',
            43 => '1,4',
            44 => '1,3',
            45 => '1,2',
        ),
        'DM_KSRXY' => array(
            46 => '6',
            47 => '5',
            48 => '4',
            49 => '3',
            50 => '2',
            51 => '1',
        )
    );

    const CACHE_TIME = 7200;
    /**
     * 玩法初始化
     * methods constructor.
     */
    public function __construct()
    {
        $this->model = new methods_model();
        $this->lottery = new lottery();
        $this->issue =  new issues();
    }


    /**
     * 根据玩法组获取玩法列表
     */
    public  function getMethodList($data){
        if(!is_numeric($data['mg_id'])){
            return   put_encode(false,'60000000',self::$error_code['60000000']);
        }
        $list =  $this->model->getMothodList($data['mg_id']);
        if($list){
            return  put_encode($list,'','');
        }
        return   put_encode(false,'60000001',self::$error_code['60000001']);
    }

    /**
     * 获取彩种下的玩法封锁值列表
     * 去数据库读取
     */
    public function getLockmethods($data = []){
        if(!is_numeric($data['lid'])){
            return   put_encode(false,'60000003',self::$error_code['60000003']);
        }
        $list =  $this->model->getLockmethodsList($data['lid']);
        if($list){
            return  put_encode($list,'','');
        }
        return   put_encode(false,'60000001',self::$error_code['60000001']);
    }

    /**
     * 前台下注调用  内部模块调用
     * 根据玩法ids 获取玩法封锁值  封锁值为0 的直接不进行验证
     */
    public function getLockmethodsPrize($data = []){
        $mids = $data['mids'];
        $list = $this->model->query(" select m_id,m_flock from ffc_methods where m_id in ({$mids}) and m_flock>0");
        return $list;
    }
    /**
     * 修改玩法封锁值
     */
    public function editLockmethods($data = []){
        $lid = $data['lid'];
        unset($data['lid']);
        unset($data['提交']);
        $mids = [];
        $i = 0;
        foreach ($data as $k=>$v){
            $mid =  explode('-',$k);
            $mids[$i]['mid'] = $mid[1];
            $mids[$i]['value'] = round($v,4);
            $i++;
        }
        //采用事务
        try{
            $this->model->startTrans();
            foreach ($mids as $v){
                $this->model->query("update ffc_methods set m_flock={$v['value']} where m_id={$v['mid']} and m_lid={$lid}");
            }
            $this->model->commit();
            return  put_encode(true,'','');
        }catch (Exception $e){
            $this->model->rollback();
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
    }
    /**
     * 根据彩种获取玩法列表
     */
    public  function getMethodBylid($data){
        if(!is_numeric($data['lid'])){
            return   put_encode(false,'60000003',self::$error_code['60000003']);
        }
        $list =  $this->model->getMethodBylid($data['lid']);
        if($list){
            return  $list;
        }
        return  [];
    }
    /**
     * 根据玩法组获取玩法列表 下标就是玩法id
     */
    public function getMethodBylidshowId($data){
        if(!is_numeric($data['lid'])){
            return   put_encode(false,'60000003',self::$error_code['60000003']);
        }
        $list =  $this->model->getMethodBylid($data['lid'],true);
        if($list){
            return  $list;
        }
        return  [];
    }
    /**
     * 获取玩法详情
     */
    public function  getMothodDetail($data){
        if(!is_numeric($data['m_id'])){
            return  put_encode(false,'60000002',self::$error_code['60000002']);
        }
        $detail = $this->model->getMothodDetail($data['m_id']);
        if($detail){
            return  put_encode($detail,'','');
        }
        return  put_encode(false,'60000001',self::$error_code['60000001']);
    }

    /**
     * 获取玩法注数
     * 根据玩法id 和号码获取玩法注数
     */
    public function getCodeNums($data = []){
        $code = $data['code'];
        $m_id = $data['m_id'];
        $res = $this->model->getMothodDetail($m_id);
        $method = [
            'method_id'=>$res['m_id'],
            'lottery_id'=>$res['m_lid'],
            'mg_id'=>$res['m_mg_id'],
            'name'=>$res['m_name'],
            'cname'=>$res['m_cname'],
            'team'=>$res['m_team'],
            'description'=>$res['m_description'],
            'max_comb'=>$res['m_max_comb'],
            'max_money'=>$res['m_max_money'],
            'levels'=>$res['m_levels'],
            'is_lock'=>$res['m_is_lock'],
            'field_def'=>$res['m_field_def'],
            'is_odds'=>$res['m_is_odds'],
            'expands'=>$res['m_expands'],
            'can_input'=>$res['m_can_input'],
            'status'=>$res['m_status'],
            'sort'=>$res['m_sort'],
            'flock'=>$res['m_flock'],
        ];
        $nums = $this->isLegalCode($method,$code);
        return  put_encode($nums,'','');
    }
    /**
     * author nyjah
     * 判断扑克形态
     * @param $code string '4s 6c Kd'
     * @return string
     */
    static public function getPokerForm($code) {
        if (!preg_match('`^([ATJQK2-9][hscd])(\s([ATJQK2-9][hscd])){2}$`Ui', $code)) {
            throw new Exception('参数无效');
        }
        $pokerNumMaps = array(
            'A' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            'T' => 10,
            'J' => 11,
            'Q' => 12,
            'K' => 13,
        );
        $openNumber = explode(" ", $code);
        //判断形态
        $colors = array($openNumber[0][1], $openNumber[1][1], $openNumber[2][1]);
        $codeNum = array($pokerNumMaps[$openNumber[0][0]], $pokerNumMaps[$openNumber[1][0]], $pokerNumMaps[$openNumber[2][0]]);
        sort($codeNum);
        if (($codeNum[0] + 1 == $codeNum[1] && $codeNum[0] + 2 == $codeNum[2]) || ($codeNum[0] == 1 && $codeNum[1] == 12 && $codeNum[2] == 13)) {
            if (count(array_unique($colors)) == 1) {
                $form = '同花顺';
            } else {
                $form = '顺子';
            }
        } else {
            if (count(array_unique($colors)) == 1) {
                $form = '同花';
            } else {
                if (count(array_unique($codeNum)) == 1) {
                    $form = '豹子';
                } elseif (count(array_unique($codeNum)) == 2) {
                    $form = '对子';
                } else {
                    $form = '散牌';
                }
            }
        }

        return $form;
    }

    static public function getRxPos($needed, $posStr) {

        if (!preg_match('`^[万千百十个]{1,}$`ui', $posStr)) {
            return array();
        }
        $pos = array();
        if (strpos($posStr, '万') !== false) {
            $pos[] = 0;
        }
        if (strpos($posStr, '千') !== false) {
            $pos[] = 1;
        }
        if (strpos($posStr, '百') !== false) {
            $pos[] = 2;
        }
        if (strpos($posStr, '十') !== false) {
            $pos[] = 3;
        }
        if (strpos($posStr, '个') !== false) {
            $pos[] = 4;
        }
        $pos = self::C($pos, $needed);
        $ret = array();
        foreach ($pos as $v) {
            $tmp = str_split($v);
            sort($tmp);
            $ret[] = $tmp;
        }


        return $ret;
    }
    //分析低频3D号码形态 按后三处理
    static public function analyzeLow3D($code) {
        if (!preg_match('`^\d{3}$`', $code)) {
            return false;
        }

        $result = array();
        //分析三星组态
        $parts = str_split($code);
        $tmp = array_unique($parts);
        if (count($tmp) == 3) {
            $result['SX'] = '组六';
        } elseif (count($tmp) == 2) {
            $result['SX'] = '组三';
        } else {
            $result['SX'] = '豹子';
        }

        //三星和值
        $result['SXHZ'] = array_sum($parts);

        //三星大小单双
        $nums = array();
        $nums[] = ($parts[0] % 2 == 1 ? '3' : '4') . ($parts[0] < 5 ? '2' : '1');
        $nums[] = ($parts[1] % 2 == 1 ? '3' : '4') . ($parts[1] < 5 ? '2' : '1');
        $nums[] = ($parts[2] % 2 == 1 ? '3' : '4') . ($parts[2] < 5 ? '2' : '1');
        $result['SXDXDS'] = self::expand($nums);
        $result['SXDXDS'] = str_replace(array(1, 2, 3, 4), array('大', '小', '单', '双'), $result['SXDXDS']);
        //二星大小单双
        $nums = array();
        $nums[] = ($parts[1] % 2 == 1 ? '3' : '4') . ($parts[1] < 5 ? '2' : '1');
        $nums[] = ($parts[2] % 2 == 1 ? '3' : '4') . ($parts[2] < 5 ? '2' : '1');
        $result['EXDXDS'] = self::expand($nums);
        $result['EXDXDS'] = str_replace(array(1, 2, 3, 4), array('大', '小', '单', '双'), $result['EXDXDS']);
        //前二大小单双
        $nums = array();
        $nums[] = ($parts[0] % 2 == 1 ? '3' : '4') . ($parts[0] < 5 ? '2' : '1');
        $nums[] = ($parts[1] % 2 == 1 ? '3' : '4') . ($parts[1] < 5 ? '2' : '1');
        $result['QEDXDS'] = self::expand($nums);
        $result['QEDXDS'] = str_replace(array(1, 2, 3, 4), array('大', '小', '单', '双'), $result['QEDXDS']);

        //二星和值
        array_shift($parts);
        $tmp = array_unique($parts);
        if (count($tmp) == 2) {
            $result['EX'] = '非对子';
        } else {
            $result['EX'] = '对子';
        }
        $result['EXHZ'] = array_sum($parts);

        return $result;
    }
    /**
     * 得到展开式 不通用 仅支持2，3，4，5 CQSSC及类似适用
     * @param array $nums 原数组 如array('12','234','12345')
     * @return array $result 按排列展开后的数组
     */
    static public function expand($nums) {
        $result = array();
        $tmpNums = array();
        foreach ($nums as $v) {
            $tmp = str_split($v);
            sort($tmp);
            $tmpNums[] = $tmp;
        }

        switch (count($nums)) {
            case 1:
                $result = reset($tmpNums);
                break;
            case 2:
                for ($i = 0; $i < count($tmpNums[0]); $i++) {
                    for ($j = 0; $j < count($tmpNums[1]); $j++) {
                        $result[] = $tmpNums[0][$i] . $tmpNums[1][$j];
                    }
                }
                break;
            case 3:
                for ($i = 0; $i < count($tmpNums[0]); $i++) {
                    for ($j = 0; $j < count($tmpNums[1]); $j++) {
                        for ($k = 0; $k < count($tmpNums[2]); $k++) {
                            $result[] = $tmpNums[0][$i] . $tmpNums[1][$j] . $tmpNums[2][$k];
                        }
                    }
                }
                break;
            case 4:
                for ($i = 0; $i < count($tmpNums[0]); $i++) {
                    for ($j = 0; $j < count($tmpNums[1]); $j++) {
                        for ($k = 0; $k < count($tmpNums[2]); $k++) {
                            for ($l = 0; $l < count($tmpNums[3]); $l++) {
                                $result[] = $tmpNums[0][$i] . $tmpNums[1][$j] . $tmpNums[2][$k] . $tmpNums[3][$l];
                            }
                        }
                    }
                }
                break;
            case 5:
                for ($i = 0; $i < count($tmpNums[0]); $i++) {
                    for ($j = 0; $j < count($tmpNums[1]); $j++) {
                        for ($k = 0; $k < count($tmpNums[2]); $k++) {
                            for ($l = 0; $l < count($tmpNums[3]); $l++) {
                                for ($m = 0; $m < count($tmpNums[4]); $m++) {
                                    $result[] = $tmpNums[0][$i] . $tmpNums[1][$j] . $tmpNums[2][$k] . $tmpNums[3][$l] . $tmpNums[4][$m];
                                }
                            }
                        }
                    }
                }
                break;
            default:
                throw new Exception('non-supported permutation');
                break;
        }

        return $result;
    }

    /**
     * 获取玩法号码奖金及等级
     */
    public function getCodePrizes($data = []){
        $mid = $data['mid'];
        $lid = $data['lid'];
        $code = $data['code'];
        $issue = $data['issue'];
        $amount = $data['amount'];
        $issueDetail = json_decode($this->issue->getHadOpenIusse(['lid'=>$lid,'issue'=>$issue]),true);
        $issueDetail = $issueDetail['data'];
        $method  = $this->model->getMothodDetail($mid);
        $method = [
            'method_id'=>$method['m_id'],
            'lottery_id'=>$method['m_lid'],
            'mg_id'=>$method['m_mg_id'],
            'name'=>$method['m_name'],
            'cname'=>$method['m_cname'],
            'team'=>$method['m_team'],
            'description'=>$method['m_description'],
            'max_comb'=>$method['m_max_comb'],
            'max_money'=>$method['m_max_money'],
            'levels'=>$method['m_levels'],
            'is_lock'=>$method['m_is_lock'],
            'field_def'=>$method['m_field_def'],
            'is_odds'=>$method['m_is_odds'],
            'expands'=>$method['m_expands'],
            'can_input'=>$method['m_can_input'],
            'status'=>$method['m_status'],
            'sort'=>$method['m_sort'],
            'flock'=>$method['m_flock'],
        ];
        $lottery = $this->lottery->getLottery($lid);
        $lottery = json_decode($lottery,true);
        $lottery = $lottery['data'];
        $level = $this->computePrize($lottery,$method,$issueDetail['ds_balls'],$code,$amount);
        $res['level'] = $level;
        $res['cname'] = $method['cname'];
        $res['prize_code'] = $issueDetail['ds_balls'];
        return  put_encode($res);
    }
    /**
     * 分析开奖号码的形态
     * @param type $code
     * @return array
     */
    static public function analyzeDigital($code) {
        if (!preg_match('`^\d{5}$`', $code)) {
            return false;
        }

        $result = array();
        //分析三星组态
        $parts = str_split(substr($code, 2, 3));
        $tmp = array_unique($parts);
        if (count($tmp) == 3) {
            $result['SX'] = '组六';
        } elseif (count($tmp) == 2) {
            $result['SX'] = '组三';
        } else {
            $result['SX'] = '豹子';
        }

        //三星和值
        $result['SXHZ'] = array_sum($parts);

        //三星大小单双 12345
        $nums = array();
        $nums[] = ($code{2} % 2 == 1 ? '3' : '4') . ($code{2} < 5 ? '2' : '1');
        $nums[] = ($code{3} % 2 == 1 ? '3' : '4') . ($code{3} < 5 ? '2' : '1');
        $nums[] = ($code{4} % 2 == 1 ? '3' : '4') . ($code{4} < 5 ? '2' : '1');
        $result['SXDXDS'] = self::expand($nums);
        $result['SXDXDS'] = str_replace(array(1, 2, 3, 4), array('大', '小', '单', '双'), $result['SXDXDS']);
        //二星大小单双
        $nums = array();
        $nums[] = ($code{3} % 2 == 1 ? '3' : '4') . ($code{3} < 5 ? '2' : '1');
        $nums[] = ($code{4} % 2 == 1 ? '3' : '4') . ($code{4} < 5 ? '2' : '1');
        $result['EXDXDS'] = self::expand($nums);
        $result['EXDXDS'] = str_replace(array(1, 2, 3, 4), array('大', '小', '单', '双'), $result['EXDXDS']);
        //前二大小单双
        $nums = array();
        $nums[] = ($code{0} % 2 == 1 ? '3' : '4') . ($code{0} < 5 ? '2' : '1');
        $nums[] = ($code{1} % 2 == 1 ? '3' : '4') . ($code{1} < 5 ? '2' : '1');
        $result['QEDXDS'] = self::expand($nums);
        $result['QEDXDS'] = str_replace(array(1, 2, 3, 4), array('大', '小', '单', '双'), $result['QEDXDS']);

        //二星和值
        array_shift($parts);
        $tmp = array_unique($parts);
        if (count($tmp) == 2) {
            $result['EX'] = '非对子';
        } else {
            $result['EX'] = '对子';
        }
        $result['EXHZ'] = array_sum($parts);

        //分析前三组态
        $parts = str_split(substr($code, 0, 3));
        $tmp = array_unique($parts);
        if (count($tmp) == 3) {
            $result['QS'] = '组六';
        } elseif (count($tmp) == 2) {
            $result['QS'] = '组三';
        } else {
            $result['QS'] = '豹子';
        }

        //前三和值
        $result['QSHZ'] = array_sum($parts);

        //前二和值
        array_pop($parts);
        $tmp = array_unique($parts);
        if (count($tmp) == 2) {
            $result['QE'] = '非对子';
        } else {
            $result['QE'] = '对子';
        }
        $result['QEHZ'] = array_sum($parts);

        // 分析中三
        $parts = str_split(substr($code, 1, 3));
        $tmp = array_unique($parts);
        if (count($tmp) == 3) {
            $result['ZS'] = '组六';
        } elseif (count($tmp) == 2) {
            $result['ZS'] = '组三';
        } else {
            $result['ZS'] = '豹子';
        }

        //中三和值
        $result['ZSHZ'] = array_sum($parts);

        return $result;
    }
    /**
     * 根据不同玩法判断是否中奖 正常情况返回0表示没有中奖，否则表示具体的单倍奖金 注意 所得结果须再x投注倍数x模式才是最终奖金！
     * 将被CRON定时调用执行，出错会抛异常，如玩法不存在，号码非法等
     * @param array $lottery 彩种数组
     * @param int $curRebate 当时选择的返点
     * @param array $method 玩法数组
     * @param string $prize_code 开奖号码
     * @param string $projectCode 用户所购号码 不同区段用,分隔，sd11y的同段多个号码用_分隔 最少包含 cur_rebate multiple amount code
     * @return float 具体奖金
     */
     public function computePrize($lottery, $method, $prize_code, $projectCode,$amount) {
        echo "下注号码：". $projectCode."\n";
        echo "开奖号码：".$prize_code."\n";
        if($lottery['lid'] == 30){//湖北快三
            $code = explode(',',$prize_code);
            $prize_code = '';
            foreach ($code as $v){
                $prize_code .= $v;
            }
        }if($lottery['lid'] == 24 || $lottery['lid'] == 26 ||$lottery['lid'] == 27 ){
             $prize_code = str_replace(',',' ',$prize_code);
         }else{
            $prize_code = str_replace(',','',$prize_code);
        }
        //辅助数据
        switch ($lottery['lottery_type']) {
            case '1':   //数字型 特指时时彩
                $helpData = self::analyzeDigital($prize_code);
                $back4 = substr($prize_code, 1, 4);
                $back3 = substr($prize_code, 2, 3);
                $back2 = substr($prize_code, 3, 2);
                $back1 = substr($prize_code, 4, 1);
                $fore4 = substr($prize_code, 0, 4);
                $fore3 = substr($prize_code, 0, 3);     //万千百 前三直选
                $fore2 = substr($prize_code, 0, 2);    //万千 前二直选
                $fore21 = substr($prize_code, 1, 1);    //千 用于前二连选的二等奖
                $foreTH = substr($prize_code, 1, 2);     //千百 用于前三连选的二等奖
                $foreH = substr($prize_code, 2, 1);     //百 用于前三连选的三等奖
                $mid3 = substr($prize_code, 1, 3);     //千百十  中三直选;
                $mid2 = substr($prize_code, 2, 2);      //千百 用于中三连选的二等奖;
                $mid1 = substr($prize_code, 3, 1);      //千百 用于中三连选的三等奖;
                break;
            case '2':   //特指11选5
                $sdfore3 = substr($prize_code, 0, 8);
                $sdfore2 = substr($prize_code, 0, 5);
                break;
            case '4':  //福彩3D 只有3个开奖号码 按后三处理
                $helpData = self::analyzeLow3D($prize_code);
                $back3 = $prize_code;
                $fore2 = substr($prize_code, 0, 2);     //百十位 用于前三连选的二等奖
                $back2 = substr($prize_code, 1, 2);     //十个位
                break;
            default:
                break;
        }
        $codes = explode("|", $projectCode);
        $allPrize = 0;
        foreach ($codes as $kk => $code) {
            //判断所购号码是否合法
            if (!$betNums = self::isLegalCode($method, $code)) {
                throw new Exception('Illegal code');
            }
            $level = 0; //大于0直接表示中奖，并且表示中的是几等奖
            //按玩法分别判断
            switch ($method['name']) {
                case 'SXZX':    //三星直选 三段 0123456789,0123456789,0123456789 复式 1000
                    //先排列展开所选号码 再和$prize_code进行比较 有一个相同为中奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    if (in_array($back3, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'SXZS':    //三星组三 一段 0123456789 复式90注 只要有2个数字相同即为中奖
                    $back3Parts = str_split($back3);
                    //如果不是组三态显然没中奖
                    $tmp = array_values(array_unique($back3Parts));
                    if (count($tmp) == 2) {
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false) {
                            $level = 1;
                        }
                    }
                    break;
                case 'SXZL':    //三星组六 一段 0123456789 复式120注
                    $back3Parts = str_split($back3);
                    $tmp = array_unique($back3Parts);
                    if (count($tmp) == 3) { //首先要是组六态
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false && strpos($code, $tmp[2]) !== false) {
                            $level = 1;
                        }
                    }
                    break;
                case 'SXLX':    //三星连选 三段 0123456789,0123456789,0123456789 复式 全包1110注
                    //兼中兼得(即可同时中一二三等奖) 百十个 十个 个 分别对应123等奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    $level = array();
                    if (in_array($back3, $expandNums)) {
                        $level[] = 1;
                    }

                    array_shift($parts);    //再判断是否二等奖
                    $expandNums = self::expand($parts);
                    if (in_array($back2, $expandNums)) {
                        $level[] = 2;
                    }

                    $tmp = array_pop($parts);   //再判断是否有三等奖
                    if (strpos($tmp, $back1) !== false) {
                        $level[] = 3;
                    }
                    break;
                case 'SXBD':    //三星包点 一段 0_1_2_3_4_..._27 买的时候可以一次选多个号码，因为有大于9的结果 豹子按直选派奖，组三态按组三派奖，组六态按组六派奖
                    // 包点与和值的区别：包点只算组合，不排列，和值相当于排列，按转直注数计，如包点3相当于3注：003，012，111，按开奖号码形态派奖
                    // 和值3相当于把包点的号码转直：003组三态转成3注，012组六态转成6注，111豹子转成1注，因此相当于买10注直选
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['SXHZ']) {
                            if ($helpData['SX'] == '组六') {
                                $level = 3;
                            } elseif ($helpData['SX'] == '组三') {
                                $level = 2;
                            } elseif ($helpData['SX'] == '豹子') {
                                $level = 1;
                            }
                        }
                    }
                    break;
                case 'SXHHZX':    //三星混合组选 仅支持单式手工录入 组三态按组三派奖，组六态按组六派奖
                    $back3Parts = str_split($back3);
                    $tmp = array_values(array_unique($back3Parts)); //522 122 121 211 112
                    $codeParts = explode(',', $code);   //252
                    $codeTmp = array_values(array_unique($codeParts));  // 12
                    sort($back3Parts);
                    sort($codeParts);
                    //按开奖号码形态分别判断
                    if (count($tmp) == 2 && count($codeTmp) == 2) {    //如果不是组三态显然没中奖
                        if ($codeParts[0] === $back3Parts[0] && $codeParts[1] === $back3Parts[1] && $codeParts[2] === $back3Parts[2]) {
                            $level = 1;
                        }
                    } elseif (count($tmp) == 3 && count($codeTmp) == 3) {
                        if ($codeParts[0] === $back3Parts[0] && $codeParts[1] === $back3Parts[1] && $codeParts[2] === $back3Parts[2]) {
                            $level = 2;
                        }
                    }
                    break;

                //前三
                case 'QSZX':    //前三直选
                    //先排列展开所选号码 再和$prize_code进行比较 有一个相同为中奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    if (in_array($fore3, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'QSZS':    //前三组三
                    $parts = str_split($fore3);
                    //如果不是组三态显然没中奖
                    $tmp = array_values(array_unique($parts));
                    if (count($tmp) == 2) {
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false) {
                            $level = 1;
                        }
                    }
                    break;
                case 'QSZL':    //前三组六
                    $parts = str_split($fore3);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 3) { //首先要是组六态
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false && strpos($code, $tmp[2]) !== false) {
                            $level = 1;
                        }
                    }
                    break;
                case 'QSLX':    //前三连选 三段 0123456789,0123456789,0123456789 复式 全包1110注
                    //兼中兼得(即可同时中一二三等奖) 万千百 千百 百 分别对应123等奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    $level = array();
                    if (in_array($fore3, $expandNums)) {
                        $level[] = 1;
                    }

                    array_shift($parts);    //再判断是否二等奖
                    $expandNums = self::expand($parts);
                    if (in_array($foreTH, $expandNums)) {
                        $level[] = 2;
                    }

                    $tmp = array_pop($parts);   //再判断是否有三等奖
                    if (strpos($tmp, $foreH) !== false) {
                        $level[] = 3;
                    }
                    break;
                case 'QSBD':
                    // 包点与和值的区别：包点只算组合，不排列，和值相当于排列，按转直注数计，如包点3相当于3注：003，012，111，按开奖号码形态派奖
                    // 和值3相当于把包点的号码转直：003组三态转成3注，012组六态转成6注，111豹子转成1注，因此相当于买10注直选
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['QSHZ']) {
                            if ($helpData['QS'] == '组六') {
                                $level = 3;
                            } elseif ($helpData['QS'] == '组三') {
                                $level = 2;
                            } elseif ($helpData['QS'] == '豹子') {
                                $level = 1;
                            }
                        }
                    }
                    break;
                case 'QSHHZX':    //前三混合组选 仅支持单式手工录入 组三态按组三派奖，组六态按组六派奖
                    $fore3Parts = str_split($fore3);
                    $tmp = array_values(array_unique($fore3Parts));
                    $codeParts = explode(',', $code);
                    $codeTmp = array_values(array_unique($codeParts));
                    sort($fore3Parts);
                    sort($codeParts);
                    //按开奖号码形态分别判断
                    if (count($tmp) == 2 && count($codeTmp) == 2) {    //如果不是组三态显然没中奖
                        if ($codeParts[0] === $fore3Parts[0] && $codeParts[1] === $fore3Parts[1] && $codeParts[2] === $fore3Parts[2]) {
                            $level = 1;
                        }
                    } elseif (count($tmp) == 3 && count($codeTmp) == 3) {
                        if ($codeParts[0] === $fore3Parts[0] && $codeParts[1] === $fore3Parts[1] && $codeParts[2] === $fore3Parts[2]) {
                            $level = 2;
                        }
                    }
                    break;
                //中三    新加
                case 'ZSZX':    //中三直选 三段 0123456789,0123456789,0123456789 复式 1000
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    if (in_array($mid3, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'ZSZS':    //中三组三 一段 0123456789 复式90注 只要有2个数字相同即为中奖
                    $mid3Parts = str_split($mid3);
                    //如果不是组三态显然没中奖
                    $tmp = array_values(array_unique($mid3Parts));
                    if (count($tmp) == 2) {
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false) {
                            $level = 1;
                        }
                    }
                    break;
                case 'ZSZL':    //中三组六 一段 0123456789 复式120注
                    $mid3Parts = str_split($mid3);
                    $tmp = array_unique($mid3Parts);
                    if (count($tmp) == 3) { //首先要是组六态
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false && strpos($code, $tmp[2]) !== false) {
                            $level = 1;
                        }
                    }
                    break;
                case 'ZSLX':    //中三连选 三段 0123456789,0123456789,0123456789 复式 全包1110注
                    //兼中兼得(即可同时中一二三等奖) 千百十 百十 十 分别对应123等奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    $level = array();
                    if (in_array($mid3, $expandNums)) {
                        $level[] = 1;
                    }

                    array_shift($parts);    //再判断是否二等奖
                    $expandNums = self::expand($parts);
                    if (in_array($mid2, $expandNums)) {
                        $level[] = 2;
                    }

                    $tmp = array_pop($parts);   //再判断是否有三等奖
                    if (strpos($tmp, $mid1) !== false) {
                        $level[] = 3;
                    }
                    break;
                case 'ZSBD':    // 中三包点
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['ZSHZ']) {
                            if ($helpData['ZS'] == '组六') {
                                $level = 3;
                            } elseif ($helpData['ZS'] == '组三') {
                                $level = 2;
                            } elseif ($helpData['ZS'] == '豹子') {
                                $level = 1;
                            }
                        }
                    }
                    break;
                case 'ZSHHZX':    //中三混合组选
                    $mid3Parts = str_split($mid3);
                    $tmp = array_values(array_unique($mid3Parts));
                    $codeParts = explode(',', $code);
                    $codeTmp = array_values(array_unique($codeParts));
                    sort($mid3Parts);
                    sort($codeParts);
                    //按开奖号码形态分别判断
                    if (count($tmp) == 2 && count($codeTmp) == 2) {    //如果不是组三态显然没中奖
                        if ($codeParts[0] === $mid3Parts[0] && $codeParts[1] === $mid3Parts[1] && $codeParts[2] === $mid3Parts[2]) {
                            $level = 1;
                        }
                    } elseif (count($tmp) == 3 && count($codeTmp) == 3) {
                        if ($codeParts[0] === $mid3Parts[0] && $codeParts[1] === $mid3Parts[1] && $codeParts[2] === $mid3Parts[2]) {
                            $level = 2;
                        }
                    }
                    break;

                //二星
                case 'EXZX':    //二星直选 0123456789,0123456789
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    if (in_array($back2, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'EXZUX':    //二星组选 0123456789 yb限制最多只能买7个号码
                    $back2Parts = str_split($back2);
                    $tmp = array_unique($back2Parts);
                    if (count($tmp) == 2) { //首先要是不同号码才可能中奖
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false) {
                            $level = 1;
                        }
                    }
                    break;
                case 'EXLX':    //二星连选 0123456789,0123456789 全包110注
                    //兼中兼得(即可同时中一二等奖) 十个 个 分别对应12等奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    $level = array();
                    if (in_array($back2, $expandNums)) {
                        $level[] = 1;
                    }

                    $tmp = array_pop($parts);   //再判断是否二等奖 仅个位相同
                    if (strpos($tmp, $back1) !== false) {
                        $level[] = 2;
                    }
                    break;
                case 'EXBD':    //二星包点 一段 0_1_2_3_4_..._18 买的时候可以一次选多个号码，因为有大于9的结果 对子按直选派奖，非对子按组选派奖
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['EXHZ']) {
                            if ($helpData['EX'] == '非对子') {
                                $level = 2;
                            } elseif ($helpData['EX'] == '对子') {
                                $level = 1;
                            }
                        }
                    }
                    break;
                //前二
                case 'QEZX':    //前二直选
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    if (in_array($fore2, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'QEZUX':   //前二组选
                    $parts = str_split($fore2);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 2) { //首先要是不同号码才可能中奖
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false) {
                            $level = 1;
                        }
                    }
                    break;
                case 'QELX':    //前二连选 0123456789,0123456789 全包110注
                    //兼中兼得(即可同时中一二等奖) 万千 千 分别对应12等奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    $level = array();
                    if (in_array($fore2, $expandNums)) {
                        $level[] = 1;
                    }

                    $tmp = array_pop($parts);   // 再判断是否二等奖 仅千位相同
                    if (strpos($tmp, $fore21) !== false) {
                        $level[] = 2;
                    }
                    break;
                case 'QEBD':
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['QEHZ']) {
                            if ($helpData['QE'] == '非对子') {
                                $level = 2;
                            } elseif ($helpData['QE'] == '对子') {
                                $level = 1;
                            }
                        }
                    }
                    break;
                //一星
                case 'YXZX':    //一星直选 个位 0123456789
                    if (strpos($code, $back1) !== false) {
                        $level = 1;
                    }
                    break;
                case 'WXDW':    //低频P3P5也有 五星定位 0123456789,0123456789,0123456789,0123456789,0123456789 或,2,3,,都是合法的
                    $prizeParts = str_split($prize_code);
                    $level = array();
                    $parts = explode(',', $code);
                    if (strpos($parts[0], $prizeParts[0]) !== false) {
                        $level[] = 1;
                    }
                    if (strpos($parts[1], $prizeParts[1]) !== false) {
                        $level[] = 2;
                    }
                    if (strpos($parts[2], $prizeParts[2]) !== false) {
                        $level[] = 3;
                    }
                    if (strpos($parts[3], $prizeParts[3]) !== false) {
                        $level[] = 4;
                    }
                    if (strpos($parts[4], $prizeParts[4]) !== false) {
                        $level[] = 5;
                    }
                    break;

                case 'WXEMBDW':
                    $parts = str_split($code);
                    $level = array();
                    $combines = self::C($parts, 2);
                    foreach ($combines as $c) {
                        if (strpos($prize_code, $c{0}) !== false && strpos($prize_code, $c{1}) !== false) {
                            $level[] = 1;
                        }
                    }
                    break;

                case 'ZSEMBDW':
                    $parts = str_split($code);
                    $level = array();
                    $combines = self::C($parts, 2);
                    foreach ($combines as $c) {
                        if (strpos($mid3, $c{0}) !== false && strpos($mid3, $c{1}) !== false) {
                            $level[] = 1;
                        }
                    }
                    break;

                case 'SSCQSEMBDW':
                    $parts = str_split($code);
                    $level = array();
                    $combines = self::C($parts, 2);
                    foreach ($combines as $c) {
                        if (strpos($fore3, $c{0}) !== false && strpos($fore3, $c{1}) !== false) {
                            $level[] = 1;
                        }
                    }
                    break;


                case 'SXEMBDW':
                    $parts = str_split($code);
                    $level = array();
                    $combines = self::C($parts, 2);
                    foreach ($combines as $c) {
                        if (strpos($back4, $c{0}) !== false && strpos($back4, $c{1}) !== false) {
                            $level[] = 1;
                        }
                    }
                    break;



                case 'ZSYMBDW'://中三一码不定位
                    $parts = str_split($code);
                    $level = array();
                    foreach ($parts as $c) {
                        if (strpos($mid3, $c{0}) !== false) {
                            $level[] = 1;
                        }
                    }
                    break;

                case 'SSCQSYMBDW'://前三一码不定位
                    $parts = str_split($code);
                    $level = array();
                    foreach ($parts as $c) {
                        if (strpos($fore3, $c{0}) !== false) {
                            $level[] = 1;
                        }
                    }
                    break;

                case 'SXYMBDW'://四星一码不定位
                    $parts = str_split($code);
                    $level = array();
                    foreach ($parts as $c) {
                        if (strpos($back4, $c{0}) !== false) {
                            $level[] = 1;
                        }
                    }
                    break;







                case 'WXSMBDW':
                    $parts = str_split($code);
                    $level = array();
                    $combines = self::C($parts, 3);
                    foreach ($combines as $c) {
                        if (strpos($prize_code, $c{0}) !== false && strpos($prize_code, $c{1}) !== false && strpos($prize_code, $c{2}) !== false) {
                            $level[] = 1;
                        }
                    }
                    break;

                case 'SXDW':    //低频3D特有 三星定位 0123456789,0123456789,0123456789 或,2,3都是合法的
                    $prizeParts = str_split($prize_code);
                    $level = array();
                    $parts = explode(',', $code);
                    if (strpos($parts[0], $prizeParts[0]) !== false) {
                        $level[] = 1;
                    }
                    if (strpos($parts[1], $prizeParts[1]) !== false) {
                        $level[] = 2;
                    }
                    if (strpos($parts[2], $prizeParts[2]) !== false) {
                        $level[] = 3;
                    }
                    break;
                //不定位
                case 'YMBDW':   //三星一码不定位 一注仅限一个胆，如1，以便简化 只能是单式
                    $back3Parts = str_split($back3);
                    if (in_array($code, $back3Parts)) {
                        $level = 1;
                    }
                    break;
                case 'EMBDW':   //三星二码不定位 一注仅限一个，如1,2，以便简化 只能是单式
                    $tmp1 = str_split($back3);
                    sort($tmp1);
                    $tmp2 = implode('', $tmp1);
                    $code1 = explode(',', $code);
                    sort($code1);
                    $code2 = implode('', $code1);
                    if (substr($tmp2, 0, 2) == $code2 || substr($tmp2, 1, 2) == $code2 || (substr($tmp2, 0, 1) . substr($tmp2, 2, 1) == $code2)) {
                        $level = 1;
                    }
                    break;
                case 'QSYMBDW':   //低频P3P5特有 前三一码不定位 一注仅限一个胆，如1，以便简化 只能是单式
                    $fore3Parts = str_split($fore3);
                    if (in_array($code, $fore3Parts)) {
                        $level = 1;
                    }
                    break;
                case 'QSEMBDW':   //低频P3P5特有 前三二码不定位 一注仅限一个，如1,2，以便简化 只能是单式
                    $tmp1 = str_split($fore3);
                    sort($tmp1);
                    $tmp2 = implode('', $tmp1);
                    $code1 = explode(',', $code);
                    sort($code1);
                    $code2 = implode('', $code1);
                    if (substr($tmp2, 0, 2) == $code2 || substr($tmp2, 1, 2) == $code2 || (substr($tmp2, 0, 1) . substr($tmp2, 2, 1) == $code2)) {
                        $level = 1;
                    }
                    break;
                //大小单双
                case 'SXDXDS':    //三星大小单双 只能是单式 projects存的时候就应该是1,3,4样式
                    $tmp = str_replace(',', '', $code);
                    if (in_array($tmp, $helpData['SXDXDS'])) {
                        $level = 1;
                    }
                    break;
                case 'EXDXDS':    //二星大小单双
                    $tmp = str_replace(',', '', $code);
                    if (in_array($tmp, $helpData['EXDXDS'])) {
                        $level = 1;
                    }
                    break;
                case 'QEDXDS':    //低频3D P3P5特有 前二大小单双
                    $tmp = str_replace(',', '', $code);
                    if (in_array($tmp, $helpData['QEDXDS'])) {
                        $level = 1;
                    }
                    break;
                //和值
                case 'SXHZ':    //三星和值
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['SXHZ']) {
                            $level = 1;
                        }
                    }
                    break;


                case 'SXHZWS':    //三星和值尾数
                    $parts = str_split($code);
                    $last = strlen($helpData['SXHZ']) - 1;
                    $tmpws = substr($helpData['SXHZ'], $last);
                    foreach ($parts as $v) {
                        if ($v == $tmpws) {
                            $level = 1;
                            break;
                        }
                    }
                    break;

                case 'QSHZWS':    //前三和值尾数
                    $parts = str_split($code);
                    $last = strlen($helpData['QSHZ']) - 1;
                    $tmpws = substr($helpData['QSHZ'], $last);
                    foreach ($parts as $v) {
                        if ($v == $tmpws) {
                            $level = 1;
                            break;
                        }
                    }
                    break;

                case 'ZSHZWS':    //中三和值尾数
                    $parts = str_split($code);
                    $last = strlen($helpData['ZSHZ']) - 1;
                    $tmpws = substr($helpData['ZSHZ'], $last);
                    foreach ($parts as $v) {
                        if ($v == $tmpws) {
                            $level = 1;
                            break;
                        }
                    }
                    break;


                case 'SXTSH'://三星特殊号码那
                    $tmp1 = str_split($back3);
                    $noSpe = true;

                    if ($tmp1[0] == $tmp1[1] && $tmp1[1] == $tmp1[2]) {
                        $noSpe = false;
                        if (strpos($code, '豹子') !== false) {
                            $level = 1;
                            break;
                        }
                    } else if ($tmp1[0] == $tmp1[1] || $tmp1[1] == $tmp1[2] || $tmp1[0] == $tmp1[2]) {
                        $noSpe = false;
                        if (strpos($code, '对子') !== false) {
                            $level = 3;
                            break;
                        }
                    }

                    sort($tmp1);

                    if ((implode(',', $tmp1) == '0,8,9' || implode(',', $tmp1) == '0,1,9') || ($tmp1[0] == ($tmp1[1] - 1) && $tmp1[1] == ($tmp1[2] - 1))) {
                        $noSpe = false;
                        if (strpos($code, '顺子') !== false) {
                            $level = 2;
                            break;
                        }
                    }

                    if (implode(',', $tmp1) != '0,8,9' && implode(',', $tmp1) != '0,1,9') {
                        if (($tmp1[0] == ($tmp1[1] - 1) && $tmp1[1] != ($tmp1[2] - 1)) || ($tmp1[0] != ($tmp1[1] - 1) && $tmp1[1] == ($tmp1[2] - 1)) || ($tmp1[0] == '0' && $tmp1[2] == '9')) {
                            $noSpe = false;
                            if (strpos($code, '半顺') !== false) {
                                $level = 5;
                                break;
                            }
                        }
                    }



                    if ($noSpe) {
                        if (strpos($code, '杂六') !== false) {
                            $level = 4;
                            break;
                        }
                    }
                    break;

                case 'ZSTSH'://三星特殊号码那
                    $tmp1 = str_split($mid3);
                    $noSpe = true;

                    if ($tmp1[0] == $tmp1[1] && $tmp1[1] == $tmp1[2]) {
                        $noSpe = false;
                        if (strpos($code, '豹子') !== false) {
                            $level = 1;
                            break;
                        }
                    } else if ($tmp1[0] == $tmp1[1] || $tmp1[1] == $tmp1[2] || $tmp1[0] == $tmp1[2]) {
                        $noSpe = false;
                        if (strpos($code, '对子') !== false) {
                            $level = 3;
                            break;
                        }
                    }

                    sort($tmp1);

                    if ((implode(',', $tmp1) == '0,8,9' || implode(',', $tmp1) == '0,1,9') || ($tmp1[0] == ($tmp1[1] - 1) && $tmp1[1] == ($tmp1[2] - 1))) {
                        $noSpe = false;
                        if (strpos($code, '顺子') !== false) {
                            $level = 2;
                            break;
                        }
                    }

                    if (implode(',', $tmp1) != '0,8,9' && implode(',', $tmp1) != '0,1,9') {


                        if (($tmp1[0] == ($tmp1[1] - 1) && $tmp1[1] != ($tmp1[2] - 1)) || ($tmp1[0] != ($tmp1[1] - 1) && $tmp1[1] == ($tmp1[2] - 1)) || ($tmp1[0] == '0' && $tmp1[2] == '9')) {

                            $noSpe = false;
                            if (strpos($code, '半顺') !== false) {
                                $level = 5;
                                break;
                            }
                        }
                    }



                    if ($noSpe) {
                        if (strpos($code, '杂六') !== false) {
                            $level = 4;
                            break;
                        }
                    }
                    break;

                case 'QSTSH'://前三特殊号码那
                    $tmp1 = str_split($fore3);
                    $noSpe = true;
                    if ($tmp1[0] == $tmp1[1] && $tmp1[1] == $tmp1[2]) {
                        $noSpe = false;
                        if (strpos($code, '豹子') !== false) {
                            $level = 1;
                            break;
                        }
                    } else if ($tmp1[0] == $tmp1[1] || $tmp1[1] == $tmp1[2] || $tmp1[0] == $tmp1[2]) {
                        $noSpe = false;
                        if (strpos($code, '对子') !== false) {
                            $level = 3;
                            break;
                        }
                    }

                    sort($tmp1);

                    if ((implode(',', $tmp1) == '0,8,9' || implode(',', $tmp1) == '0,1,9') || ($tmp1[0] == ($tmp1[1] - 1) && $tmp1[1] == ($tmp1[2] - 1))) {
                        $noSpe = false;
                        if (strpos($code, '顺子') !== false) {
                            $level = 2;
                            break;
                        }
                    }

                    if (implode(',', $tmp1) != '0,8,9' && implode(',', $tmp1) != '0,1,9') {

                        if (($tmp1[0] == ($tmp1[1] - 1) && $tmp1[1] != ($tmp1[2] - 1)) || ($tmp1[0] != ($tmp1[1] - 1) && $tmp1[1] == ($tmp1[2] - 1)) || ($tmp1[0] == '0' && $tmp1[2] == '9')) {


                            $noSpe = false;
                            if (strpos($code, '半顺') !== false) {
                                $level = 5;
                                break;
                            }
                        }
                    }



                    if ($noSpe) {
                        if (strpos($code, '杂六') !== false) {
                            $level = 4;
                            break;
                        }
                    }
                    break;

                case 'WXLHH'://龙虎和
                    $parts = str_split($prize_code);

                    if ($parts[0] == $parts[4]) {
                        if (strpos($code, '和') !== false) {
                            $level = 1;
                            break;
                        }
                    } else if ($parts[0] > $parts[4]) {
                        if (strpos($code, '龙') !== false) {
                            $level = 2;
                            break;
                        }
                    } else if ($parts[0] < $parts[4]) {
                        if (strpos($code, '虎') !== false) {
                            $level = 2;
                            break;
                        }
                    }
                    break;


                case 'WXHZDXDS'://五星和值大小单双
                    $parts = str_split($prize_code);
                    $wxhz = $parts[0] + $parts[1] + $parts[2] + $parts[3] + $parts[4];
                    $level = array();
                    if ($wxhz >= 23) {
                        if (strpos($code, '大') !== false) {
                            $level[] = 1;
                        }
                    } else {
                        if (strpos($code, '小') !== false) {
                            $level[] = 1;
                        }
                    }


                    if ($wxhz % 2 == 0) {
                        if (strpos($code, '双') !== false) {
                            $level[] = 1;
                        }
                    } else {
                        if (strpos($code, '单') !== false) {
                            $level[] = 1;
                        }
                    }


                    break;






                case 'EXHZ':    //二星和值
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['EXHZ']) {
                            $level = 1;
                        }
                    }
                    break;
                case 'QSHZ':    //前三和值
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['QSHZ']) {
                            $level = 1;
                        }
                    }
                    break;
                case 'ZSHZ':    //中三和值
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['ZSHZ']) {
                            $level = 1;
                        }
                    }
                    break;
                case 'QEHZ':    //前二和值
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['QEHZ']) {
                            $level = 1;
                        }
                    }
                    break;


                case 'QSZXKD':    //前三跨度
                    $parts = str_split($code);
                    $tmp1 = str_split($fore3);
                    sort($tmp1);
                    $tmp2 = $tmp1[2] - $tmp1[0];
                    foreach ($parts as $v) {
                        if ($v == $tmp2) {
                            $level = 1;
                            break;
                        }
                    }
                    break;
                case 'ZSZXKD':    //中三跨度
                    $parts = str_split($code);
                    $tmp1 = str_split($mid3);
                    sort($tmp1);
                    $tmp2 = $tmp1[2] - $tmp1[0];
                    foreach ($parts as $v) {
                        if ($v == $tmp2) {
                            $level = 1;
                            break;
                        }
                    }
                    break;
                case 'QEZXKD':    //前2跨度
                    $parts = str_split($code);
                    $tmp1 = str_split($fore2);
                    sort($tmp1);
                    $tmp2 = $tmp1[1] - $tmp1[0];
                    foreach ($parts as $v) {
                        if ($v == $tmp2) {
                            $level = 1;
                            break;
                        }
                    }
                    break;
                case 'SXZXKD':    //三星跨度

                    $parts = str_split($code);
                    $tmp1 = str_split($back3);
                    sort($tmp1);
                    $tmp2 = $tmp1[2] - $tmp1[0];
                    foreach ($parts as $v) {
                        if ($v == $tmp2) {
                            $level = 1;
                            break;
                        }
                    }
                    break;
                case 'EXZXKD':    //2星跨度
                    $parts = str_split($code);
                    $tmp1 = str_split($back2);
                    sort($tmp1);
                    $tmp2 = $tmp1[1] - $tmp1[0];
                    foreach ($parts as $v) {
                        if ($v == $tmp2) {
                            $level = 1;
                            break;
                        }
                    }
                    break;



                case 'SXZXHZ':  //低频3D特有 三星组选和值 豹子号除外，组三态按组三派奖，组六态按组六派奖
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['SXHZ']) {
                            if ($helpData['SX'] == '组六') {
                                $level = 2;
                            } elseif ($helpData['SX'] == '组三') {
                                $level = 1;
                            }
                        }
                    }
                    break;
                case 'QSZXHZ':  //低频P3P5特有 P3即前三组选和值 豹子号除外，组三态按组三派奖，组六态按组六派奖
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $helpData['QSHZ']) {
                            if ($helpData['QS'] == '组六') {
                                $level = 2;
                            } elseif ($helpData['QS'] == '组三') {
                                $level = 1;
                            }
                        }
                    }
                    break;

                //四星
                case 'SIXZX':    //四星直选
                    //先排列展开所选号码 再和后四号码进行比较 有一个相同为中奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    if (in_array($back4, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'QSIZX':    //前四直选
                    //先排列展开所选号码 再和后四号码进行比较 有一个相同为中奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    if (in_array($fore4, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'WXZUX120':    //组选120
                    $parts = str_split($prize_code);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 5) { //首先要是组选120
                        if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false && strpos($code, $tmp[2]) !== false && strpos($code, $tmp[3]) !== false && strpos($code, $tmp[4]) !== false) {
                            $level = 1;
                        }
                    }
                    break;

                case 'WXZUX60':    //组选60
                    $parts = str_split($prize_code);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 4) { //首先要是组选60
                        $codeExp = explode(',', $code);
                        $codeP1 = str_split($codeExp[0]); //二同号 数组
                        $code2 = $codeExp[1]; //三不同号 字符串
                        foreach ($codeP1 as $num1) {
                            if (substr_count($prize_code, $num1) == 2) {//找到2同号
                                $tmp = str_replace($num1, '', $prize_code); //剩下3个不同号
                                if (strpos($code2, $tmp{0}) !== false && strpos($code2, $tmp{1}) !== false && strpos($code2, $tmp{2}) !== false) {
                                    $level = 1;
                                    break 2;
                                }
                            }
                        }
                    }
                    break;

                case 'WXZUX30':    //组选30
                    $parts = str_split($prize_code);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 3) { //首先要是组选30
                        $tmp = implode('', $tmp);
                        $codeExp = explode(',', $code);
                        $code1 = $codeExp[0]; //二同号 数组
                        $codeP2 = str_split($codeExp[1]); //1不同号 字符串
                        foreach ($codeP2 as $num2) {
                            if (substr_count($prize_code, $num2) == 1) {//找到1不同号
                                $tmp1 = str_replace($num2, '', $tmp); //剩下2个同号
                                if (strpos($code1, $tmp1{0}) !== false && strpos($code1, $tmp1{1}) !== false) {
                                    $level = 1;
                                    break 2;
                                }
                            }
                        }
                    }

                    break;

                case 'WXZUX20':    //组选30
                    $parts = str_split($prize_code);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 3) { //首先要是组选20
                        $codeExp = explode(',', $code);
                        $codeP1 = str_split($codeExp[0]); //二同号 数组
                        $code2 = $codeExp[1]; //1不同号 字符串
                        foreach ($codeP1 as $num1) {
                            if (substr_count($prize_code, $num1) == 3) {//找到3同号
                                $tmp = str_replace($num1, '', $prize_code); //剩下2 bu同号
                                if (strpos($code2, $tmp{0}) !== false && strpos($code2, $tmp{1}) !== false) {
                                    $level = 1;
                                    break 2;
                                }
                            }
                        }
                    }

                    break;

                case 'WXZUX10':    //组选30
                    $parts = str_split($prize_code);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 2) { //首先要是组选20
                        $codeExp = explode(',', $code);
                        $codeP1 = str_split($codeExp[0]); //二同号 数组
                        $codeP2 = str_split($codeExp[1]); //1不同号 字符串
                        foreach ($codeP1 as $num1) {
                            if (substr_count($prize_code, $num1) == 3) {//找到3同号
                                foreach ($codeP2 as $num2) {
                                    if (substr_count($prize_code, $num2) == 2) {//找到2同号
                                        $level = 1;
                                        break 2;
                                    }
                                }
                            }
                        }
                    }

                    break;

                case 'WXZUX5':    //组选30
                    $parts = str_split($prize_code);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 2) { //首先要是组选20
                        $codeExp = explode(',', $code);
                        $codeP1 = str_split($codeExp[0]); //二同号 数组
                        $codeP2 = str_split($codeExp[1]); //1不同号 字符串
                        foreach ($codeP1 as $num1) {
                            if (substr_count($prize_code, $num1) == 4) {//找到3同号
                                foreach ($codeP2 as $num2) {
                                    if (substr_count($prize_code, $num2) == 1) {//找到2同号
                                        $level = 1;
                                        break 2;
                                    }
                                }
                            }
                        }
                    }

                    break;

                case 'SXZUX24':
                    $parts = str_split($back4);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 4) { //首先要是组选20
                        if (strpos($code, $parts[0]) !== false && strpos($code, $parts[1]) !== false && strpos($code, $parts[2]) !== false && strpos($code, $parts[3]) !== false) {
                            $level = 1;
                        }
                    }

                    break;

                case 'SXZUX12':
                    $parts = str_split($back4);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 3) { //首先要是组选12
                        $codeExp = explode(',', $code);
                        $codeP1 = str_split($codeExp[0]); //二同号 数组
                        $code2 = $codeExp[1]; //2不同号 字符串
                        foreach ($codeP1 as $num1) {
                            if (substr_count($back4, $num1) == 2) {//找到3同号
                                $tmp = str_replace($num1, '', $back4); //剩下2个不同号
                                if (strpos($code2, $tmp{0}) !== false && strpos($code2, $tmp{1}) !== false) {
                                    $level = 1;
                                    break;
                                }
                            }
                        }
                    }

                    break;


                case 'SXZUX6':
                    $parts = str_split($back4);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 2) { //首先要是组选12
                        foreach ($parts as $num1) {
                            if (substr_count($back4, $num1) == 2) {//找到2同号
                                foreach ($parts as $num2) {
                                    if ($num1 == $num2) {
                                        continue;
                                    }
                                    if (substr_count($back4, $num2) == 2) {//找到2同号
                                        $level = 1;
                                        break 2;
                                    }
                                }
                            }
                        }
                    }

                    break;
                case 'SXZUX4':

                    $parts = str_split($back4);
                    $tmp = array_unique($parts);
                    if (count($tmp) == 2) { //首先要是组选12
                        $codeExp = explode(',', $code);
                        $codeP1 = str_split($codeExp[0]); //3同号 数组
                        $code2 = $codeExp[1]; //1不同号 字符串
                        foreach ($codeP1 as $num1) {
                            if (substr_count($back4, $num1) == 3) {//找到3同号
                                $tmp = str_replace($num1, '', $back4); //剩下1个不同号
                                if (strpos($code2, $tmp{0}) !== false) {
                                    $level = 1;
                                    break;
                                }
                            }
                        }
                    }

                    break;

                case 'WXYFFS':
                    $parts = str_split($code);
                    foreach ($parts as $v) {
                        if ($his = substr_count($prize_code, $v)) {
                            if (!$level) {
                                $level = array();
                            }
                            for ($index = 0; $index < $his; $index++) {
                                $level[] = 1;
                                break;
                            }
                        }
                    }

                    break;

                case 'WXHSCS':
                    $parts = str_split($code);
                    foreach ($parts as $v) {
                        $his = substr_count($prize_code, $v);
                        if ($his > 1) {
                            if (!$level) {
                                $level = array();
                            }
                            if ($his == 2 || $his == 3) {
                                $level[] = 1;
                            }
                            if ($his > 3) {
                                $level[] = 1;
                                //$level[] = 1;
                            }
                        }
                    }

                    break;

                case 'WXSXBX':
                    $parts = str_split($code);
                    foreach ($parts as $v) {
                        $his = substr_count($prize_code, $v);
                        if ($his >= 3) {
                            $level = 1;
                            break; //只有一个
                        }
                    }

                    break;

                case 'WXSJFC':
                    $parts = str_split($code);
                    foreach ($parts as $v) {
                        $his = substr_count($prize_code, $v);
                        if ($his >= 4) {
                            $level = 1;
                            break; //只有一个
                        }
                    }

                    break;

                case 'RSZU6'://任选三组六
                    $parts = str_split($prize_code);
                    $codesSplit = explode('_', $code);
                    if (count($codesSplit) != 2) {
                        return false;
                    }

                    $pos = self::getRxPos(3, $codesSplit[0]);

                    $level = array();
                    foreach ($pos as $pItem) {
                        $tmp = array_values(array_unique(array($parts[$pItem{0}], $parts[$pItem{1}], $parts[$pItem{2}])));
                        if (count($tmp) == 3) { //首先要是组六态
                            if (strpos($code, $tmp[0]) !== false && strpos($code, $tmp[1]) !== false && strpos($code, $tmp[2]) !== false) {
                                $level[] = 1;
                            }
                        }
                    }
                    break;

                case 'REZXHZ':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(2, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $parts = explode('_', $codesSplit[1]);
                        $hz = $prizeCodes[$pItem[0]] + $prizeCodes[$pItem[1]];
                        foreach ($parts as $v) {
                            if ($v == $hz) {
                                $level[] = 1;
                                break;
                            }
                        }
                    }
                    break;


                case 'REZUX':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(2, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $back2Parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]]);
                        $tmp = array_values(array_unique($back2Parts));
                        if (count($tmp) == 2) { //首先要是不同号码才可能中奖
                            if (strpos($codesSplit[1], $tmp[0]) !== false && strpos($codesSplit[1], $tmp[1]) !== false) {
                                $level[] = 1;
                            }
                        }
                    }
                    break;
                case 'REZUXHZ':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(2, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $back2Parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]]);
                        $tmp = array_unique($back2Parts);
                        if (count($tmp) != 2) { //首先要是不同号码才可能中奖
                            continue;
                        }
                        $parts = explode('_', $codesSplit[1]);
                        $hz = $prizeCodes[$pItem[0]] + $prizeCodes[$pItem[1]];
                        foreach ($parts as $v) {
                            if ($v == $hz) {
                                $level[] = 1;
                                break;
                            }
                        }
                    }
                    break;
                case 'RSZXHZ':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(3, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $parts = explode('_', $codesSplit[1]);
                        $hz = $prizeCodes[$pItem[0]] + $prizeCodes[$pItem[1]] + $prizeCodes[$pItem[2]];
                        foreach ($parts as $v) {
                            if ($v == $hz) {
                                $level[] = 1;
                                break;
                            }
                        }
                    }
                    break;
                case 'RSZU3':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(3, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $back3Parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]], $prizeCodes[$pItem[2]]);
                        //如果不是组三态显然没中奖
                        $tmp = array_values(array_unique($back3Parts));
                        if (count($tmp) == 2) {
                            if (strpos($codesSplit[1], $tmp[0]) !== false && strpos($codesSplit[1], $tmp[1]) !== false) {
                                $level[] = 1;
                            }
                        }
                    }
                    break;
                case 'RSZUXHZ':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(3, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $back3Parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]], $prizeCodes[$pItem[2]]);
                        $tmp = array_values(array_unique($back3Parts));
                        //豹子不算
                        if (count($tmp) == 1) {
                            continue;
                        }
                        $parts = explode('_', $codesSplit[1]);
                        $hz = $prizeCodes[$pItem[0]] + $prizeCodes[$pItem[1]] + $prizeCodes[$pItem[2]];
                        foreach ($parts as $v) {
                            if ($v == $hz) {
                                if (count($tmp) == 2) {
                                    $level[] = 1;
                                } else if (count($tmp) == 3) {
                                    $level[] = 2;
                                }
                                break;
                            }
                        }
                    }
                    break;
                case 'RSHHZX':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(3, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $back3Parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]], $prizeCodes[$pItem[2]]);
                        $tmp = array_values(array_unique($back3Parts)); //522 122 121 211 112
                        $codeParts = explode(',', $codesSplit[1]);   //252
                        $codeTmp = array_values(array_unique($codeParts));  // 12
                        sort($back3Parts);
                        sort($codeParts);
                        //按开奖号码形态分别判断
                        if (count($tmp) == 2 && count($codeTmp) == 2) {    //如果不是组三态显然没中奖
                            if ($codeParts[0] === $back3Parts[0] && $codeParts[1] === $back3Parts[1] && $codeParts[2] === $back3Parts[2]) {
                                $level[] = 1;
                            }
                        } elseif (count($tmp) == 3 && count($codeTmp) == 3) {
                            if ($codeParts[0] === $back3Parts[0] && $codeParts[1] === $back3Parts[1] && $codeParts[2] === $back3Parts[2]) {
                                $level[] = 2;
                            }
                        }
                    }
                    break;
                case 'R4ZX':
                    if (!preg_match('`^(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-)$`Ui', $code)) {

                        $prizeCodes = str_split($prize_code);
                        $codesSplit = explode('_', $code, 2);
                        $pos = self::getRxPos(4, $codesSplit[0]);
                        $level = array();
                        foreach ($pos as $pItem) {
                            $parts = explode(',', $codesSplit[1]);
                            if ($prizeCodes[$pItem[0]] == $parts[0] && $prizeCodes[$pItem[1]] == $parts[1] && $prizeCodes[$pItem[2]] == $parts[2] && $prizeCodes[$pItem[3]] == $parts[3]) {
                                $level[] = 1;
                            }
                        }
                    } else {

                        $codeParts = explode(',', $code);
                        $level = array();

                        $selected = 0;
                        for ($i = 0; $i < 5; $i++) {
                            if ($codeParts[$i] != '-') {
                                if (strpos($codeParts[$i], $prize_code{$i}) !== false) {
                                    $selected++;
                                }
                            }
                        }
                        switch ($selected) {
                            case 4: //C(3,3)
                                $level = array(1);
                                break;
                            case 5: //C(4,3)
                                $level = array(1, 1, 1, 1, 1);
                                break;
                            default:
                                break;
                        }
                    }





                    break;
                case 'R4ZUX24':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(4, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]], $prizeCodes[$pItem[2]], $prizeCodes[$pItem[3]]);
                        $tmp = array_values(array_unique($parts));
                        if (count($tmp) == 4) { //首先要是组选20
                            if (strpos($codesSplit[1], $parts[0]) !== false && strpos($codesSplit[1], $parts[1]) !== false && strpos($codesSplit[1], $parts[2]) !== false && strpos($codesSplit[1], $parts[3]) !== false) {
                                $level[] = 1;
                            }
                        }
                    }
                    break;
                case 'R4ZUX12':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(4, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {

                        $parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]], $prizeCodes[$pItem[2]], $prizeCodes[$pItem[3]]);
                        $back4 = implode('', $parts);
                        $tmp = array_values(array_unique($parts));
                        if (count($tmp) == 3) { //首先要是组选12
                            $codeExp = explode(',', $codesSplit[1]);
                            $codeP1 = str_split($codeExp[0]); //二同号 数组
                            $code2 = $codeExp[1]; //2不同号 字符串
                            foreach ($codeP1 as $num1) {
                                if (substr_count($back4, $num1) == 2) {//找到3同号
                                    $tmp = str_replace($num1, '', $back4); //剩下2个不同号
                                    if (strpos($code2, $tmp{0}) !== false && strpos($code2, $tmp{1}) !== false) {
                                        $level[] = 1;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 'R4ZUX6':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(4, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {

                        $parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]], $prizeCodes[$pItem[2]], $prizeCodes[$pItem[3]]);
                        $back4 = implode('', $parts);
                        $tmp = array_unique($parts);
                        if (count($tmp) == 2) { //首先要是组选12
                            foreach ($parts as $num1) {
                                if (substr_count($back4, $num1) == 2) {//找到2同号
                                    foreach ($parts as $num2) {
                                        if ($num1 == $num2) {
                                            continue;
                                        }
                                        if (substr_count($back4, $num2) == 2) {//找到2同号
                                            $level[] = 1;
                                            break 2;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 'R4ZUX4':
                    $prizeCodes = str_split($prize_code);
                    $codesSplit = explode('_', $code, 2);
                    $pos = self::getRxPos(4, $codesSplit[0]);
                    $level = array();
                    foreach ($pos as $pItem) {
                        $parts = array($prizeCodes[$pItem[0]], $prizeCodes[$pItem[1]], $prizeCodes[$pItem[2]], $prizeCodes[$pItem[3]]);
                        $back4 = implode('', $parts);
                        $tmp = array_unique($parts);

                        if (count($tmp) == 2) { //首先要是组选12
                            $codeExp = explode(',', $codesSplit[1]);
                            $codeP1 = str_split($codeExp[0]); //3同号 数组
                            $code2 = $codeExp[1]; //1不同号 字符串
                            foreach ($codeP1 as $num1) {
                                if (substr_count($back4, $num1) == 3) {//找到3同号
                                    $tmp = str_replace($num1, '', $back4); //剩下1个不同号
                                    if (strpos($code2, $tmp{0}) !== false) {
                                        $level[] = 1;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    break;
                //五星
                case 'WXZX':    //五星直选
                    //先排列展开所选号码 再和$prize_code进行比较 有一个相同为中奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    if (in_array($prize_code, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'WXLX':    //五星连选 0123456789,0123456789,0123456789,0123456789,0123456789 全包101110注
                    //兼中兼得(即可同时中一二三四等奖)万千百十个 百十个 十个 个 分别对应1234等奖
                    $parts = explode(',', $code);
                    $expandNums = self::expand($parts);
                    $level = array();
                    if (in_array($prize_code, $expandNums)) {
                        $level[] = 1;
                    }

                    $parts = array_slice($parts, 2);    //再判断是否中三星（二等奖）
                    $expandNums = self::expand($parts);
                    if (in_array($back3, $expandNums)) {
                        $level[] = 2;
                    }

                    array_shift($parts);    //再判断是否中二星（三等奖）
                    $expandNums = self::expand($parts);
                    if (in_array($back2, $expandNums)) {
                        $level[] = 3;
                    }

                    $tmp = array_pop($parts);   //再判断是否中一星（四等奖）
                    if (strpos($tmp, $back1) !== false) {
                        $level[] = 4;
                    }
                    break;
                case 'REZX':     //任二直选	-,-,6,4,7
                    //20150520-644	92464	1020.0000已中奖			01234,12345,23456,34567,45678
                    $codeParts = explode(',', $code);
                    $level = array();
                    //方法二
                    $selected = 0;
                    for ($i = 0; $i < 5; $i++) {
                        if ($codeParts[$i] != '-') {
                            if (strpos($codeParts[$i], $prize_code[$i]) !== false) {
                                $selected++;
                            }
                        }
                    }

                    switch ($selected) {
                        case 2: //C(2,2)
                            $level = array(1);
                            break;
                        case 3: //C(3,2)
                            $level = array(1, 1, 1);
                            break;
                        case 4: //C(4,2)
                            $level = array(1, 1, 1, 1, 1, 1);
                            break;
                        case 5: //C(5,2)
                            $level = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
                            break;
                        default:
                            ;
                            break;
                    }

//                	//方法一 效率低弃用
//                    $n = 4; //5!
//                    for ($i = 0; $i < $n; $i++) {
//                    	if ($codeParts[$i] != '-') {
//                    		for ($j = $i; $j < $n; $j++) {
//                    			if ($codeParts[$j+1] != '-') {
//                    				//当前位置的中奖号 最多10个
//                    				$curPosPrizeCode = $prize_code[$i].$prize_code[$j+1];
//                    				//A*B 严格按位置展开的投注
//                    				$extendNums = self::expandByOrder($codeParts[$i], $codeParts[$j+1]);
//                    				if (in_array($curPosPrizeCode, $extendNums)) {
//                    					$level[] = 1;
//                    				}
//                    			}
//                    		}
//                    	}
//                    }
                    break;
                case 'RSZX':     //任三直选	-,-,6,4,7
                    $codeParts = explode(',', $code);
                    $level = array();

                    $selected = 0;
                    for ($i = 0; $i < 5; $i++) {
                        if ($codeParts[$i] != '-') {
                            if (strpos($codeParts[$i], $prize_code[$i]) !== false) {
                                $selected++;
                            }
                        }
                    }

                    switch ($selected) {
                        case 3: //C(3,3)
                            $level = array(1);
                            break;
                        case 4: //C(4,3)
                            $level = array(1, 1, 1, 1);
                            break;
                        case 5: //C(5,3)
                            $level = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
                            break;
                        default:
                            ;
                            break;
                    }
                    break;
                //
                // 中奖判断SD11Y   SD11Y   SD11Y   SD11Y   SD11Y   SD11Y   SD11Y   SD11Y
                //
                //前三
                case 'SDQSZX':  //前三直选 01_02_03_04,02_03,01_05
                    $expandNums = self::expandLotto(explode(',', $code));
                    if (in_array($sdfore3, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'SDQSZUX':     //前三组选 01_02_03_04 4注 只需逐个判断中奖号码都在里面即可
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $sdfore3);
                    $count = 0;
                    foreach ($prizeParts as $v) {
                        if (in_array($v, $codeParts)) {
                            $count++;
                        }
                    }
                    if ($count == 3) {
                        $level = 1;
                    }
                    break;

                //前二
                case 'SDQEZX':     //前二直选
                    $expandNums = self::expandLotto(explode(',', $code));
                    if (in_array($sdfore2, $expandNums)) {
                        $level = 1;
                    }
                    break;
                case 'SDQEZUX':     //前二组选
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $sdfore2);
                    $count = 0;
                    foreach ($prizeParts as $v) {
                        if (in_array($v, $codeParts)) {
                            $count++;
                        }
                    }
                    if ($count == 2) {
                        $level = 1;
                    }
                    break;

                //任选 中奖判断
                case 'SDRX1':     //任选一 01_02_03 复式 可以中多注，一单最多可中5注
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    $count = 0;
                    foreach ($codeParts as $v) {
                        if (in_array($v, $prizeParts)) {
                            $count++;   //$count表示中了几注
                        }
                    }

                    if ($count > 0) {
                        $level = array();
                        for ($i = $count; $i > 0; $i--) {
                            $level[] = 1;
                        }
                    }
                    break;
                case 'SDRX2':     //任选2 复式 需要按Cn_2展开，再逐一判断是否中奖，因为中奖是5个里面任意2个相同，所以一单最多中C5_2=10注
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    $expandNums = self::C($codeParts, 2, ' ');
                    $count = 0;
                    foreach ($expandNums as $v) {
                        $tmp = explode(' ', $v);
                        if (in_array($tmp[0], $prizeParts) && in_array($tmp[1], $prizeParts)) {
                            $count++;
                        }
                    }

                    if ($count > 0) {
                        $level = array();
                        for ($i = $count; $i > 0; $i--) {
                            $level[] = 1;
                        }
                    }
                    break;
                case 'SDRX3':     //任选3 复式 需要按Cn_3展开，再逐一判断是否中奖，因为中奖是5个里面任意2个相同，所以一单最多中C5_3=10注
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    $expandNums = self::C($codeParts, 3, ' ');
                    $count = 0;
                    foreach ($expandNums as $v) {
                        $tmp = explode(' ', $v);
                        if (in_array($tmp[0], $prizeParts) && in_array($tmp[1], $prizeParts) && in_array($tmp[2], $prizeParts)) {
                            $count++;
                        }
                    }

                    if ($count > 0) {
                        $level = array();
                        for ($i = $count; $i > 0; $i--) {
                            $level[] = 1;
                        }
                    }
                    break;
                case 'SDRX4':     //任选4
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    $expandNums = self::C($codeParts, 4, ' ');
                    $count = 0;
                    foreach ($expandNums as $v) {
                        $tmp = explode(' ', $v);
                        if (in_array($tmp[0], $prizeParts) && in_array($tmp[1], $prizeParts) && in_array($tmp[2], $prizeParts) && in_array($tmp[3], $prizeParts)) {
                            $count++;
                        }
                    }

                    if ($count > 0) {
                        $level = array();
                        for ($i = $count; $i > 0; $i--) {
                            $level[] = 1;
                        }
                    }
                    break;
                case 'SDRX5':     //任选5 只可能中一个奖
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    $expandNums = self::C($codeParts, 5, ' ');
                    foreach ($expandNums as $v) {
                        $tmp = explode(' ', $v);
                        if (in_array($tmp[0], $prizeParts) && in_array($tmp[1], $prizeParts) && in_array($tmp[2], $prizeParts) && in_array($tmp[3], $prizeParts) && in_array($tmp[4], $prizeParts)) {
                            $level = 1;
                        }
                    }
                    break;
                case 'SDRX6':     //任选6 复式 需先得到Cn_6，再得到C6_5，再和任选5一样的判断 也可按Cn-5_1算中奖注数
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    $expandNums = self::C($codeParts, 6, ' ');
                    $expandNums2 = array();
                    foreach ($expandNums as $v) {
                        $tmp = self::C(explode(' ', $v), 5, ' ');
                        foreach ($tmp as $vv) {
                            $expandNums2[] = $vv;
                        }
                    }

                    $level = array();
                    foreach ($expandNums2 as $v) {
                        $tmp = explode(' ', $v);
                        if (in_array($tmp[0], $prizeParts) && in_array($tmp[1], $prizeParts) && in_array($tmp[2], $prizeParts) && in_array($tmp[3], $prizeParts) && in_array($tmp[4], $prizeParts)) {
                            $level[] = 1;
                        }
                    }
                    break;
                case 'SDRX7':     //任选7 复式 需先得到Cn_7，再得到C7_5，再和任选5一样的判断 也可按Cn-5_2算中奖注数
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    $expandNums = self::C($codeParts, 7, ' ');
                    $expandNums2 = array();
                    foreach ($expandNums as $v) {
                        $tmp = self::C(explode(' ', $v), 5, ' ');
                        foreach ($tmp as $vv) {
                            $expandNums2[] = $vv;
                        }
                    }

                    $level = array();
                    foreach ($expandNums2 as $v) {
                        $tmp = explode(' ', $v);
                        if (in_array($tmp[0], $prizeParts) && in_array($tmp[1], $prizeParts) && in_array($tmp[2], $prizeParts) && in_array($tmp[3], $prizeParts) && in_array($tmp[4], $prizeParts)) {
                            $level[] = 1;
                        }
                    }
                    break;
                case 'SDRX8':     //任选8 复式 需先得到Cn_8，再得到C8_5，再和任选5一样的判断 也可按Cn-5_3算中奖注数
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    $expandNums = self::C($codeParts, 8, ' ');
                    $expandNums2 = array();
                    foreach ($expandNums as $v) {
                        $tmp = self::C(explode(' ', $v), 5, ' ');
                        foreach ($tmp as $vv) {
                            $expandNums2[] = $vv;
                        }
                    }

                    $level = array();
                    foreach ($expandNums2 as $v) {
                        $tmp = explode(' ', $v);
                        if (in_array($tmp[0], $prizeParts) && in_array($tmp[1], $prizeParts) && in_array($tmp[2], $prizeParts) && in_array($tmp[3], $prizeParts) && in_array($tmp[4], $prizeParts)) {
                            $level[] = 1;
                        }
                    }
                    break;

                //前3不定位胆 判断
                case 'SDQSBDW':     //前3不定位胆
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $sdfore3);
                    $count = 0;
                    foreach ($codeParts as $v) {
                        if (in_array($v, $prizeParts)) {
                            $count++;
                        }
                    }

                    if ($count > 0) {
                        $level = array();
                        for ($i = $count; $i > 0; $i--) {
                            $level[] = 1;
                        }
                    }
                    break;
                //前3定位胆 判断
                case 'SDQSDWD':     //前3定位胆 01_02_03,04_05,06为一单 也可以只买一位，如01_02_03,,表示只买个位胆，没买的位留空
                    $codeParts = explode(',', $code);
                    $prizeParts = explode(' ', $sdfore3);
                    $count = 0;
                    foreach ($codeParts as $k => $v) {
                        if ($v != '') {
                            if (in_array($prizeParts[$k], explode('_', $v))) {
                                $count++;
                            }
                        }
                    }

                    if ($count > 0) {
                        $level = array();
                        for ($i = $count; $i > 0; $i--) {
                            $level[] = 1;
                        }
                    }
                    break;

                //定单双
                case 'SDDDS':     //0单5双:750.0000元 (1注) 5单0双:125.0000元 (6注)1单4双:25.0000元 (30注)4单1双:10.0000元 (75注)2单3双:5.0000元 (150注)3单2双:3.7000元 (200注)
                    //projects表中用012345表示0~5单(5-0~5)双 复式 只可能中一个奖
                    //$parts = str_split($code);
                    //改动: projects表中拟用中文直接表示注单
                    $prizeParts = explode(' ', $prize_code);
                    $oddNum = 0;    //记录有几个单数
                    foreach ($prizeParts as $v) {
                        if (intval($v) % 2 == 1) {
                            $oddNum++;
                        }
                    }
                    if (intval($code) == $oddNum) {
                        switch ($oddNum) {
                            case '0':   //0单5双 一等奖750元
                                $level = 1;
                                break;
                            case '1':   //1单4双 三等奖25元
                                $level = 3;
                                break;
                            case '2':   //2单3双 五等奖5元
                                $level = 5;
                                break;
                            case '3':   //3单2双 六等奖3.7元
                                $level = 6;
                                break;
                            case '4':   //4单1双 四等奖10元
                                $level = 4;
                                break;
                            case '5':   //5单0双 二等奖125元
                                $level = 2;
                                break;
                        }
                    }
                    break;
                //猜中位
                case 'SDCZW':     //03_04_05_06_07_08_09 全买 复式 只可能中一个奖
                    $codeParts = explode('_', $code);
                    $prizeParts = explode(' ', $prize_code);
                    sort($prizeParts);
                    if (in_array($prizeParts[2], $codeParts)) {
                        switch ($prizeParts[2]) {
                            case '03':  //一等奖27元
                            case '09':
                                $level = 1;
                                break;
                            case '04':  //二等奖12元
                            case '08':
                                $level = 2;
                                break;
                            case '05':  //三等奖8.4元
                            case '07':
                                $level = 3;
                                break;
                            case '06':  //四等奖7.5元
                                $level = 4;
                                break;
                        }
                    }
                    break;


                //江苏快三
                case 'JSETDX':  //二同单选 2个号区 22_33,14 开133，335
                    $parts = explode(',', $code);
                    $prizeParts = str_split($prize_code);
                    //如果不是组三态显然没中奖
                    $tmp = array_values(array_unique($prizeParts));
                    if (count($tmp) == 2) {
                        $tmpFlag0 = 0;
                        foreach (explode('_', $parts[0]) as $v) {
                            if (strpos($prize_code, $v) !== false) {
                                $tmpFlag0++;
                                break;
                            }
                        }
                        foreach (str_split($parts[1]) as $v) {
                            if (strpos($prize_code, $v) !== false) {
                                $tmpFlag0++;
                                break;
                            }
                        }
                        if ($tmpFlag0 == 2) {
                            $level = 1;
                        }
                    }
                    break;
                case 'JSETFX':  //二同复选 1个号区 11_22_33
                    $parts = explode('_', $code);
                    $prizeParts = str_split($prize_code);
                    //如果不是组三态显然没中奖
                    $tmp = array_values(array_unique($prizeParts));
                    if (count($tmp) == 2) {
                        $tmpFlag0 = 0;
                        foreach ($parts as $v) {
                            if (strpos($prize_code, $v) !== false) {
                                $tmpFlag0 = 1;
                                break;
                            }
                        }
                        if ($tmpFlag0 == 1) {
                            $level = 1;
                        }
                    }
                    break;
                case 'JSHZ':   //快三和值
                    $parts = explode('_', $code);
                    $prizeParts = str_split($prize_code);
                    $hz = array_sum($prizeParts);
                    foreach ($parts as $v) {
                        if ($v == $hz) {
                            switch ($hz) {
                                case 3:  //一等奖302.4
                                case 18:
                                    $level = 1;
                                    break;
                                case 4:  //二等奖100.8
                                case 17:
                                    $level = 2;
                                    break;
                                case 5:  //三等奖50.4
                                case 16:
                                    $level = 3;
                                    break;
                                case 6:  //四等奖30.24
                                case 15:
                                    $level = 4;
                                    break;
                                case 7:  //五等奖20.16
                                case 14:
                                    $level = 5;
                                    break;
                                case 8:  //六等奖14.4
                                case 13:
                                    $level = 6;
                                    break;
                                case 9:  //七等奖12.096
                                case 12:
                                    $level = 7;
                                    break;
                                case 10:  //八等奖11.2
                                case 11:
                                    $level = 8;
                                    break;
                            }
                        }
                    }
                    break;
                case 'JSEBT':   //二不同号
                    $parts = str_split($code);
                    $prizeParts = str_split($prize_code);
                    $hitTimes = 0;
                    foreach ($parts as $v) {
                        if (in_array($v, $prizeParts)) {
                            $hitTimes++;
                        }
                    }
                    if ($hitTimes == 2) {
                        $level = 1;
                    } elseif ($hitTimes == 3) {
                        $level = array(1, 1, 1);
                    }
                    break;
                case 'JSSTDX':   //三同号单选
                    $parts = explode('_', $code);
                    foreach ($parts as $v) {
                        if ($v == $prize_code) {
                            $level = 1;
                            break;
                        }
                    }
                    break;
                case 'JSSTTX':   //三同号通选
                    $possibleCodes = array('111', '222', '333', '444', '555', '666');
                    if (in_array($prize_code, $possibleCodes)) {
                        $level = 1;
                    }
                    break;
                case 'JSSBT':   //三不同号
                    $parts = str_split($code);
                    $prizeParts = str_split($prize_code);
                    $hitTimes = 0;
                    foreach ($parts as $v) {
                        if (in_array($v, $prizeParts)) {
                            $hitTimes++;
                        }
                    }
                    if ($hitTimes > 2) {
                        $level = 1;
                    }
                    break;
                case 'JSSLTX':   //三连号通选
                    $possibleCodes = array('123', '234', '345', '456');
                    if (in_array($prize_code, $possibleCodes)) {
                        $level = 1;
                    }
                    break;
                /////////////////////////  快乐扑克区    ////////////////////////
                //$prize_code   Th 7c Ks
                case 'PKDZ':   //对子  $code AA_33_44_66
                    $tmp = explode(' ', $prize_code);
                    $tmpDuizi = array($tmp[0][0], $tmp[1][0], $tmp[2][0]);
                    //判断是否对子
                    if (count(array_unique($tmpDuizi)) == 2) {
                        $tmpDuizi = $tmpDuizi[0] == $tmpDuizi[1] ? $tmpDuizi[0] . $tmpDuizi[1] : ($tmpDuizi[0] == $tmpDuizi[2] ? $tmpDuizi[0] . $tmpDuizi[2] : $tmpDuizi[1] . $tmpDuizi[2]);
                        //中奖判断
                        if (strpos($code, $tmpDuizi) !== false) {
                            $level = 1;
                        }
                    }

                    break;
                case 'PKBZ':   //豹子  $code AAA_333_444_666
                    $tmp = explode(' ', $prize_code);
                    $tmpBaozi = array($tmp[0][0], $tmp[1][0], $tmp[2][0]);
                    //判断是否豹子
                    if (count(array_unique($tmpBaozi)) == 1) {
                        //中奖判断
                        if (strpos($code, implode('', $tmpBaozi)) !== false) {
                            $level = 1;
                        }
                    }

                    break;
                case 'PKTHS':   //同花顺子  $code 红桃顺子_黑桃顺子_梅花顺子_方块顺子
                    $tmp = explode(' ', $prize_code);
                    //花色数组 h,c,s
                    $tmpColors = array($tmp[0][1], $tmp[1][1], $tmp[2][1]);
                    //开奖三张牌花色不同
                    if (count(array_unique($tmpColors)) == 1) {
                        //开奖同花顺的花色
                        $prizeColor = self::$pokerSuitMaps[$tmp[0][1]];

                        $pokerFlip = array_flip(self::$pokerNumMaps);
                        $tmpSort = array($pokerFlip[$tmp[0][0]], $pokerFlip[$tmp[1][0]], $pokerFlip[$tmp[2][0]]);
                        sort($tmpSort);
                        //判断是否顺子
                        if (($tmpSort[0] + 1 == $tmpSort[1] && $tmpSort[0] + 2 == $tmpSort[2]) || ($tmpSort[0] == 1 && $tmpSort[1] == 12 && $tmpSort[2] == 13)) {
                            //中奖判断
                            $parts = explode('_', $code);
                            foreach ($parts as $v) {
                                if (mb_substr($v, 0, 2, 'utf-8') == $prizeColor) {
                                    $level = 1;
                                }
                            }
                        }
                    }

                    break;
                case 'PKSZ':   //扑克 顺子  $code A23_345_9TJ_TJQ
                    $pokerFlip = array_flip(self::$pokerNumMaps);
                    $tmp = explode(' ', $prize_code);
                    $tmpCodes = array($pokerFlip[$tmp[0][0]], $pokerFlip[$tmp[1][0]], $pokerFlip[$tmp[2][0]]);   //10,11,12
                    //对开奖的三张牌从小到大排序,组成一个字符串
                    sort($tmpCodes);
                    $priePoker = self::$pokerNumMaps[$tmpCodes[0]] . self::$pokerNumMaps[$tmpCodes[1]] . self::$pokerNumMaps[$tmpCodes[2]];

                    //中奖判断
                    $parts = explode('_', $code);

                    if ((in_array($priePoker, $parts)) || (in_array('QKA', $parts) && $priePoker == 'AQK')) {
                        $level = 1;
                    }

                    break;
                case 'PKTH':   //扑克 同花      $code 黑桃_红桃
                    $tmp = explode(' ', $prize_code);
                    //花色数组 h,c,s
                    $tmpColors = array($tmp[0][1], $tmp[1][1], $tmp[2][1]);
                    if (count(array_unique($tmpColors)) == 1) {
                        $possibleCodes = self::$pokerSuitMaps;
                        //开奖同花的花色       红桃
                        $prizeSuit = $possibleCodes[$tmp[0][1]];
                        $parts = explode('_', $code);

                        if (in_array($prizeSuit, $parts)) {
                            $level = 1;
                        }
                    }

                    break;
                case 'PKBX':   //扑克 包选      $code 同花包选_顺子包选_豹子包选_对子包选_同花顺包选
                    $winLevel = self::getPokerForm($prize_code);
                    $tmpForm = array('同花顺' => '同花顺包选', '豹子' => '豹子包选', '顺子' => '顺子包选', '同花' => '同花包选', '对子' => '对子包选');
                    $tmplevel = array('同花顺包选' => 1, '豹子包选' => 2, '顺子包选' => 3, '同花包选' => 4, '对子包选' => 5);
                    $parts = explode('_', $code);
                    $level = array();
                    if (in_array($tmpForm[$winLevel], $parts)) {
                        $level[] = $tmplevel[$tmpForm[$winLevel]];
                    }
                    if ($tmpForm[$winLevel] == '同花顺包选') {
                        if (in_array('顺子包选', $parts)) {
                            $level[] = $tmplevel['顺子包选'];
                        }
                        if (in_array('同花包选', $parts)) {
                            $level[] = $tmplevel['同花包选'];
                        }
                    }

                    break;
                case 'PKRX1':   //扑克 任选一   $code  A_2_T_K
                    $tmp = explode(' ', $prize_code);
                    $tmpCodes = array($tmp[0][0], $tmp[1][0], $tmp[2][0]);   //T,7,K
                    //号码不得重复
                    $parts = explode('_', $code);
                    $level = array();
                    foreach ($parts as $v) {
                        if (in_array($v, $tmpCodes)) {
                            $level[] = 1;
                        }
                    }

                    break;
                case 'PKRX2':   //扑克 任选二   $code  A_2_T_K_3_5
                    $tmp = explode(' ', $prize_code);
                    $openCodes = array_unique(array($tmp[0][0], $tmp[1][0], $tmp[2][0]));   //T,7,K
                    //判断不是豹子
                    if (count($openCodes) != 1) {
                        $parts = explode('_', $code);
                        $x = $betNum = 0;
                        foreach ($openCodes as $v) {
                            if (in_array($v, $parts)) {
                                $x++;
                            }
                        }
                        if (count($openCodes) == 2 && $x == 2) {//如果是对子
                            $betNum = 1;
                        }
                        if (count($openCodes) == 3) {//不是对子最多只有3注
                            if ($x == 2) {
                                $betNum = 1;
                            }
                            if ($x == 3) {
                                $betNum = 3;
                            }
                        }
                        if ($betNum) {
                            $level = array_fill(0, $betNum, 1);
                        }
                    }

                    break;
                case 'PKRX3':   //扑克 任选三   $code  A_2_T_K_3_5
                    $tmp = explode(' ', $prize_code);
                    $openCodes = array_unique(array($tmp[0][0], $tmp[1][0], $tmp[2][0]));   //T,7,K
                    $parts = explode('_', $code);

                    $x = $betNum = 0;
                    foreach ($openCodes as $v) {
                        if (in_array($v, $parts)) {
                            $x++;
                        }
                    }
                    if (count($openCodes) == 1 && $x == 1) {//如果是豹子 C $codeNum-1,2
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) / 2;
                    }
                    if (count($openCodes) == 2 && $x == 2) {//如果是对子 C $codeNum-2,1
                        $betNum = count($parts) - $x;
                    }
                    if (count($openCodes) == 3 && $x == 3) {
                        $betNum = 1;
                    }
                    if ($betNum) {
                        $level = array_fill(0, $betNum, 1);
                    }

                    break;
                case 'PKRX4':   //扑克 任选四   $code  A_2_T_K_3_5
                    $tmp = explode(' ', $prize_code);
                    $openCodes = array_unique(array($tmp[0][0], $tmp[1][0], $tmp[2][0]));   //T,7,K
                    $parts = explode('_', $code);

                    $x = $betNum = 0;
                    foreach ($openCodes as $v) {
                        if (in_array($v, $parts)) {
                            $x++;
                        }
                    }

                    if (count($openCodes) == 1 && $x == 1) {//如果是豹子 C $codeNum-1,3
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) * ($codeNum - 2) / 6;
                    }
                    if (count($openCodes) == 2 && $x == 2) {//如果是对子 C $codeNum-2,2
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) / 2;
                    }
                    if (count($openCodes) == 3 && $x == 3) {//如果其他 C $codeNum-3,1
                        $betNum = count($parts) - $x;
                    }
                    if ($betNum) {
                        $level = array_fill(0, $betNum, 1);
                    }

                    break;
                case 'PKRX5':   //扑克 任选五   $code  A_2_T_K_3_5
                    $tmp = explode(' ', $prize_code);
                    $openCodes = array_unique(array($tmp[0][0], $tmp[1][0], $tmp[2][0]));   //T,7,K
                    $parts = explode('_', $code);

                    $x = $betNum = 0;
                    foreach ($openCodes as $v) {
                        if (in_array($v, $parts)) {
                            $x++;
                        }
                    }

                    if (count($openCodes) == 1 && $x == 1) {//如果是豹子 C $codeNum-1,4
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) * ($codeNum - 2) * ($codeNum - 3) / 24;
                    }
                    if (count($openCodes) == 2 && $x == 2) {//如果是对子 C $codeNum-2,3
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) * ($codeNum - 2) / 6;
                    }
                    if (count($openCodes) == 3 && $x == 3) {//如果其他 C $codeNum-3,2
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) / 2;
                    }
                    if ($betNum) {
                        $level = array_fill(0, $betNum, 1);
                    }

                    break;
                case 'PKRX6':   //扑克 任选六   $code  A_2_T_K_3_5
                    $tmp = explode(' ', $prize_code);
                    $openCodes = array_unique(array($tmp[0][0], $tmp[1][0], $tmp[2][0]));   //T,7,K
                    $parts = explode('_', $code);

                    $x = $betNum = 0;
                    foreach ($openCodes as $v) {
                        if (in_array($v, $parts)) {
                            $x++;
                        }
                    }
                    if (count($openCodes) == 1 && $x == 1) {//如果是豹子 C $codeNum-1,5
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) * ($codeNum - 2) * ($codeNum - 3) * ($codeNum - 4) / 120;
                    }
                    if (count($openCodes) == 2 && $x == 2) {//如果是对子 C $codeNum-2,4
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) * ($codeNum - 2) * ($codeNum - 3) / 24;
                    }
                    if (count($openCodes) == 3 && $x == 3) {//如果其他 C $codeNum-3,3
                        $codeNum = count($parts) - $x;
                        $betNum = $codeNum * ($codeNum - 1) * ($codeNum - 2) / 6;
                    }
                    if ($betNum) {
                        $level = array_fill(0, $betNum, 1);
                    }

                    break;

                case 'PKQYZX':  //猜冠 01_02_03_04,02_03,01_05
                case 'PKQELX':
                case 'PKQSLX':
                case 'PKQ4LX':
                case 'PKQ5LX':
                case 'PKQ6LX':
                case 'PKQ7LX':
                case 'PKQ8LX':
                case 'PKQ9LX':
                case 'PKQ10LX':
                    $prize_codes = explode(' ', $prize_code);
                    $expandNums = array();

                    $tmp = explode(',', $code);
                    foreach ($tmp as $k => $v){
                        $expandNums[$k] = explode('_', $v);
                    }
                    $expandNums = self::CC($expandNums, false);
                    $level = array();

//                    $tmplevel = array(1 => array(), 2 => array(), 3 => array(), 4 => array(),);

                    foreach ($expandNums as $expandNum) {
                        $parts = $expandNum;
                        $hits = 0;
                        foreach ($parts as $pos => $part) {
                            $nums = explode('_', $part);
                            if (in_array($prize_codes[$pos], $nums)) {
                                $hits++;
                            }
                        }

                        switch ($hits) {
                            case 0:
                                if ($method['name'] == 'PKQ10LX') {
                                    $level[] = 2;
                                    break;
                                }
                                break;

                            case 1:

                                if ($method['name'] == 'PKQYZX') {
                                    $level[] = 1;
                                    break;
                                }
                                if ($method['name'] == 'PKQELX') {
                                    $level[] = 2;
                                    break;
                                }
                                if ($method['name'] == 'PKQSLX') {
                                    $level[] = 3;
                                    break;
                                }
                                if ($method['name'] == 'PKQ4LX') {
//                                    $tmplevel[4][]=$expandNum;
                                    $level[] = 4;
                                    break;
                                }
                                if ($method['name'] == 'PKQ5LX') {
                                    $level[] = 5;
                                    break;
                                }


                                break;
                            case 2:
                                if ($method['name'] == 'PKQELX') {
                                    $level[] = 1;
                                    break;
                                }
                                if ($method['name'] == 'PKQSLX') {
                                    $level[] = 2;
                                    break;
                                }
                                if ($method['name'] == 'PKQ4LX') {
//                                    $tmplevel[3][]=$expandNum;
                                    $level[] = 3;
                                    break;
                                }
                                if ($method['name'] == 'PKQ5LX') {
                                    $level[] = 4;
                                    break;
                                }
                                if ($method['name'] == 'PKQ6LX') {
                                    $level[] = 5;
                                    break;
                                }
                                if ($method['name'] == 'PKQ7LX') {
                                    $level[] = 6;
                                    break;
                                }
                                if ($method['name'] == 'PKQ8LX') {
                                    $level[] = 7;
                                    break;
                                }
                                if ($method['name'] == 'PKQ9LX') {
                                    $level[] = 8;
                                    break;
                                }

                                break;
                            case 3:

                                if ($method['name'] == 'PKQSLX') {
                                    $level[] = 1;
                                    break;
                                }
                                if ($method['name'] == 'PKQ4LX') {
//                                    $tmplevel[2][]=$expandNum;
                                    $level[] = 2;
                                    break;
                                }
                                if ($method['name'] == 'PKQ5LX') {
                                    $level[] = 3;
                                    break;
                                }
                                if ($method['name'] == 'PKQ6LX') {
                                    $level[] = 4;
                                    break;
                                }
                                if ($method['name'] == 'PKQ7LX') {
                                    $level[] = 5;
                                    break;
                                }
                                if ($method['name'] == 'PKQ8LX') {
                                    $level[] = 6;
                                    break;
                                }
                                if ($method['name'] == 'PKQ9LX') {
                                    $level[] = 7;
                                    break;
                                }

                                break;
                            case 4:
                                if ($method['name'] == 'PKQ4LX') {
//                                    $tmplevel[1][]=$expandNum;
                                    $level[] = 1;
                                    break;
                                }
                                if ($method['name'] == 'PKQ5LX') {
                                    $level[] = 2;
                                    break;
                                }
                                if ($method['name'] == 'PKQ6LX') {
                                    $level[] = 3;
                                    break;
                                }
                                if ($method['name'] == 'PKQ7LX') {
                                    $level[] = 4;
                                    break;
                                }
                                if ($method['name'] == 'PKQ8LX') {
                                    $level[] = 5;
                                    break;
                                }
                                if ($method['name'] == 'PKQ9LX') {
                                    $level[] = 6;
                                    break;
                                }

                                break;
                            case 5:
                                if ($method['name'] == 'PKQ5LX') {
                                    $level[] = 1;
                                    break;
                                }
                                if ($method['name'] == 'PKQ6LX') {
                                    $level[] = 2;
                                    break;
                                }
                                if ($method['name'] == 'PKQ7LX') {
                                    $level[] = 3;
                                    break;
                                }
                                if ($method['name'] == 'PKQ8LX') {
                                    $level[] = 4;
                                    break;
                                }
                                if ($method['name'] == 'PKQ9LX') {
                                    $level[] = 5;
                                    break;
                                }

                                break;
                            case 6:
                                if ($method['name'] == 'PKQ6LX') {
                                    $level[] = 1;
                                    break;
                                }
                                if ($method['name'] == 'PKQ7LX') {
                                    $level[] = 2;
                                    break;
                                }
                                if ($method['name'] == 'PKQ8LX') {
                                    $level[] = 3;
                                    break;
                                }
                                if ($method['name'] == 'PKQ9LX') {
                                    $level[] = 4;
                                    break;
                                }

                                break;
                            case 7:
                                if ($method['name'] == 'PKQ7LX') {
                                    $level[] = 1;
                                    break;
                                }
                                if ($method['name'] == 'PKQ8LX') {
                                    $level[] = 2;
                                    break;
                                }
                                if ($method['name'] == 'PKQ9LX') {
                                    $level[] = 3;
                                    break;
                                }

                                break;
                            case 8:
                                if ($method['name'] == 'PKQ8LX') {
                                    $level[] = 1;
                                    break;
                                }
                                if ($method['name'] == 'PKQ9LX') {
                                    $level[] = 2;
                                    break;
                                }

                                break;
                            case 9:
                                if ($method['name'] == 'PKQ9LX') {
                                    $level[] = 1;
                                    break;
                                }

                                break;
                            case 10:
                                if ($method['name'] == 'PKQ10LX') {
                                    $level[] = 1;
                                    break;
                                }

                                break;

                            default:
                                throw new Exception('Non supported pk10 method');
                                break;
                        }
                    }


//                    var_dump($tmplevel);

                    break;
                case 'DM_JSHZ':
                    $prize_codes = str_split($prize_code);


                    if ($code == array_sum($prize_codes)) {
                        switch ($code) {
                            case 17:
                            case 4:

                                $level = 1;
                                break;
                            case 16:
                            case 5:

                                $level = 2;
                                break;
                            case 15:
                            case 6:

                                $level = 3;
                                break;
                            case 14:
                            case 7:

                                $level = 4;
                                break;
                            case 13:
                            case 8:

                                $level = 5;
                                break;
                            case 9:
                            case 10:
                            case 11:
                            case 12:

                                $level = 6;
                                break;

                            default:
                                break;
                        }
                    }


                    break;
                case 'DM_JSETFX':
                    $prizeParts = str_split($prize_code);
                    //如果不是组三态显然没中奖
                    $tmp = str_replace('*', '', $code);

                    if (strpos($prize_code, $tmp) !== false) {
                        $level = 1;
                    }

                    break;
                case 'DM_JSSTTX':
                    $possibleCodes = array('111', '222', '333', '444', '555', '666');
                    if (in_array($prize_code, $possibleCodes)) {
                        $level = 1;
                    }
                    break;
                case 'DM_JSSTDX';

                    if ($code == $prize_code) {
                        $level = 1;
                        break;
                    }
                    break;

                case 'DM_KSXT':
                    $prizeParts = str_split($prize_code);
                    if ($prizeParts[0] != $prizeParts[1] || $prizeParts[0] != $prizeParts[2]) {
                        $sum = array_sum($prizeParts);
                        switch ($code) {
                            case '大':
                                if ($sum >= 11 && $sum <= 17) {
                                    $level = 1;
                                }
                                break;
                            case '小':
                                if ($sum >= 4 && $sum <= 10) {
                                    $level = 1;
                                }

                                break;
                            case '单':
                                if ($sum % 2 != 0) {
                                    $level = 1;
                                }

                                break;
                            case '双':
                                if ($sum % 2 == 0) {
                                    $level = 1;
                                }

                                break;

                            default:
                                break;
                        }
                    }
                    break;
                case 'DM_JSEBT':

                    $parts = explode(',', $code);
                    $prizeParts = str_split($prize_code);
                    $hitTimes = 0;
                    //用我买的号码 去激活他
                    foreach ($parts as $v) {
                        if (in_array($v, $prizeParts)) {
                            $hitTimes++;
                        }
                    }
                    if ($hitTimes >= 2) {
                        $level = 1;
                    }
                    break;
                case 'DM_KSRXY':
                    $prizeParts = str_split($prize_code);
                    $hitTimes = 0;
                    //用我买的号码 去激活他
                    foreach ($prizeParts as $v) {
                        if ($v == $code) {
                            $hitTimes++;
                        }
                    }

                    if ($hitTimes == 3) {
                        $level = 1;
                    } else if ($hitTimes == 2) {
                        $level = 2;
                    } else if ($hitTimes == 1) {
                        $level = 3;
                    }


                    break;


                /**
                 * 海南七星彩
                 */
                case 'DM_QXQWZX':
                    $prizeParts = str_split($prize_code);
                    if ($prizeParts[0] == $code) {
                        $level = 1;
                    }

                    break;

                case 'DM_QXBWZX':
                    $prizeParts = str_split($prize_code);
                    if ($prizeParts[1] == $code) {
                        $level = 1;
                    }

                    break;

                case 'DM_QXSWZX':
                    $prizeParts = str_split($prize_code);
                    if ($prizeParts[2] == $code) {
                        $level = 1;
                    }

                    break;
                case 'DM_QXGWZX':
                    $prizeParts = str_split($prize_code);
                    if ($prizeParts[3] == $code) {
                        $level = 1;
                    }

                    break;
                case 'DM_QXQ5ZX':
                    $prizeParts = str_split($prize_code);
                    if ($prizeParts[4] == $code) {
                        $level = 1;
                    }

                    break;
                case 'DM_QXQ6ZX':
                    $prizeParts = str_split($prize_code);
                    if ($prizeParts[5] == $code) {
                        $level = 1;
                    }

                    break;
                case 'DM_QXQ7ZX':
                    $prizeParts = str_split($prize_code);
                    if ($prizeParts[6] == $code) {
                        $level = 1;
                    }

                    break;
                case 'DM_QXEDW':
                    $prizeParts = str_split($prize_code);
                    $hits = 0;
                    $codeParts = explode(',', $code, 4);
                    foreach ($codeParts as $k => $codePart) {
                        if ($codePart != '-' && $codePart == $prizeParts[$k]) {
                            $hits++;
                        }
                    }

                    if ($hits == 2) {
                        $level = 1;
                    }

                    break;

                case 'DM_QXSDW':
                    $prizeParts = str_split($prize_code);
                    $hits = 0;
                    $codeParts = explode(',', $code, 4);
                    foreach ($codeParts as $k => $codePart) {
                        if ($codePart != '-' && $codePart == $prizeParts[$k]) {
                            $hits++;
                        }
                    }

                    if ($hits == 3) {
                        $level = 1;
                    }

                    break;

                case 'DM_QXSIDW':
                    $prizeParts = str_split($prize_code);
                    $hits = 0;
                    $codeParts = explode(',', $code, 4);
                    foreach ($codeParts as $k => $codePart) {
                        if ($codePart != '-' && $codePart == $prizeParts[$k]) {
                            $hits++;
                        }
                    }

                    if ($hits == 4) {
                        $level = 1;
                    }

                    break;

                case 'DM_QXYZX':
                    $prizeParts = str_split($prize_code);
                    $hits = 0;
                    for ($i = 0; $i < 4; $i++) {
                        if ($prize_code{$i} == $code) {
                            $hits++;
                            break;
                        }
                    }


                    if ($hits) {
                        $level = 1;
                    }

                    break;

                case 'DM_QXEZX':
                    $prizeCodefor4 = substr($prize_code, 0, 4);
                    if ($code{0} != $code{1}) {
                        if (substr_count($prizeCodefor4, $code{0}) >= 1 && substr_count($prizeCodefor4, $code{1}) >= 1) {
                            $level = 2;
                        }
                    } else {
                        if (substr_count($prizeCodefor4, $code{0}) >= 2) {
                            $level = 1;
                        }
                    }
                    break;
                case 'DM_QXSZX':
                    $prizeCodefor4 = substr($prize_code, 0, 4);


                    if (substr_count($prizeCodefor4, $code{0}) >= substr_count($code, $code{0}) && substr_count($prizeCodefor4, $code{1}) >= substr_count($code, $code{1}) && substr_count($prizeCodefor4, $code{2}) >= substr_count($code, $code{2})) {
                        if ($code{0} == $code{1} && $code{1} == $code{2}) {//333
                            $level = 1;
                        } else if ($code{0} != $code{1} && $code{1} != $code{2} && $code{0} != $code{2}) {//123
                            $level = 3;
                        } else {//223
                            $level = 2;
                        }
                    }


                    break;

                case 'DM_QXSIZX':
                    $prizeCodefor4 = substr($prize_code, 0, 4);
                    if (substr_count($prizeCodefor4, $code{0}) >= substr_count($code, $code{0}) && substr_count($prizeCodefor4, $code{1}) >= substr_count($code, $code{1}) && substr_count($prizeCodefor4, $code{2}) >= substr_count($code, $code{2}) && substr_count($prizeCodefor4, $code{3}) >= substr_count($code, $code{3})) {
                        $codeParts = str_split($code);
                        $uniCount = count(array_unique($codeParts));
                        if ($uniCount == 1) {
                            $level = 1;
                        } else if ($uniCount == 2) {//aaab aabb
                            if (substr_count($code, $code{0}) == 2) { //aabb
                                $level = 3;
                            } else {
                                $level = 2;
                            }
                        } else if ($uniCount == 3) { //aabc
                            $level = 4;
                        } else if ($uniCount == 4) {
                            $level = 5;
                        }
                    }
                    break;

                case 'DM_QXSIZH':
                    $sum = (int) $prize_code{0} + (int) $prize_code{1} + (int) $prize_code{2} + (int) $prize_code{3};
                    if ($sum >= 0 && $sum <= 10) {
                        $sum = '0-10';
                    } else if ($sum >= 26 && $sum <= 36) {
                        $sum = '26-36';
                    }
                    if ($sum == $code) {
                        $level = self::$DM_QXSIZH[$sum];
                    }


                    break;

                case 'DM_QXSIZHWS':
                    $sum = (int) $prize_code{0} + (int) $prize_code{1} + (int) $prize_code{2} + (int) $prize_code{3};
                    if (substr(strval($sum), -1, 1) == $code) {
                        $level = 1;
                    }


                    break;

                case 'DM_QXEZH':
                    $codeNums = explode('_', $code);
                    $posStr = $codeNums[0];
                    $numStr = $codeNums[1];
                    $pos = array();
                    if (strpos($posStr, '千') !== false) {
                        $pos[] = 0;
                    }
                    if (strpos($posStr, '百') !== false) {
                        $pos[] = 1;
                    }
                    if (strpos($posStr, '十') !== false) {
                        $pos[] = 2;
                    }
                    if (strpos($posStr, '个') !== false) {
                        $pos[] = 3;
                    }
                    $sum = (int) $prize_code{$pos[0]} + (int) $prize_code{$pos[1]};
                    if ($sum == $numStr) {
                        $level = self::$DM_QXEZH[$sum];
                    }
                    break;

                case 'DM_QXEZHWS':
                    $codeNums = explode('_', $code);
                    $posStr = $codeNums[0];
                    $numStr = $codeNums[1];
                    $pos = array();
                    if (strpos($posStr, '千') !== false) {
                        $pos[] = 0;
                    }
                    if (strpos($posStr, '百') !== false) {
                        $pos[] = 1;
                    }
                    if (strpos($posStr, '十') !== false) {
                        $pos[] = 2;
                    }
                    if (strpos($posStr, '个') !== false) {
                        $pos[] = 3;
                    }
                    $sum = (int) $prize_code{$pos[0]} + (int) $prize_code{$pos[1]};

                    if (substr(strval($sum), -1, 1) == $numStr) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXQWSM':

                    $num = $prize_code{0};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }



                    break;
                case 'DM_QXBWSM':
                    $num = $prize_code{1};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXSWSM':
                    $num = $prize_code{2};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXGWSM':
                    $num = $prize_code{3};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXQ5SM':
                    $num = $prize_code{4};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXQ6SM':
                    $num = $prize_code{5};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXQ7SM':
                    $num = $prize_code{6};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXZHSM':
                    $num = $prize_code{0} + $prize_code{1} + $prize_code{2} + $prize_code{3} + $prize_code{4} + $prize_code{5} + $prize_code{6};
                    $numLast = substr(strval($num), -1, 1);
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '尾大' && $numLast >= 5) {
                        $level = 1;
                    } else if ($code == '尾小' && $numLast <= 4) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 32) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 31) {
                        $level = 1;
                    }
                    //大 小 单 双 尾大 尾小

                    break;
                case 'DM_QXQBHSM':
                    $num = $prize_code{0} + $prize_code{1};
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 2;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 2;
                    } else if ($code == '大' && $num >= 10) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 9) {
                        $level = 3;
                    }

                    break;
                case 'DM_QXQSHSM':
                    $num = $prize_code{0} + $prize_code{2};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 2;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 2;
                    } else if ($code == '大' && $num >= 10) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 9) {
                        $level = 3;
                    }
                    break;
                case 'DM_QXQGHSM':
                    $num = $prize_code{0} + $prize_code{3};
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 2;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 2;
                    } else if ($code == '大' && $num >= 10) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 9) {
                        $level = 3;
                    }
                    break;
                case 'DM_QXBSHSM':
                    $num = $prize_code{1} + $prize_code{2};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 2;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 2;
                    } else if ($code == '大' && $num >= 10) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 9) {
                        $level = 3;
                    }
                    break;
                case 'DM_QXBGHSM':
                    $num = $prize_code{1} + $prize_code{3};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 2;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 2;
                    } else if ($code == '大' && $num >= 10) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 9) {
                        $level = 3;
                    }
                    break;
                case 'DM_QXSGHSM':
                    $num = $prize_code{2} + $prize_code{3};

                    if ($code == '单' && $num % 2 == 1) {
                        $level = 2;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 2;
                    } else if ($code == '大' && $num >= 10) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 9) {
                        $level = 3;
                    }
                    break;
                case 'DM_QXQBHWSSM':
                    $num = $prize_code{0} + $prize_code{1};
                    $num = substr(strval($num), -1, 1);
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXQSHWSSM':
                    $num = $prize_code{0} + $prize_code{2};
                    $num = substr(strval($num), -1, 1);
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXQGHWSSM':
                    $num = $prize_code{0} + $prize_code{3};
                    $num = substr(strval($num), -1, 1);
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXBSHWSSM':
                    $num = $prize_code{1} + $prize_code{2};
                    $num = substr(strval($num), -1, 1);
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXBGHWSSM':
                    $num = $prize_code{1} + $prize_code{3};
                    $num = substr(strval($num), -1, 1);
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXSGHWSSM':
                    $num = $prize_code{2} + $prize_code{3};
                    $num = substr(strval($num), -1, 1);
                    if ($code == '单' && $num % 2 == 1) {
                        $level = 1;
                    } else if ($code == '双' && $num % 2 == 0) {
                        $level = 1;
                    } else if ($code == '大' && $num >= 5) {
                        $level = 1;
                    } else if ($code == '小' && $num <= 4) {
                        $level = 1;
                    } else if ($code == '质' && in_array($num, array('1', '2', '3', '5', '7'))) {
                        $level = 1;
                    } else if ($code == '合' && in_array($num, array('0', '4', '6', '8', '9'))) {
                        $level = 1;
                    }
                    break;
                case 'DM_QXLHH':
                    preg_match_all('`^[龙虎和]{1}(\d{1})_(\d{1})$`ui', $code, $matches);
                    if (strpos($matches[0][0], '龙') !== false && $prize_code{$matches[1][0] - 1} > $prize_code{$matches[2][0] - 1}) {
                        $level = 2;
                    } else if (strpos($matches[0][0], '虎') !== false && $prize_code{$matches[1][0] - 1} < $prize_code{$matches[2][0] - 1}) {
                        $level = 2;
                    } else if (strpos($matches[0][0], '和') !== false && $prize_code{$matches[1][0] - 1} == $prize_code{$matches[2][0] - 1}) {
                        $level = 1;
                    }
                    break;
                default:
                    throw new Exception('Non supported method');
                    break;
            }
            //算具体奖金 先得到奖金信息
            if ($level === 0) {
                continue;
            }
//            $finalPrize = self::computeFinalPrizePrize($lottery, $method, $project, $level, $userRebate);
//            $allPrize += $finalPrize;
        }
        return $level;
    }
    /**
     * 计算玩法奖金 统一为单倍的奖金,外面的金额要 乘以 mode 乘以 multiple
     * @param type $lottery  lottery_id total_profit
     * @param type $method
     * @param type $project 最少包含 cur_rebate multiple amount  cur_odds
     * @param type $level 为1是最大奖
     * @param type $userRebate 其中 为0是最小奖 为 cur_rebate是最大奖
     * @return real
     * @throws exception2
     */
    static public function computeFinalPrizePrize($lottery, $method, $project, $level) {

        return $level;
    }
    /**
     * 此方法用于前台下注时判断指定玩法所投注号码是否合法 避免非正常提交 后台中奖时为慎重起见也可再次判断
     * 判断注单号码表示是否合法 选区之间用逗号分隔，同区之内如有可能2位数字的（如山东十一运）可用下划线分隔，同理，对于三星包点可能超过9，如果买2个号也应采用下划线分隔，如8_10
     * @param array $method 玩法数组
     * @param string $code 号码
     * @return integer 所包含的购买注数，注意这和转直注数不是一个概念
     */
    protected function isLegalCode($method, $code) {
        //按玩法分别判断
        switch ($method['name']) {
            //三星
            case 'SXZX':    //三星直选 12,34,567;
            case 'ZSZX':   //中三直选
            case 'QSZX':    //前三直选
                if (!preg_match('`^\d{1,10},\d{1,10},\d{1,10}$`Ui', $code)) {
                    return false;
                }
                //3个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    //优化情节：大于一个数的才需要判断是否可能重复号码
                    if (strlen($v) > 1) {
                        $tmp = str_split($v);
                        if (count($tmp) != count(array_unique($tmp))) {
                            return false;
                        }
                    }
                }

                //算注数 相乘即可
                return strlen($parts[0]) * strlen($parts[1]) * strlen($parts[2]);
                break;
            case 'SXZS':    //三星组三 123;
            case 'ZSZS':   //中三组三
            case 'QSZS':
                if (!preg_match('`^\d{2,10}$`Ui', $code)) {
                    return false;
                }
                //1个号区 同位上不应有重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }

                //算注数 Cn_2 * 2 正好是Pn_2
                return strlen($code) * (strlen($code) - 1);
                break;
            case 'SXZL':    //三星组六  1234;
            case 'ZSZL':    //中三组六
            case 'QSZL':
                if (!preg_match('`^\d{3,10}$`Ui', $code)) {
                    return false;
                }
                //1个号区 同区上不应有重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }

                //算注数 Cn_3
                return strlen($code) * (strlen($code) - 1) * (strlen($code) - 2) / self::factorial(3);
                break;

            case 'SXTSH'://三星特殊号
            case 'ZSTSH'://三星特殊号
            case 'QSTSH'://前三特殊号
                $tmpcodes = explode('_', $code);
                foreach ($tmpcodes as $tmpcode) {
                    if (!in_array($tmpcode, self::$SXTSH)) {
                        return false;
                    }
                }
                return count($tmpcodes);
                break;


            case 'SXLX':    //三星连选 12345,123,58;
            case 'ZSLX':   //中三连选
            case 'QSLX':    //前三连选
                if (!preg_match('`^\d{1,10},\d{1,10},\d{1,10}$`Ui', $code)) {
                    return false;
                }
                //3个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    $tmp = str_split($v);
                    if (count($tmp) != count(array_unique($tmp))) {
                        return false;
                    }
                }

                //算注数 后三注数+后二注数+后一注数
                $betNums3 = strlen($parts[0]) * strlen($parts[1]) * strlen($parts[2]);
                $betNums2 = strlen($parts[1]) * strlen($parts[2]);
                $betNums1 = strlen($parts[2]);
                return $betNums3 + $betNums2 + $betNums1;
                break;
            case 'SXBD':    //三星包点 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果;
            case 'ZSBD':
            case 'QSBD':
                if (!preg_match('`^\d{1,2}(_\d{1,2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //判断具体的值
                $betNums = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 0 || $v > 27) {
                        return false;
                    }
                    if (!isset(self::$SXBD[$v])) {
                        return false;
                    }
                    $betNums += self::$SXBD[$v];
                }

                return $betNums;
                break;
            case 'SXHHZX':    //三星混合组选 仅单式;
            case 'ZSHHZX':   //中三混合组选
            case 'QSHHZX':    //前三混合组选 仅单式
                if (!preg_match('`^\d,\d,\d$`Ui', $code)) {
                    return false;
                }
                //不应是豹子号
                $parts = explode(',', $code);
                if ($parts[0] == $parts[1] && $parts[1] == $parts[2]) {
                    return false;
                }

                //算注数 相乘即可
                return 1;
                break;

            //二星
            case 'EXZX':    //二星直选 0123456789,0123456789
            case 'QEZX':
                if (!preg_match('`^\d{1,10},\d{1,10}$`Ui', $code)) {
                    return false;
                }
                //2个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    $tmp = str_split($v);
                    if (count($tmp) != count(array_unique($tmp))) {
                        return false;
                    }
                }

                //算注数 相乘
                return strlen($parts[0]) * strlen($parts[1]);
                break;
            case 'EXZUX':    //二星组选 0123456789
            case 'QEZUX':
                if (!preg_match('`^\d{2,10}$`Ui', $code)) {
                    return false;
                }
                //1个号区 同区上不应有重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }

                //不允许选择超过7个号码 否则视为非法 这应作为通用方法，因为每一field_def都有定义max_selected
                if (count($tmp) > $method['field_def'][1]['max_selected']) {
                    return false;
                }

                //算注数 Cn_2
                return count($tmp) * (count($tmp) - 1) / 2;
                break;
            case 'EXLX':    //二星连选 0123456789,0123456789
            case 'QELX':
                if (!preg_match('`^\d{1,10},\d{1,10}$`Ui', $code)) {
                    return false;
                }
                //3个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    $tmp = str_split($v);
                    if (count($tmp) != count(array_unique($tmp))) {
                        return false;
                    }
                }

                //算注数 后二注数+后一注数
                $betNums2 = strlen($parts[0]) * strlen($parts[1]);
                $betNums1 = strlen($parts[1]);
                return $betNums2 + $betNums1;
                break;
            case 'EXBD':    //二星包点 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果
            case 'QEBD':
                if (!preg_match('`^\d{1,2}(_\d{1,2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //判断具体的值
                $betNums = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 0 || $v > 18) {
                        return false;
                    }
                    if (!isset(self::$EXBD[$v])) {
                        return false;
                    }
                    $betNums += self::$EXBD[$v];
                }

                return $betNums;
                break;

            //一星
            case 'YXZX':  //一星直选 0123456789
            case 'SXHZWS'://3星尾数
            case 'QSHZWS'://前3尾数
            case 'ZSHZWS'://前3尾数
            case 'ZSYMBDW':    //一定位
            case 'SSCQSYMBDW':    //一定位
            case 'SXYMBDW':    //一定位
                if (!preg_match('`^\d{1,10}$`Ui', $code)) {
                    return false;
                }
                //1个号区 同区上不应有重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }

                //算注数 简单
                return strlen($code);
                break;


            case 'WXLHH'://
                if (!preg_match('`^[龙虎和]{1,3}$`ui', $code)) {
                    return 0;
                }

                if (strlen($code) % 3 !== 0) {
                    return 0;
                }
                //检查位置重复
                if (substr_count($code, '龙') > 1 || substr_count($code, '虎') > 1 || substr_count($code, '和') > 1) {
                    return 0;
                }

                return strlen($code) / 3;
                break;

            case 'WXHZDXDS'://
                if (!preg_match('`^[大小单双]{1,4}$`ui', $code)) {
                    return 0;
                }

                if (strlen($code) % 3 !== 0) {
                    return 0;
                }
                //检查位置重复
                if (substr_count($code, '大') > 1 || substr_count($code, '小') > 1 || substr_count($code, '单') > 1 || substr_count($code, '双') > 1) {
                    return 0;
                }

                return strlen($code) / 3;
                break;

            case 'SXZXKD'://3星跨度
            case 'QSZXKD'://前3跨度
            case 'ZSZXKD'://中3跨度
                if (!preg_match('`^\d{1,10}$`Ui', $code)) {
                    return false;
                }
                //1个号区 同区上不应有重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }
                //判断具体的值
                $betNums = 0;
                foreach ($tmp as $v) {
                    if (!isset(self::$SXZXKD[$v])) {
                        return false;
                    }
                    $betNums += self::$SXZXKD[$v];
                }
                return $betNums;
                break;

            case 'EXZXKD'://2星跨度
            case 'QEZXKD'://前2跨度
                if (!preg_match('`^\d{1,10}$`Ui', $code)) {
                    return false;
                }
                //1个号区 同区上不应有重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }
                //判断具体的值
                $betNums = 0;
                foreach ($tmp as $v) {
                    if (!isset(self::$EXZXKD[$v])) {
                        return false;
                    }
                    $betNums += self::$EXZXKD[$v];
                }
                return $betNums;
                break;

            case 'WXDW':    //五星定位 0123456789,0123456789,0123456789,0123456789,0123456789 或,2,3,,都是合法的
                if (!preg_match('`^\d{0,10},\d{0,10},\d{0,10},\d{0,10},\d{0,10}$`Ui', $code)) {
                    return false;
                }
                //5个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                $betNums = 0;
                foreach ($parts as $v) {
                    $tmp = str_split($v);
                    if (count($tmp) != count(array_unique($tmp))) {
                        return false;
                    }
                    $betNums += strlen($v);
                }

                //算注数 相乘即可
                return $betNums;
                break;
            case 'WXEMBDW':    //五星2定位
            case 'ZSEMBDW':    //2定位
            case 'SSCQSEMBDW':    //2定位
            case 'SXEMBDW':    //2定位
                if (!preg_match('`^\d{2,10}$`Ui', $code)) {
                    return false;
                }
                $codeLen = strlen($code);

                //重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }
                return $codeLen * ($codeLen - 1) / 2;
                break;

            case 'WXSMBDW':    //五星3定位
                if (!preg_match('`^\d{3,10}$`Ui', $code)) {
                    return false;
                }
                $codeLen = strlen($code);

                //重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }
                return $codeLen * ($codeLen - 1) * ($codeLen - 2) / 6;
                break;

            case 'SXDW':    //低频3D特有 三星定位 0123456789,0123456789,0123456789 或,2,都是合法的
                if (!preg_match('`^\d{0,10},\d{0,10},\d{0,10}$`Ui', $code)) {
                    return false;
                }
                //3个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                $betNums = 0;
                foreach ($parts as $v) {
                    $tmp = str_split($v);
                    if (count($tmp) != count(array_unique($tmp))) {
                        return false;
                    }
                    $betNums += strlen($v);
                }

                //算注数 相乘即可
                return $betNums;
                break;


            //不定位
            case 'EMBDW':   //三星二码不定位 一注仅限一组号码，如1,2，因为奖金本来就低，也为了判断方便
            case 'QSEMBDW': //低频P3特有 前三二码不定位
                if (!preg_match('`^\d,\d$`Ui', $code)) {
                    return false;
                }

                //算注数 一次只能有一注
                return 1;
                break;
            case 'YMBDW':   //三星一码不定位 一注仅限一个号码，如1，因为奖金本来就低，也为了判断方便
            case 'QSYMBDW': //低频P3特有 前三二码不定位
                if (!preg_match('`^\d$`Ui', $code)) {
                    return false;
                }

                //算注数 一次只能有一注
                return 1;
                break;

            //大小单双
            case 'SXDXDS':    //三星大小单双 大,小,单 一注仅限一个号码 因为奖金本来就低
                $parts = explode(',', $code);
                if (count($parts) != 3) {
                    return false;
                }
                foreach ($parts as $v) {
                    if (!in_array($v, array('大', '小', '单', '双'))) {
                        return false;
                    }
                }

                //算注数 一次只能有一注
                return 1;
                break;
            case 'EXDXDS':    //二星大小单双 大,单 一注仅限一个号码 因为奖金本来就低
            case 'QEDXDS':      //前二大小单双 低频3D特有
                $parts = explode(',', $code);
                if (count($parts) != 2) {
                    return false;
                }
                foreach ($parts as $v) {
                    if (!in_array($v, array('大', '小', '单', '双'))) {
                        return false;
                    }
                }

                //算注数 一次只能有一注
                return 1;
                break;

            //和值
            case 'SXHZ':    //三星和值 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果;
            case 'ZSHZ':   //中三和值
            case 'QSHZ':
                if (!preg_match('`^\d{1,2}(_\d{1,2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                //判断具体的值
                $betNums = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 0 || $v > 27) {
                        return false;
                    }
                    if (!isset(self::$SXHZ[$v])) {
                        return false;
                    }
                    $betNums += self::$SXHZ[$v];
                }

                return $betNums;
                break;
            case 'EXHZ':    //二星和值 一注可以有多个号码 不同号码之间要用_分隔 因为有大于9的结果
            case 'QEHZ':
                if (!preg_match('`^\d{1,2}(_\d{1,2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //判断具体的值
                $betNums = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 0 || $v > 18) {
                        return false;
                    }
                    if (!isset(self::$EXHZ[$v])) {
                        return false;
                    }
                    $betNums += self::$EXHZ[$v];
                }

                return $betNums;
                break;
            case 'SXZXHZ':  //低频3D特有 组选和值
            case 'QSZXHZ':  //低频P3P5特有 组选和值
                if (!preg_match('`^\d{1,2}(_\d{1,2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                //判断具体的值
                $betNums = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 1 || $v > 26) {
                        return false;
                    }
                    if (!isset(self::$SXZXHZ[$v])) {
                        return false;
                    }
                    $betNums += self::$SXZXHZ[$v];
                }

                return $betNums;
                break;

            //四星
            case 'SIXZX':    //四星直选
            case 'QSIZX':    //前四直选
                if (!preg_match('`^\d{1,10},\d{1,10},\d{1,10},\d{1,10}$`Ui', $code)) {

                    //复式
                    $splitLenght = 15000;
                    $codeLen = strlen($code);

                    $posed = array();
                    if ($codeLen > $splitLenght) {
                        //单式多注  先分割
                        for ($index = $splitLenght; $index < $codeLen; $index+=$splitLenght) {
                            $postmp = strpos($code, '|', $index);
                            if ($postmp !== false) {
                                $posed[] = $postmp;
                            }
                        }
                        if ($posed) {
                            $posed[] = -1; //marked as the last one
                        }
                    } else {
                        $posed[] = -1;
                    }
                    if ($posed) {
                        $num = 0;
                        $posStart = 0;
                        foreach ($posed as $pos) {
                            if ($pos == -1) {//the last one .need to the end
                                $tmpCode = substr($code, $posStart);
                            } else {
                                $tmpCode = substr($code, $posStart, $pos - $posStart);
                            }
                            if (preg_match('`^(\d,\d,\d,\d\|)+$`', $tmpCode . '|')) {
                                $num+= (strlen($tmpCode) + 1) / 8;
                                if (!is_int($num)) {
                                    return false;
                                }
                            } else {

                                return false;
                            }
                            $posStart = $pos + 1;
                        }

                        return $num;
                    } else {
                        return false;
                    }
                }
                //4个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    //优化情节：大于一个数的才需要判断是否可能重复号码
                    if (strlen($v) > 1) {
                        $tmp = str_split($v);
                        if (count($tmp) != count(array_unique($tmp))) {
                            return false;
                        }
                    }
                }

                //算注数 相乘即可
                return strlen($parts[0]) * strlen($parts[1]) * strlen($parts[2]) * strlen($parts[3]);
                break;
            case 'RSZU6':
                if (!preg_match('`^[万千百十个]{3,5}_\d{3,10}$`ui', $code)) {
                    return false;
                }

                $codesSplit = explode('_', $code);

                if (count($codesSplit) != 2) {
                    return false;
                }

                //不应有重复号码
                if (count(str_split($codesSplit[1])) != count(array_unique(str_split($codesSplit[1])))) {
                    return false;
                }


                $posLen = self::getNumRxPos(3, $codesSplit[0]);


                $codesLen = strlen($codesSplit[1]);
                $codesLen = $posLen * $codesLen * ($codesLen - 1) * ($codesLen - 2) / self::factorial(3);
                $codesLen = $codesLen > 0 ? $codesLen : 0;
                return $codesLen;
                break;

            case 'REZXHZ':
                //检查字符串合法 格式合法
                if (!preg_match('`^[万千百十个]{2,5}_\d{1,2}(_\d{1,2})*$`ui', $code)) {
                    return false;
                }
                //检查注单重复
                $codesSplit = explode('_', $code, 2);
                $zsNum = self::getNumRxPos(2, $codesSplit[0]);
                //号码不得重复
                $parts = explode('_', $codesSplit[1]);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                //判断具体的值
                $singleNum = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 0 || $v > 18) {
                        return false;
                    }
                    if (!isset(self::$EXHZ[$v])) {
                        return false;
                    }
                    $singleNum += self::$EXHZ[$v];
                }

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;



                break;
            case 'REZUX':
                //检查字符串合法 格式合法
                if (!preg_match('`^[万千百十个]{2,5}_\d{2,10}$`ui', $code)) {
                    return false;
                }
                //检查注单重复
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $parts = str_split($codesSplit[1]);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //检查位置重复
                $zsNum = self::getNumRxPos(2, $codesSplit[0]); //2表示2个位置一组

                $singleNum = count($parts) * (count($parts) - 1) / self::factorial(2);


                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;


                //计算注数


                break;
            case 'REZUXHZ':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数
//检查字符串合法 格式合法
                if (!preg_match('`^[万千百十个]{2,5}_\d{1,2}(_\d{1,2})*$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(2, $codesSplit[0]); //2表示2个位置一组

                $parts = explode('_', $codesSplit[1]);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                $singleNum = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 1 || $v > 17) {
                        return false;
                    }
                    if (!isset(self::$EXZUHZ[$v])) {
                        return false;
                    }
                    $singleNum += self::$EXZUHZ[$v];
                }

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;

                break;
            case 'RSZXHZ':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数

                if (!preg_match('`^[万千百十个]{3,5}_\d{1,2}(_\d{1,2})*$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(3, $codesSplit[0]); //2表示2个位置一组

                $parts = explode('_', $codesSplit[1]);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                $singleNum = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 0 || $v > 27) {
                        return false;
                    }

                    if (!isset(self::$SXHZ[$v])) {
                        return false;
                    }

                    $singleNum += self::$SXHZ[$v];
                }

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;


                break;
            case 'RSZU3':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数
                if (!preg_match('`^[万千百十个]{3,5}_\d{2,10}$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(3, $codesSplit[0]); //2表示2个位置一组

                $parts = str_split($codesSplit[1]);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                $singleNum = count($parts) * (count($parts) - 1);

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;

                break;
            case 'RSZUXHZ':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数

                if (!preg_match('`^[万千百十个]{3,5}_\d{1,2}(_\d{1,2})*$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(3, $codesSplit[0]); //2表示2个位置一组

                $parts = explode('_', $codesSplit[1]);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                $singleNum = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 1 || $v > 26) {
                        return false;
                    }
                    if (!isset(self::$SXZXHZ[$v])) {
                        return false;
                    }
                    $singleNum += self::$SXZXHZ[$v];
                }

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;


                break;
            case 'RSHHZX':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数
                if (!preg_match('`^[万千百十个]{3,5}_\d,\d,\d$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(3, $codesSplit[0]); //2表示2个位置一组

                $parts = explode(',', $codesSplit[1]);
                if ($parts[0] == $parts[1] && $parts[1] == $parts[2]) {
                    return false;
                }

                $singleNum = 1;

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;


                break;
            case 'R4ZX':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数
                if (!preg_match('`^(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-)$`Ui', $code)) {

                    $codesSplit = explode('_', $code, 2); //只分割为2个

                    $zsNum = self::getNumRxPos(4, $codesSplit[0]); //2表示2个位置一组
                    //单式投注 2种情况
                    if (!preg_match('`^[万千百十个]{4,5}_\d,\d,\d,\d$`ui', $code)) {

                        //注单太多合并的情况
                        $codeZhudan = str_replace($codesSplit[0] . '_', '', $code);
                        $splitLenght = 15000;
                        $codeLen = strlen($codeZhudan);
                        $posed = array();
                        if ($codeLen > $splitLenght) {
                            //单式多注  先分割
                            for ($index = $splitLenght; $index < $codeLen; $index+=$splitLenght) {
                                $postmp = strpos($codeZhudan, '|', $index);
                                if ($postmp !== false) {
                                    $posed[] = $postmp;
                                }
                            }
                            if ($posed) {
                                $posed[] = -1; //marked as the last one
                            }
                        } else {
                            $posed[] = -1;
                        }
                        if ($posed) {
                            $num = 0;
                            $posStart = 0;
                            foreach ($posed as $pos) {
                                if ($pos == -1) {//the last one .need to the end
                                    $tmpCode = substr($codeZhudan, $posStart);
                                } else {
                                    $tmpCode = substr($codeZhudan, $posStart, $pos - $posStart);
                                }
                                if (preg_match('`^(\d,\d,\d,\d\|)+$`', $tmpCode . '|')) {
                                    $num+= (strlen($tmpCode) + 1) / 8;
                                    if (!is_int($num)) {
                                        return false;
                                    }
                                } else {
                                    return false;
                                }
                                $posStart = $pos + 1;
                            }

                            return $num * $zsNum;
                        } else {
                            return false;
                        }
                    } else {//只有一注
                        return 1 * $zsNum;
                    }
                } else {//复式投注
                    $rightPos = array();
                    $codes = explode(',', $code);
                    for ($i = 0; $i < 5; $i++) {
                        if ($codes[$i] != '-') {
                            $rightPos[] = $i;
                        }
                    }
                    if (count($rightPos) < 4) {
                        return false;
                    }
                    foreach ($codes as $k => $v) {
//                    号码不得重复
                        if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                            return false;
                        }
                    }
                    $singleNum = 0;
                    $zuhes = self::C($rightPos, 4);
                    if ($zuhes) {
                        foreach ($zuhes as $zuhe) {
                            $pos = str_split($zuhe);
                            if (count($pos) != 4) {
                                return false;
                            }
                            $singleNum += strlen($codes[$pos[0]]) * strlen($codes[$pos[1]]) * strlen($codes[$pos[2]]) * strlen($codes[$pos[3]]);
                        }
                    }
                    return $singleNum;
                }


                break;
            case 'R4ZUX24':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数
                if (!preg_match('`^[万千百十个]{4,5}_\d{4,10}$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(4, $codesSplit[0]); //2表示2个位置一组

                $parts = explode(',', $codesSplit[1]);
                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }

                $singleNum = strlen($codesSplit[1]) * (strlen($codesSplit[1]) - 1) * (strlen($codesSplit[1]) - 2) * (strlen($codesSplit[1]) - 3) / self::factorial(4);

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;

                break;
            case 'R4ZUX12':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数

                if (!preg_match('`^[万千百十个]{4,5}_\d{1,10},\d{2,10}$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(4, $codesSplit[0]); //2表示2个位置一组

                $expNum = $parts = explode(',', $codesSplit[1]);
                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }
                $sameNum = 0;
                for ($i = 0; $i < strlen($expNum[0]); $i++) {
                    if (strpos($expNum[1], $expNum[0]{$i}) !== false) {
                        $sameNum++;
                    }
                }
                $singleNum = strlen($expNum[0]) * strlen($expNum[1]) * (strlen($expNum[1]) - 1) / self::factorial(2);
                if ($sameNum > 0) {
                    $singleNum -= $sameNum * (strlen($expNum[1]) - 1);
                }

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;

                break;
            case 'R4ZUX6':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数
                if (!preg_match('`^[万千百十个]{4,5}_\d{2,10}$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(4, $codesSplit[0]); //2表示2个位置一组

                $expNum = $parts = explode(',', $codesSplit[1]);
                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }
                $singleNum = strlen($expNum[0]) * (strlen($expNum[0]) - 1) / self::factorial(2);

                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;
                break;
            case 'R4ZUX4':
                //检查字符串合法 格式合法
                //检查注单重复
                //检查位置重复
                //计算注数


                if (!preg_match('`^[万千百十个]{4,5}_\d{1,10},\d{1,10}$`ui', $code)) {
                    return false;
                }
                $codesSplit = explode('_', $code, 2); //只分割为2个
                $zsNum = self::getNumRxPos(4, $codesSplit[0]); //2表示2个位置一组
                $expNum = $parts = explode(',', $codesSplit[1]);
                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }

                $sameNum = 0;
                for ($i = 0; $i < strlen($expNum[0]); $i++) {
                    if (strpos($expNum[1], $expNum[0]{$i}) !== false) {
                        $sameNum++;
                    }
                }
                $singleNum = strlen($expNum[0]) * strlen($expNum[1]);
                if ($sameNum > 0) {
                    $singleNum -= $sameNum;
                }
                $singleNum = $singleNum > 0 ? $singleNum : 0;
                $singleNum*=$zsNum;
                return $singleNum;
                break;

            case 'WXZUX120':
                if (!preg_match('`^\d{5,10}$`i', $code)) {
                    return false;
                }
                //1个号区 同区上不应有重复号码
                $tmp = str_split($code);
                if (count($tmp) != count(array_unique($tmp))) {
                    return false;
                }

                //算注数 Cn_3
                return strlen($code) * (strlen($code) - 1) * (strlen($code) - 2) * (strlen($code) - 3) * (strlen($code) - 4) / self::factorial(5);
                break;

            case 'WXZUX60':
                if (!preg_match('`^\d{1,10},\d{3,10}$`i', $code)) {
                    return false;
                }
                $expNum = explode(',', $code);
                foreach ($expNum as $v) {
                    //号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }

                $sameNum = 0;
                for ($i = 0; $i < strlen($expNum[0]); $i++) {
                    if (strpos($expNum[1], $expNum[0]{$i}) !== false) {
                        $sameNum++;
                    }
                }
                $singleNum = strlen($expNum[0]) * strlen($expNum[1]) * (strlen($expNum[1]) - 1) * (strlen($expNum[1]) - 2) / self::factorial(3);
                if ($sameNum > 0) {
                    $singleNum -= $sameNum * (strlen($expNum[1]) - 1) * (strlen($expNum[1]) - 2) / self::factorial(2);
                }
                return $singleNum;

                break;

            case 'WXZUX30':
                if (!preg_match('`^\d{2,10},\d{1,10}$`i', $code)) {
                    return false;
                }
                $expNum = explode(',', $code);
                foreach ($expNum as $v) {
                    //号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }

                $sameNum = 0;
                for ($i = 0; $i < strlen($expNum[0]); $i++) {
                    if (strpos($expNum[1], $expNum[0]{$i}) !== false) {
                        $sameNum++;
                    }
                }
                $singleNum = strlen($expNum[1]) * strlen($expNum[0]) * (strlen($expNum[0]) - 1) / self::factorial(2);
                if ($sameNum > 0) {
                    $singleNum -= $sameNum * (strlen($expNum[0]) - 1);
                }
                return $singleNum;

                break;

            case 'WXZUX20':
                if (!preg_match('`^\d{1,10},\d{2,10}$`i', $code)) {
                    return false;
                }
                $expNum = explode(',', $code);

                foreach ($expNum as $v) {
                    //号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }


                $sameNum = 0;
                for ($i = 0; $i < strlen($expNum[0]); $i++) {
                    if (strpos($expNum[1], $expNum[0]{$i}) !== false) {
                        $sameNum++;
                    }
                }
                $singleNum = strlen($expNum[0]) * strlen($expNum[1]) * (strlen($expNum[1]) - 1) / self::factorial(2);
                if ($sameNum > 0) {
                    $singleNum -= $sameNum * (strlen($expNum[1]) - 1);
                }
                return $singleNum;

                break;

            case 'WXZUX10':
                if (!preg_match('`^\d{1,10},\d{1,10}$`i', $code)) {
                    return false;
                }
                $parts = explode(',', $code);
                $tmp = array();
                foreach ($parts as $k => $v) {
                    //号码不得重复
                    $tmp[$k] = str_split($v);
                    if (count($tmp[$k]) != count(array_unique($tmp[$k]))) {
                        return false;
                    }
                }


                return self::CC($tmp);
                break;

            case 'WXZUX5':
                if (!preg_match('`^\d{1,10},\d{1,10}$`i', $code)) {
                    return false;
                }
                $parts = explode(',', $code);
                $tmp = array();
                foreach ($parts as $k => $v) {
                    //号码不得重复
                    $tmp[$k] = str_split($v);
                    if (count($tmp[$k]) != count(array_unique($tmp[$k]))) {
                        return false;
                    }
                }

                return self::CC($tmp);
                break;
            case 'SXZUX24':
                if (!preg_match('`^\d{4,10}$`i', $code)) {
                    return false;
                }
                $expNum = $parts = explode(',', $code);
                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }
                return strlen($code) * (strlen($code) - 1) * (strlen($code) - 2) * (strlen($code) - 3) / self::factorial(4);
                break;

            case 'SXZUX12':
                if (!preg_match('`^\d{1,10},\d{2,10}$`i', $code)) {
                    return false;
                }
                $expNum = $parts = explode(',', $code);
                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }
                $sameNum = 0;
                for ($i = 0; $i < strlen($expNum[0]); $i++) {
                    if (strpos($expNum[1], $expNum[0]{$i}) !== false) {
                        $sameNum++;
                    }
                }
                $singleNum = strlen($expNum[0]) * strlen($expNum[1]) * (strlen($expNum[1]) - 1) / self::factorial(2);
                if ($sameNum > 0) {
                    $singleNum -= $sameNum * (strlen($expNum[1]) - 1);
                }
                return $singleNum;

                break;

            case 'SXZUX6':
                if (!preg_match('`^\d{2,10}$`i', $code)) {
                    return false;
                }
                $expNum = $parts = explode(',', $code);
                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }
                $singleNum = strlen($expNum[0]) * (strlen($expNum[0]) - 1) / self::factorial(2);
                return $singleNum;

                break;
            case 'SXZUX4':
                if (!preg_match('`^\d{1,10},\d{1,10}$`i', $code)) {
                    return false;
                }
                $expNum = $parts = explode(',', $code);

                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }

                $sameNum = 0;
                for ($i = 0; $i < strlen($expNum[0]); $i++) {
                    if (strpos($expNum[1], $expNum[0]{$i}) !== false) {
                        $sameNum++;
                    }
                }
                $singleNum = strlen($expNum[0]) * strlen($expNum[1]);
                if ($sameNum > 0) {
                    $singleNum -= $sameNum;
                }
                return $singleNum;

                break;

            case 'WXYFFS':
            case 'WXHSCS':
            case 'WXSXBX':
            case 'WXSJFC':
                if (!preg_match('`^\d{1,10}$`i', $code)) {
                    return false;
                }
                $expNum = $parts = explode(',', $code);
                foreach ($parts as $k => $v) {
//                    号码不得重复
                    if (count(str_split($v)) != count(array_unique(str_split($v)))) {
                        return false;
                    }
                }
                return strlen($code);

                break;
            //五星
            case 'WXZX':    //五星直选
                //单式一注
                if (preg_match('`^\d{1},\d{1},\d{1},\d{1},\d{1}$`', $code)) {
                    return 1;
                }

                //复式
                if (!preg_match('`^\d{1,10},\d{1,10},\d{1,10},\d{1,10},\d{1,10}$`Ui', $code)) {

                    //复式
                    $splitLenght = 15000;
                    $codeLen = strlen($code);

//                    $num = ($codeLen + 1) / 10;
//                    if (!is_int($num)) {
//                        return false;
//                    }
//                    return $num;

                    $posed = array();
                    if ($codeLen > $splitLenght) {


                        //单式多注  先分割
                        for ($index = $splitLenght; $index < $codeLen; $index+=$splitLenght) {
                            $postmp = strpos($code, '|', $index);
                            if ($postmp !== false) {
                                $posed[] = $postmp;
                            }
                        }
                        if ($posed) {
                            $posed[] = -1; //marked as the last one
                        }
                    } else {
                        $posed[] = -1;
                    }
                    if ($posed) {
                        $num = 0;
                        $posStart = 0;
                        $formatOk = false;
                        foreach ($posed as $pos) {
                            if ($pos == -1) {//the last one .need to the end
                                $tmpCode = substr($code, $posStart);
                            } else {
                                $tmpCode = substr($code, $posStart, $pos - $posStart);
                            }
                            if (preg_match('`^(\d,\d,\d,\d,\d\|)+$`', $tmpCode . '|')) {
                                $formatOk = true;
                                //break;
                                $num+= (strlen($tmpCode) + 1) / 10;
                            } else {

                                return false;
                            }
                            $posStart = $pos + 1;
                        }

                        return $num;
                    } else {
                        return false;
                    }
                }
                //5个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    //优化情节：大于一个数的才需要判断是否可能重复号码
                    if (strlen($v) > 1) {
                        $tmp = str_split($v);
                        if (count($tmp) != count(array_unique($tmp))) {
                            return false;
                        }
                    }
                }

                return strlen($parts[0]) * strlen($parts[1]) * strlen($parts[2]) * strlen($parts[3]) * strlen($parts[4]);
                break;
            case 'WXLX':    //五星连选
                if (!preg_match('`^\d{1,10},\d{1,10},\d{1,10},\d{1,10},\d{1,10}$`Ui', $code)) {
                    return false;
                }
                //5个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    $tmp = str_split($v);
                    if (count($tmp) != count(array_unique($tmp))) {
                        return false;
                    }
                }

                //算注数 五星注数+后三注数+后二注数+后一注数
                $betNums5 = strlen($parts[0]) * strlen($parts[1]) * strlen($parts[2]) * strlen($parts[3]) * strlen($parts[4]);
                $betNums3 = strlen($parts[2]) * strlen($parts[3]) * strlen($parts[4]);
                $betNums2 = strlen($parts[3]) * strlen($parts[4]);
                $betNums1 = strlen($parts[4]);
                return $betNums5 + $betNums3 + $betNums2 + $betNums1;
                break;
            case 'REZX':    //任二直选
                if (!preg_match('`^(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-)$`Ui', $code)) {
                    return false;
                }
                //5个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    $tmp = str_split($v);
                    if (count($tmp) != count(array_unique($tmp))) {
                        return false;
                    }
                }

                $singleNum = 0;
                for ($i = 0; $i < 4; $i++) {
                    if ($parts[$i] != '-') {
                        for ($j = ($i + 1); $j < 5; $j++) {
                            if ($parts[$j] != '-') {
                                $singleNum += strlen($parts[$i]) * strlen($parts[$j]);
                            }
                        }
                    }
                }
                return $singleNum;
                break;
            case 'RSZX':    //任三直选
                if (!preg_match('`^(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-),(\d{1,10}|\-)$`Ui', $code)) {
                    return false;
                }
                //5个号区 同区上不应有重复号码
                $parts = explode(',', $code);
                foreach ($parts as $v) {
                    $tmp = str_split($v);
                    if (count($tmp) != count(array_unique($tmp))) {
                        return false;
                    }
                }

                $singleNum = 0;
                for ($i = 0; $i < 3; $i++) {
                    if ($parts[$i] != '-') {
                        for ($j = ($i + 1); $j < 4; $j++) {
                            if ($parts[$j] != '-') {
                                for ($k = ($j + 1); $k < 5; $k++) {
                                    if ($parts[$k] != '-') {
                                        $singleNum += strlen($parts[$i]) * strlen($parts[$j]) * strlen($parts[$k]);
                                    }
                                }
                            }
                        }
                    }
                }
                return $singleNum;
                break;

            //
            //  SD11Y   SD11Y   SD11Y   SD11Y   SD11Y   SD11Y   SD11Y   SD11Y
            //
            //前三
            case 'SDQSZX':  //前三直选 01_02_03_04,02_03,01_05 计算方法应展开再排除重复
                $parts = explode(',', $code);
                if (count($parts) != 3) {
                    return false;
                }

                $tmp = array();
                foreach ($parts as $k => $v) {
                    //号码不得重复
                    $tmp[$k] = explode('_', $v);
                    if (count($tmp[$k]) != count(array_unique($tmp[$k]))) {
                        return false;
                    }
                    foreach ($tmp[$k] as $vv) {
                        if (!preg_match('`^(01|02|03|04|05|06|07|08|09|10|11)$`', $vv)) {
                            return false;
                        }
                    }
                }
                $result = self::expandLotto($parts);

                return count($result);
                break;
            case 'SDQSZUX':     //前三组选 一段 01_02_03_04
                if (!preg_match('`^\d{2}_\d{2}_\d{2}(_[_0-9]+)*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                //最后精确判断每个数字是否在合适大小
                foreach ($parts as $v) {
                    if (intval($v) < 1 || intval($v) > 11) {
                        return false;
                    }
                }

                //算注数 Cn_3
                return count($parts) * (count($parts) - 1) * (count($parts) - 2) / self::factorial(3);
                break;
            //前二
            case 'SDQEZX':     //前二直选 二段 01_02_03_04,02_03
                $parts = explode(',', $code);
                if (count($parts) != 2) {
                    return false;
                }

                $tmp = array();
                foreach ($parts as $k => $v) {
                    //号码不得重复
                    $tmp[$k] = explode('_', $v);
                    if (count($tmp[$k]) != count(array_unique($tmp[$k]))) {
                        return false;
                    }
                    foreach ($tmp[$k] as $vv) {
                        if (!preg_match('`^(01|02|03|04|05|06|07|08|09|10|11)$`', $vv)) {
                            return false;
                        }
                    }
                }
                $result = self::expandLotto($parts);

                return count($result);
                break;
            case 'SDQEZUX':     //前二组选 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}_\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数 Cn_2
                return count($parts) * (count($parts) - 1) / 2;
                break;

            //任选
            case 'SDRX1':     //任选1 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数
                return count($parts);
                break;
            case 'SDRX2':     //任选2 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}_\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数 Cn_2
                return count($parts) * (count($parts) - 1) / 2;
                break;
            case 'SDRX3':     //任选3 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}_\d{2}_\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数 Cn_3
                return count($parts) * (count($parts) - 1) * (count($parts) - 2) / 6;
                break;
            case 'SDRX4':     //任选4 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}_\d{2}_\d{2}_\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数 Cn_4
                return count($parts) * (count($parts) - 1) * (count($parts) - 2) * (count($parts) - 3) / 24;
                break;
            case 'SDRX5':     //任选5 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}_\d{2}_\d{2}_\d{2}_\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数 Cn_5
                return count($parts) * (count($parts) - 1) * (count($parts) - 2) * (count($parts) - 3) * (count($parts) - 4) / 120;
                break;
            case 'SDRX6':     //任选6 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}_\d{2}_\d{2}_\d{2}_\d{2}_\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数 Cn_6
                return count($parts) * (count($parts) - 1) * (count($parts) - 2) * (count($parts) - 3) * (count($parts) - 4) * (count($parts) - 5) / 720;
                break;
            case 'SDRX7':     //任选7 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}_\d{2}_\d{2}_\d{2}_\d{2}_\d{2}_\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数 Cn_7
                return count($parts) * (count($parts) - 1) * (count($parts) - 2) * (count($parts) - 3) * (count($parts) - 4) * (count($parts) - 5) * (count($parts) - 6) / 5040;
                break;
            case 'SDRX8':     //任选8 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}_\d{2}_\d{2}_\d{2}_\d{2}_\d{2}_\d{2}_\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数 Cn_8
                return count($parts) * (count($parts) - 1) * (count($parts) - 2) * (count($parts) - 3) * (count($parts) - 4) * (count($parts) - 5) * (count($parts) - 6) * (count($parts) - 7) / 40320;
                break;

            //前3不定位胆
            case 'SDQSBDW':     //前3不定位胆 一段 01_02_03_04_05_06_07_08_09_10_11
                if (!preg_match('`^\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数
                return count($parts);
                break;
            //前3定位胆
            case 'SDQSDWD':     //前3定位胆 01_02_03,04_05,06_07为一单 也可以只买一位，如'01_02_03,,'表示只买个位胆，没买的位留空
                $parts = explode(',', $code);
                if (count($parts) != 3) {
                    return false;
                }
                $betNums = 0;
                foreach ($parts as $v) {
                    if ($v != '') {
                        if (!preg_match('`^\d{2}(_\d{2})*$`Ui', $v)) {
                            return false;
                        }
                        //号码不得重复
                        $parts2 = explode('_', $v);
                        $betNums += count($parts2);
                        if (count($parts2) != count(array_unique($parts2))) {
                            return false;
                        }
                    }
                }

                //算注数
                return $betNums;
                break;

            //定单双
            case 'SDDDS':     //0单5双:750.0000元 (1注) 5单0双:125.0000元 (6注)1单4双:25.0000元 (30注)4单1双:10.0000元 (75注)2单3双:5.0000元 (150注)3单2双:3.7000元 (200注)
                //projects表中用012345表示0~5单(5-0~5)双
//                if (!preg_match('`^[0-5]+$`Ui', $code)) {
//                    return false;
//                }
//                //号码不得重复
//                $parts = str_split($code);
//                if (count($parts) != count(array_unique($parts))) {
//                    return false;
//                }
//                return count($parts);
                //更改：拟用实际中文作为projects表中表示 只有一注 判断中奖方法也要改
                if (!in_array($code, self::$SDDDS)) {
                    return false;
                }

                //一次只能有一注
                return 1;
                break;
            //猜中位
            case 'SDCZW':     // 一段03_04_05_06_07_08_09 全买
                if (!preg_match('`^\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                foreach ($parts as $v) {
                    if (intval($v) < 3 || intval($v) > 9) {
                        return false;
                    }
                }

                //算注数
                return count($parts);
                break;


            /** 江苏快三
             *  号码表示方法：号区之间用,分隔，同区内号码之间一般不用分隔符，若可能有2位表示的，用_分隔（如和值玩法或sd11y）
            注单表示方法（改进版）：String codes = "46:1,2,3,4,5|6,7,8,9,0|1,2,3,4,5#43:1,2,3|6,7,0";
             */
            case 'JSETDX':  //二同单选 2个号区 11_22,34 排重处理要另外做
                if (!preg_match('`^\d{2}(_\d{2})*,\d+$`Ui', $code)) {
                    return false;
                }
                $parts = explode(',', $code);

                //号区1 同区上不应有重复号码
                $tmp0 = explode('_', $parts[0]);
                if (count($tmp0) != count(array_unique($tmp0))) {
                    return false;
                }
                $possibleCodes = array('11', '22', '33', '44', '55', '66');
                foreach ($tmp0 as $v) {
                    if (!in_array($v, $possibleCodes)) {
                        return false;
                    }
                }

                //号区2 同区上不应有重复号码 并且不应和号区一的重复
                $tmp1 = str_split($parts[1]);
                if (count($tmp1) != count(array_unique($tmp1))) {
                    return false;
                }
                foreach ($tmp1 as $v) {
                    if (strpos($parts[0], strval($v)) !== false) {
                        return false;
                    }
                }

                //算注数 相乘即可
                return count($tmp0) * count($tmp1);
                break;
            case 'JSETFX':  //二同复选 1个号区 11_22_33 排重处理要另外做
                if (!preg_match('`^\d{2}(_\d{2})*$`Ui', $code)) {
                    return false;
                }

                //号区1 同区上不应有重复号码
                $parts = explode('_', $code);
                $possibleCodes = array('11', '22', '33', '44', '55', '66');
                foreach ($parts as $v) {
                    if (!in_array($v, $possibleCodes)) {
                        return false;
                    }
                }

                //算注数 相乘即可
                return count($parts);
                break;
            case 'JSHZ':   //快三和值
                if (!preg_match('`^\d{1,2}(_\d{1,2})*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                //判断具体的值
                $betNums = 0;
                foreach ($parts as $v) {
                    if (!is_numeric($v) || $v < 3 || $v > 18) {
                        return false;
                    }
                }
                $betNums = count($parts);

                return $betNums;
                break;
            case 'JSEBT':   //二不同号
                if (!preg_match('`^\d{2,6}$`Ui', $code)) {
                    return false;
                }
                $parts = str_split($code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                //判断具体的值
                $betNums = count(self::C($parts, 2));
                return $betNums;
                break;
            case 'JSSTDX':   //三同号单选
                if (!preg_match('`^\d{3}(_\d{3})*$`Ui', $code)) {
                    return false;
                }

                //号区1 同区上不应有重复号码
                $parts = explode('_', $code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                $possibleCodes = array('111', '222', '333', '444', '555', '666');
                foreach ($parts as $v) {
                    if (!in_array($v, $possibleCodes)) {
                        return false;
                    }
                }

                //算注数 相乘即可
                return count($parts);
                break;
            case 'JSSTTX':   //三同号通选
                if ($code != '111_222_333_444_555_666') {
                    return false;
                }
                return 1;
                break;
            case 'JSSBT':   //三不同号
                if (!preg_match('`^\d{3,6}$`Ui', $code)) {
                    return false;
                }
                $parts = str_split($code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                //判断具体的值
                $betNums = count(self::C($parts, 3));
                return $betNums;
                break;
            case 'JSSLTX':   //三连号通选
                if ($code != '123_234_345_456') {
                    return false;
                }
                return 1;
                break;
            /////////////////////////  快乐扑克区    ////////////////////////
            /** 快乐扑克区
             *  号码表示方法：
             *  1、同花包选  2、顺子包选    3、同花顺包选       4、豹子包选      5、对子包选      (全部都已上述文字为注码)
             *  6、同花单选 : 黑桃_红桃_梅花_方块
            7、顺子单选 : A23_345_9TJ_TJQ

            8、同花顺单选 : 红桃顺子_黑桃顺子_梅花顺子_方块顺子

            9、豹子单选 : AAA_222_TTT_JJJ_QQQ

            10、对子单选 ：AA_22_TT_JJ_QQ

            11、任选一 : A_T_J
            .........
            12、任选六 : A_3_T_J_Q_K
             */
            case 'PKSZ':   //扑克 顺子  A23_345_9TJ_TJQ
                if (!preg_match('`^(A23|234|345|456|567|678|789|89T|9TJ|TJQ|JQK|QKA)(_(A23|234|345|456|567|678|789|89T|9TJ|TJQ|JQK|QKA))*$`U', $code)) {
                    return false;
                }

                $parts = explode('_', $code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数
                return count($parts);

                break;
            case 'PKTH':   //扑克 同花
                $parts = explode('_', $code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                $possibleCodes = array('黑桃', '红桃', '梅花', '方块');
                foreach ($parts as $v) {
                    if (!in_array($v, $possibleCodes)) {
                        return false;
                    }
                }

                //算注数
                return count($parts);

                break;
            case 'PKTHS':   //同花顺 红桃顺子_黑桃顺子_梅花顺子_方块顺子
                $parts = explode('_', $code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                $possibleCodes = array('红桃顺子', '黑桃顺子', '梅花顺子', '方块顺子');
                foreach ($parts as $v) {
                    if (!in_array($v, $possibleCodes)) {
                        return false;
                    }
                }

                //算注数
                return count($parts);

                break;
            case 'PKBZ':   //豹子 AAA_222_TTT_JJJ_QQQ
                if (!preg_match('`^(AAA|222|333|444|555|666|777|888|999|TTT|JJJ|QQQ|KKK)(_(AAA|222|333|444|555|666|777|888|999|TTT|JJJ|QQQ|KKK))*$`U', $code)) {
                    return false;
                }
                $parts = explode('_', $code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数
                return count($parts);

                break;
            case 'PKDZ':   //对子 AA_22_TT_JJ_QQ
                if (!preg_match('`^(AA|22|33|44|55|66|77|88|99|TT|JJ|QQ|KK)(_(AA|22|33|44|55|66|77|88|99|TT|JJ|QQ|KK))*$`U', $code)) {
                    return false;
                }
                $parts = explode('_', $code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                //算注数
                return count($parts);

                break;
            case 'PKBX':   //包选 同花包选_顺子包选_同花顺包选_豹子包选_对子包选
                $parts = explode('_', $code);
                //号码不得重复
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }
                $possibleCodes = array('同花包选', '顺子包选', '同花顺包选', '豹子包选', '对子包选');
                foreach ($parts as $v) {
                    if (!in_array($v, $possibleCodes)) {
                        return false;
                    }
                }

                //算注数
                return count($parts);

                break;
            case 'PKRX1':   //扑克 任选一
                if (!preg_match('`^([ATJQK|2-9])(_[ATJQK|2-9])*$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                if (count($parts) != count(array_unique($parts))) {
                    return false;
                }

                return count($parts);

                break;
            case 'PKRX2':   //扑克 任选二
                if (!preg_match('`^([ATJQK|2-9])(_[ATJQK|2-9]){1,}$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                $codeNum = count($parts);
                if ($codeNum != count(array_unique($parts))) {
                    return false;
                }

                return $codeNum * ($codeNum - 1) / 2;

                break;
            case 'PKRX3':   //扑克 任选三
                if (!preg_match('`^([ATJQK|2-9])(_[ATJQK|2-9]){2,}$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                $codeNum = count($parts);
                if ($codeNum != count(array_unique($parts))) {
                    return false;
                }

                return $codeNum * ($codeNum - 1) * ($codeNum - 2) / 6;

                break;
            case 'PKRX4':   //扑克 任选四
                if (!preg_match('`^([ATJQK|2-9])(_[ATJQK|2-9]){3,}$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                $codeNum = count($parts);
                if ($codeNum != count(array_unique($parts))) {
                    return false;
                }
                return $codeNum * ($codeNum - 1) * ($codeNum - 2) * ($codeNum - 3) / 24;

                break;
            case 'PKRX5':   //扑克 任选五
                if (!preg_match('`^([ATJQK|2-9])(_[ATJQK|2-9]){4,}$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                $codeNum = count($parts);
                if ($codeNum != count(array_unique($parts))) {
                    return false;
                }
                return $codeNum * ($codeNum - 1) * ($codeNum - 2) * ($codeNum - 3) * ($codeNum - 4) / 120;

                break;
            case 'PKRX6':   //扑克 任选六
                if (!preg_match('`^([ATJQK|2-9])(_[ATJQK|2-9]){5,}$`Ui', $code)) {
                    return false;
                }
                //号码不得重复
                $parts = explode('_', $code);
                $codeNum = count($parts);
                if ($codeNum != count(array_unique($parts))) {
                    return false;
                }
                return $codeNum * ($codeNum - 1) * ($codeNum - 2) * ($codeNum - 3) * ($codeNum - 4) * ($codeNum - 5) / 720;

                break;

            //pk10
            case 'PKQYZX':   //扑克 任选六

                $parts = explode('_', $code);
                $codeNum = count($parts);
                if ($codeNum != count(array_unique($parts))) {
                    return false;
                }
                foreach ($parts as $part) {
                    if (!in_array($part, self::$PK10NUMS)) {
                        return false;
                    }
                }

                return $codeNum;

                break;

            case 'PKQYZX':
            case 'PKQELX':
            case 'PKQSLX':
            case 'PKQ4LX':
            case 'PKQ5LX':
            case 'PKQ6LX':
            case 'PKQ7LX':
            case 'PKQ8LX':
            case 'PKQ9LX':
            case 'PKQ10LX':
                //  C($array, $base, $delimiter = '')

                $parts = explode(',', $code);
                if (count($parts) != count($method['field_def'])) {
                    return false;
                }

                $tmp = array();
                foreach ($parts as $k => $v) {
                    if (empty(trim($v))) {
                        return false;
                    }
                    //号码不得重复
                    $tmp[$k] = explode('_', $v);
                    if (count($tmp[$k]) != count(array_unique($tmp[$k]))) {
                        return false;
                    }
                    foreach ($tmp[$k] as $vv) {

                        if (!in_array($vv, self::$PK10NUMS)) {
                            return false;
                        }
                    }
                }

                return self::CC($tmp);
                break;

            case 'DM_JSHZ':
            case 'DM_JSETFX':
            case 'DM_JSSTTX':
            case 'DM_JSSTDX':
            case 'DM_KSXT':
            case 'DM_JSEBT':
            case 'DM_KSRXY':

                if (!in_array($code, self::$KSSBNUMS[$method['name']])) {
                    return false;
                }


                return 1;
                break;

            case 'DM_QXQWZX':
            case 'DM_QXBWZX':
            case 'DM_QXSWZX':
            case 'DM_QXGWZX':
            case 'DM_QXQ5ZX':
            case 'DM_QXQ6ZX':
            case 'DM_QXQ7ZX':
            case 'DM_QXYZX'://0,0,0,0
            case 'DM_QXSIZHWS':

                /**
                 * in_array 切记数组不使用数字类型，否则匹配的时候会化为  数字来比较
                 */
                if (!in_array($code, array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'))) {
                    return false;
                }
                return 1;
                break;

            case 'DM_QXEDW'://0,2,-,-
                $tmpcodes = explode(',', $code);
                if (strlen($code) != 7 || count($tmpcodes) != 4) {
                    return false;
                }
                $num = 0;
                foreach ($tmpcodes as $tmpcode) {
                    if (!in_array($tmpcode, array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'))) {
                        return false;
                    }
                    if ($tmpcode == '-') {
                        $num++;
                    }
                }
                if ($num != 2) {
                    return false;
                }

                return 1;
                break;

            case 'DM_QXSDW'://0,0,-,0
                $tmpcodes = explode(',', $code);
                if (strlen($code) != 7 || count($tmpcodes) != 4) {
                    return false;
                }
                $num = 0;
                foreach ($tmpcodes as $tmpcode) {
                    if (!in_array($tmpcode, array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'))) {
                        return false;
                    }
                    if ($tmpcode == '-') {
                        $num++;
                    }
                }
                if ($num != 1) {
                    return false;
                }

                return 1;
                break;

            case 'DM_QXSIDW'://0,0,0,0
                $tmpcodes = explode(',', $code);
                if (strlen($code) != 7 || count($tmpcodes) != 4) {
                    return false;
                }
                foreach ($tmpcodes as $tmpcode) {
                    if (!in_array($tmpcode, array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'))) {
                        return false;
                    }
                }
                return 1;
                break;


            case 'DM_QXEZX'://0,0,0,0

                if (!preg_match('`^[\d]{2}$`', $code)) {
                    return false;
                }
                return 1;
                break;

            case 'DM_QXSZX'://0,0,0,0
                if (!preg_match('`^[\d]{3}$`', $code)) {
                    return false;
                }
                return 1;
                break;


            case 'DM_QXSIZX'://0,0,0,0
                if (!preg_match('`^[\d]{4}$`', $code)) {
                    return false;
                }
                return 1;
                break;

            case 'DM_QXSIZX'://0,0,0,0
                if (!preg_match('`^[\d]{4}$`', $code)) {
                    return false;
                }
                return 1;
                break;
            case 'DM_QXSIZH'://0,0,0,0
                if (!isset(self::$DM_QXSIZH[$code])) {
                    return false;
                }
                return 1;
                break;

            case 'DM_QXEZH'://0,0,0,0
                $codeNums = explode('_', $code);
                $posStr = $codeNums[0];
                $numStr = $codeNums[1];
                if (!preg_match('`^[千百十个]{2}$`ui', $posStr)) {
                    return false;
                }

                if (substr_count($posStr, '千') > 1 || substr_count($posStr, '百') > 1 || substr_count($posStr, '十') > 1 || substr_count($posStr, '个') > 1) {
                    return false;
                }
                if (!isset(self::$DM_QXEZH[$numStr])) {
                    return false;
                }
                return 1;
                break;

            case 'DM_QXEZHWS':
                $codeNums = explode('_', $code);
                $posStr = $codeNums[0];
                $numStr = $codeNums[1];
                if (!preg_match('`^[千百十个]{2}$`ui', $posStr)) {
                    return false;
                }

                if (substr_count($posStr, '千') > 1 || substr_count($posStr, '百') > 1 || substr_count($posStr, '十') > 1 || substr_count($posStr, '个') > 1) {
                    return false;
                }

                if (!in_array($numStr, array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'))) {
                    return false;
                }


                return 1;
                break;

            case 'DM_QXQWSM':
            case 'DM_QXBWSM':
            case 'DM_QXSWSM':
            case 'DM_QXGWSM':
            case 'DM_QXQ5SM':
            case 'DM_QXQ6SM':
            case 'DM_QXQ7SM':
            case 'DM_QXQBHWSSM':
            case 'DM_QXQSHWSSM':
            case 'DM_QXQGHWSSM':
            case 'DM_QXBSHWSSM':
            case 'DM_QXBGHWSSM':
            case 'DM_QXSGHWSSM':
                $codesAllow = array('大', '小', '单', '双', '质', '合');
                if (!in_array($code, $codesAllow)) {
                    return false;
                }
                return 1;

                break;


            case 'DM_QXZHSM':
                $codesAllow = array('大', '小', '单', '双', '尾大', '尾小');
                if (!in_array($code, $codesAllow)) {
                    return false;
                }
                return 1;
                break;
            case 'DM_QXQBHSM':
            case 'DM_QXQSHSM':
            case 'DM_QXQGHSM':
            case 'DM_QXBSHSM':
            case 'DM_QXBGHSM':
            case 'DM_QXSGHSM':
                $codesAllow = array('大', '小', '单', '双');
                if (!in_array($code, $codesAllow)) {
                    return false;
                }
                return 1;
                break;
            case 'DM_QXLHH':

                if (preg_match_all('`^[龙虎和]{1}(\d{1})_(\d{1})$`ui', $code, $matches) !== 1) {
                    return false;
                }

                if (!$matches[0][0] || !$matches[1][0] || !$matches[2][0] || $matches[1][0] >= $matches[2][0] || $matches[1][0] < 1 || $matches[1][0] > 6 || $matches[2][0] < 2 || $matches[2][0] > 7) {
                    return false;
                }
                return 1;
                break;
            default:
                throw new Exception('未知的玩法', 1201);
                break;
        }

        return true;
    }

    /**
     * 得到展开式 不通用 仅支持2，3，5 SD11Y及类似适用
     * @param array $nums 原数组 如array('01_02_03','02_04','01_05')
     * @return array $result 按排列展开后的数组 不含重复数字
     * Array
    (
    [0] => 01 02 05
    [1] => 01 04 05
    [2] => 02 04 01
    [3] => 02 04 05
    [4] => 03 02 01
    [5] => 03 02 05
    [6] => 03 04 01
    [7] => 03 04 05
    )
     */
    static public function expandLotto($nums) {
        $result = array();
        $tmpNums = array();
        foreach ($nums as $v) {
            $tmp = explode('_', $v);
            sort($tmp);
            $tmpNums[] = $tmp;
        }

        switch (count($nums)) {
            case 2:
                for ($i = 0; $i < count($tmpNums[0]); $i++) {
                    for ($j = 0; $j < count($tmpNums[1]); $j++) {
                        $result[] = $tmpNums[0][$i] . ' ' . $tmpNums[1][$j];
                    }
                }
                break;
            case 3:
                for ($i = 0; $i < count($tmpNums[0]); $i++) {
                    for ($j = 0; $j < count($tmpNums[1]); $j++) {
                        for ($k = 0; $k < count($tmpNums[2]); $k++) {
                            $result[] = $tmpNums[0][$i] . ' ' . $tmpNums[1][$j] . ' ' . $tmpNums[2][$k];
                        }
                    }
                }
                break;
            case 5:
                for ($i = 0; $i < count($tmpNums[0]); $i++) {
                    for ($j = 0; $j < count($tmpNums[1]); $j++) {
                        for ($k = 0; $k < count($tmpNums[2]); $k++) {
                            for ($l = 0; $l < count($tmpNums[3]); $l++) {
                                for ($m = 0; $m < count($tmpNums[4]); $m++) {
                                    $result[] = $tmpNums[0][$i] . ' ' . $tmpNums[1][$j] . ' ' . $tmpNums[2][$k] . ' ' . $tmpNums[2][$l] . ' ' . $tmpNums[2][$m];
                                }
                            }
                        }
                    }
                }
                break;
            default:
                throw new Exception('non-supported permutation');
                break;
        }

        //去除重复的
        foreach ($result as $k => $v) {
            $parts = explode(' ', $v);
            if (count(array_unique($parts)) != count($parts)) {
                unset($result[$k]);
            }
        }

        return array_values($result);
    }

    /**
     * 计算阶乘
     * @param integer $n
     * @return integer
     */
    static public function factorial($n) {
        if ($n == 1) {
            return 1;
        } else {
            return $n * self::factorial($n - 1);
        }
    }
    static public function getNumRxPos($needed, $posStr) {

        if (!preg_match('`^[万千百十个]{1,}$`ui', $posStr)) {
            return 0;
        }
        $posLen = strlen($posStr) / 3; //utf字符
        if ($posLen < $needed) {

            return 0;
        }
        //检查位置重复
        if (substr_count($posStr, '万') > 1 || substr_count($posStr, '千') > 1 || substr_count($posStr, '百') > 1 || substr_count($posStr, '十') > 1 || substr_count($posStr, '个') > 1) {
            return 0;
        }

        $zsNum = 1;
        for ($i = $posLen; $i > ($posLen - $needed); $i--) {
            $zsNum = $zsNum * $i;
        }
        $zsNum = $zsNum / self::factorial($needed);

        $zsNum = $zsNum > 0 ? $zsNum : 0;
        return $zsNum;
    }
    /**
     * 待完成 通用方法：任意的n,m得到组合结果 n>m 如C(array('a','b','c','d','e'),3)
     * * 1.初始化一个字符串：11100;--------1的个数表示需要选出的组合
     * 2.将1依次向后移动造成不同的01字符串，构成不同的组合，1全部移动到最后面，移动完成：00111.
     * 3.移动方法：每次遇到第一个10字符串时，将其变成01,在此子字符串前面的字符串进行倒序排列,后面的不变：形成一个不同的组合.
     *            如：11100->11010->10110->01110->11001->10101->01101->10011->01011->00111
     *            一共形成十个不同的组合:每一个01字符串对应一个组合---如11100对应组合01 02 03;01101对应组合02 03 05
     *
     * @param array $array 原数组 如array('1','2','3')
     * @param integer $base <= 数组长度 如2
     * @param string $delimiter 分隔符，默认无
     * @return array $result 按组合展开后的数组array('12','13','23')
     */
    static public function C($array, $base, $delimiter = '') {
        if (!is_array($array) || count($array) < $base) {
            return array();
        } elseif (count($array) == $base) {   //相同只能一种可能，直接输出
            return array(implode($delimiter, $array));
        }

        if ($base == 1) {
            return $array;
        }

        $result = $resultIndex = array();
        $initStr = $teminalStr = '';
        for ($i = 0; $i < $base; $i++) {
            $teminalStr .= '1';
        }
        $initStr = $teminalStr;
        for ($i = $base; $i < count($array); $i++) {
            $initStr .= '0';
        }
        $resultIndex[] = $initStr;

        while (substr($initStr, -$base) != $teminalStr) {
            $parts = explode('10', $initStr, 2);
            $initStr = self::strOrder($parts[0], 'DESC') . '01' . $parts[1];
            $resultIndex[] = $initStr;
        }

        //替换转成对应元素
        foreach ($resultIndex as $v) {
            $tmp = '';
            for ($i = 0; $i < count($array); $i++) {
                if ($v{$i} == '1') {
                    $tmp .= $array[$i] . $delimiter;
                }
            }
            $result[] = trim($tmp, $delimiter);
        }

        return $result;
    }

    //字符串排序
    static function strOrder($str = '', $orderBy = 'ASC') {
        if ($str == '' || !isset($str{1})) {
            return $str;
        }
        $parts = str_split($str);
        if ($orderBy == 'DESC') {
            rsort($parts);
        } else {
            sort($parts);
        }
        return implode('', $parts);
    }
    /**
     * 计算二维数组 每组取出一个数字（数字不重复）的组合总量
     * @param type $CombinList
     * @return int
     */
    static public function CC($CombinList, $returnOnlyNumber = true) {

        /* 计算C(a,1) * C(b, 1) * ... * C(n, 1)的值 */


        $comKeys = array_keys($CombinList);
        $lastKey = array_pop($comKeys);
        $countNum = 0;
        $CombineCount = 1;
        foreach ($CombinList as $Key => $Value) {
            $CombineCount *= count($Value);
        }
        $RepeatTime = $CombineCount;
        $Result = array();
        foreach ($CombinList as $ClassNo => $StudentList) {
            // $StudentList中的元素在拆分成组合后纵向出现的最大重复次数
            $RepeatTime = $RepeatTime / count($StudentList);
            $StartPosition = 1;
            // 开始对每个班级的学生进行循环
            foreach ($StudentList as $Student) {
                $TempStartPosition = $StartPosition;
                $SpaceCount = $CombineCount / count($StudentList) / $RepeatTime;
                for ($J = 1; $J <= $SpaceCount; $J ++) {
                    for ($I = 0; $I < $RepeatTime; $I ++) {
                        if (isset($Result[$TempStartPosition + $I]) && $Result[$TempStartPosition + $I] == -1) {
                            continue;
                        }
                        if (isset($Result[$TempStartPosition + $I]) && is_array($Result[$TempStartPosition + $I]) && in_array($Student, $Result[$TempStartPosition + $I])) {
                            $Result[$TempStartPosition + $I] = -1;
                            continue;
                        }
                        if (!isset($Result[$TempStartPosition + $I])) {
                            $Result[$TempStartPosition + $I] = array();
                        }


                        $Result[$TempStartPosition + $I][$ClassNo] = $Student;
                        if ($lastKey == $ClassNo) {
                            $countNum++;
                        }
                    }
                    $TempStartPosition += $RepeatTime * count($StudentList);
                }
                $StartPosition += $RepeatTime;
            }
        }
        if ($returnOnlyNumber) {

            return $countNum;
        } else {
            $cleanRet = array();
            foreach ($Result as $Result) {
                if ($Result != -1 && is_array($Result) && $Result) {
                    $cleanRet[] = $Result;
                }
            }

            return $cleanRet;
        }
    }



}