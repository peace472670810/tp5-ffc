<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//统一输入格式
if(!function_exists('data_encode')){
    function data_encode($data=''){
        return  json_encode([
            'data'=>$data
        ]);
    }
}
if(!function_exists('getlocationByIp')){
    function getlocationByIp($ip){
        $ipModel = new \vendor\ip();
        return $ipModel->loc($ip,3);
    }
}
//输入格式解码
if(!function_exists('data_decode')){
    function data_decode($data = ''){
        $data =  (Object)json_decode($data);
        return (array)$data->data;
    }
}
//统一输出格式
if(!function_exists('put_encode')){
    function put_encode($data='',$code='',$message=''){
        return json_encode([
            'error_code' =>$code,
            'data' => $data,
            'message'=>$message
        ]);
    }
}
if(!function_exists('floattostr')){
    function floattostr( $val )
    {
        preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
        return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
    }
}
//中转层调用加载
if(!function_exists('forwarding')){

    /**@param $forwarding  转发层类名
     * @param $modelName  类名
     * @param $mothod 类方法
     * @param $data  传入的数据
     * @return json
     */
    function forwarding($forwarding='',$modelName='',$mothod='',$data=''){
        $forwarding = '\app\Service\forwarding\\'.$forwarding;
        if(!class_exists($forwarding)){
            return  put_encode('','1000000',$forwarding.'不存在');
        }

        $result = new $forwarding($modelName,$mothod,$data);
        return $result->put_data();
    }
}
if(!function_exists('wrapUsername')){
    /**
     * @param $username 外接网站的用户名
     * @param $customerId
     * @param $siteId
     * @param bool $onlyWarper
     * @return string 平台用户名
     */
    function wrapUsername($siteId, $username, $onlyWarper = false){
        return  $siteId . ($onlyWarper ? '' : '_' . $username);
    }
}
if(!function_exists('unwrapUsername')){
    /**
     *
     * @param $username平台用户名
     * @return string外接网站的用户名
     */
    function unwrapUsername($username)
    {
        preg_match("/^\d+_(\w+)/", $username, $matches);//888888_kkkk2
        if(empty($matches)){
            return '';
        }
        return $matches[1];
    }

}
if(!function_exists('mode10Issues')){
    /**
     * 奖期取模
     */
    function mode10Issues($str){
        $len = strlen($str);
        if($len<=6){
            return intval($str)%10;
        }else{
            $str = '1'.substr($str,-6);
            return intval($str)%10;
        }
    }
}
if(!function_exists('isOnline')){
    /**
     * 判断用户是否在线
     * @param $username
     */
    function isOnline($username){
        $res =json_decode(forwarding('UserForwarding','\app\Service\users\business\frontUsers','isOnline',['username'=>$username]),true);
        if($res['data']){
            return '<span class="label  label-success radius"><b>在线</b></span>';
        }else{
            return '<span class="label  label-error radius"><b>离线</b></span>';
        }
    }
}
if(!function_exists('addLogs')){
    /**
     *用户日志
     * @param $arr
     * @param int $type  1 用户登录日志 2 管理员登录日志
     */
    function addLogs($arr,$type=1){
        if($type == 1){
            $res = forwarding('UserForwarding','\app\Service\usersLogs\business\userlogs','addUserLogs',$arr);
        }else{
            $res = forwarding('UserForwarding','\app\Service\usersLogs\business\logs','addLogs',$arr);
        }
    }
}
//按规则生成唯一订单编号 P表示order
if(!function_exists('orderWrapId')){
//    function orderWrapId($package_id, $issue, $lottery_id) {
//        //CQ30714120141716P
//        $str = '';
//        switch ($lottery_id) {
//            case '2':
//                $str = 'CQ';
//                break;
//            case '26':
//                $str = 'SD';
//                break;
//            case '3':
//                $str = 'HLJ';
//                break;
//            case '8':
//                $str = 'XJ';
//                break;
//            case '5':
//                $str = 'CQ';
//                break;
//            case '27':
//                $str = 'JX';
//                break;
//            case '24':
//                $str = 'GD';
//                break;
//            case '14':
//                $str = 'TJ';
//                break;
//            case '28':
//                $str = '3D';
//                break;
//            case '29':
//                $str = 'P3';
//                break;
//            case '11':
//                $str = 'FF';
//                break;
//            case '9':
//                $str = 'JS';
//                break;
//            case '13':
//                $str = 'KF';
//                break;
//            case '14':
//                $str = 'PK';
//                break;
//            case '15':
//                $str = 'JXS';
//                break;
//            case '6':
//                $str = 'P10';
//                break;
//            case '30':
//                $str = 'HBKS';
//                break;
//        }
//        $str .= 'S'.$lottery_id.'I'.substr(str_replace('-', '', $issue), 4).'P';
//        $str .= str_pad($package_id, 12, '0', STR_PAD_LEFT);
//        $result = "{$str}P";
//        return $result;
//    }
    function orderWrapId($order_id,$issue='',$lottery_id=''){
//        $order_id = $order_id/1000000000000;
        return $order_id;
    }
}
if(!function_exists('unOrderWrapId')){
    //CQ034000000003381P
//    function unOrderWrapId($sn){
//        preg_match('`^\w+P(\d+)P$`Ui', $sn, $match);
//        return  empty($match[1])?'':$match[1];
//    }
    function unOrderWrapId($sn){
        return $sn;
    }
}

if(!function_exists('dcEncrypt')){
    /**
     * 加密签名函数
     * 需要配置环境支持iconv，否则中文参数不能正常处理
     * @param type $data string
     * @param type $key string
     * @return type string
     */
    function dcEncrypt($data, $key) {
        $key = iconv("GB2312", "UTF-8", $key);
        $data = iconv("GB2312", "UTF-8", $data);
        $b = 64; // byte length for md5
        if (strlen($key) > $b) {
            $key = pack("H*", md5($key));
        }
        $key = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;
        return md5($k_opad . pack("H*", md5($k_ipad . $data)));
    }
}

if(!function_exists('authcode')){
    /**
     *
     * @param String $string 原文
     * @param String $operation ENCODE或者DECODE，前者表示加密，后者表示解密
     * @param String $key   私钥
     * @param int $expiry   到期时间，单位秒，如1800表示半小时后到期，即使正确的密钥也无法解开
     * @return String 返回加密或者解密后的字符串
     */
    function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;
        $key = md5($key ? $key : 'US_KEY');
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ( $operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length) ) : ''; // '123456789' => microtime()

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ( $j + $box[$i] + $rndkey[$i] ) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ( $a + 1 ) % 256;
            $j = ( $j + $box[$a] ) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ( $box[( $box[$a] + $box[$j] ) % 256] ));
        }

        if ($operation == 'DECODE') {
            if (( substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0 ) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . rtrim(base64_encode($result), '=');
        }
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function get_client_ip($type = 0, $adv = false) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}


/**
 * 安全过滤类-过滤javascript,css,iframes,object等不安全参数 过滤级别高
 *  Controller中使用方法：$this->controller->fliter_script($value)
 * @param  string $value 需要过滤的值
 * @return string
 */
function fliter_script($value) {
    $value = preg_replace("/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/i","&111n\\2",$value);
    $value = preg_replace("/(.*?)<\/script>/si","",$value);
    $value = preg_replace("/(.*?)<\/iframe>/si","",$value);
    $value = preg_replace ("//iesU", '', $value);
    return $value;
}
/**
 * 安全过滤类-过滤HTML标签
 *  Controller中使用方法：$this->controller->fliter_html($value)
 * @param  string $value 需要过滤的值
 * @return string
 */
function fliter_html($value) {
    if (function_exists('htmlspecialchars')) return htmlspecialchars($value);
    return str_replace(array("&", '"', "'", "<", ">"), array("&", "\"", "'", "<", ">"), $value);
}
/**
 * 安全过滤类-对进入的数据加下划线 防止SQL注入
 *  Controller中使用方法：$this->controller->fliter_sql($value)
 * @param  string $value 需要过滤的值
 * @return string
 */
function fliter_sql($value) {
    $sql = array("select", 'insert', "update", "delete", "\'", "\/\*",
        "\.\.\/", "\.\/", "union", "into", "load_file", "outfile");
    $sql_re = array("","","","","","","","","","","","");
    return str_replace($sql, $sql_re, $value);
}
/**
 * 安全过滤类-通用数据过滤
 *  Controller中使用方法：$this->controller->fliter_escape($value)
 * @param string $value 需要过滤的变量
 * @return string|array
 */
function fliter_escape($value) {
    if (is_array($value)) {
        foreach ($value as $k => $v) {
            $value[$k] = fliter_str($v);
        }
    } else {
        $value = fliter_str($value);
    }
    return $value;
}

/**
 * 安全过滤类-字符串过滤 过滤特殊有危害字符
 *  Controller中使用方法：$this->controller->fliter_str($value)
 * @param  string $value 需要过滤的值
 * @return string
 */
function fliter_str($value) {
    $badstr = array("\0", "%00", "\r", '&', ' ', '"', "'", "<", ">", "   ", "%3C", "%3E");
    $newstr = array('', '', '', '&', ' ', '"', "'", "<", ">", "   ", "<", ">");
    $value  = str_replace($badstr, $newstr, $value);
    $value  = preg_replace('/&((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $value);
    return $value;
}

function substrb($string,$shu){
    $len=strlen($string);
    if($len>$shu){
        $value=mb_substr($string,0,$shu);
        return  $value.'<span class="c-red">......</span>';
    }
    return  $string;
}

/**
 * 去除标签
 * @param $string
 * @param $shu
 * @return string
 */
function fliter_substrb($string,$shu){
    $str=strip_tags($string,"<img><p><b><b><br><i><strong><em><span><h>");
    $len=strlen($str);
    if($len>$shu){
        $value=mb_substr($str,0,$shu);
        return  $value.'<span class="c-red"> <b>......</b></span>';
    }
    return  $str;
}

/**
 * 去除标签 前台公告用
 * @param $string
 * @param $shu
 * @return string
 */
function pc_fliter_substrb($string){
    $str=strip_tags($string);
    $len=strlen($str);
    if($len>400){
        $value=mb_substr($str,0,400);
        return  $value.'......';
    }
    return  $str;
}
//统计数字太大时出现科学计算法，交付报表。
function NumToStr($num){
    if (stripos($num,'e')===false) return   bcdiv($num, 1000000,4);;
    $num = trim(preg_replace('/[=\'"]/','',$num,1),'"');
    $result = "";
    while ($num > 0){
        $v = $num - floor($num / 10)*10;
        $num = floor($num / 10);
        $result   =   $v . $result;
    }
    return   bcdiv($result, 1000000,4);
}

//统计数字太大时出现科学计算法，交付报表,盈率。
function YingToStr($num,$wins){
    if (stripos($num,'e')===false){
        $result = $num ;
    }else{
        $num = trim(preg_replace('/[=\'"]/','',$num,1),'"');
        $result = "";
        while ($num > 0){
            $v = $num - floor($num / 10)*10;
            $num = floor($num / 10);
            $result   =   $v . $result;
        }
    }

    if (stripos($wins,'e')===false){
        $data = $wins ;
    }else{
        $wins = trim(preg_replace('/[=\'"]/','',$wins,1),'"');
        $data = "";
        while ($wins > 0){
            $v = $wins - floor($wins / 10)*10;
            $wins = floor($wins / 10);
            $data   =   $v . $data;
        }
    }

    $str=bcsub($result, $data,4);
    return   bcdiv($str, $result,6);
}