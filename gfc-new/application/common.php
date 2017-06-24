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
//中转层调用加载
if(!function_exists('forwarding')){

    /**@param $forwarding  转发层类名
     * @param $modelName  类名
     * @param $mothod 类方法
     * @param $data  传入的数据
     * @return json
     */
    function forwarding($forwarding='',$modelName='',$mothod='',$data=''){
        $forwarding = '\app\Service\Forwarding\\'.$forwarding;
        if(!class_exists($forwarding)){
            return  data_encode('','1000000',$forwarding.'不存在');
        }
        $result = new $forwarding($modelName,$mothod,$data);
        return $result->put_data();
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
function fliter_substrb($string,$shu){
 $str=fliter_html($string);

   $len=strlen($str);
      if($len>$shu){
           $value=mb_substr($str,0,$shu);
          return  $value.'<span class="c-red">......</span>';
      }
      return  $str;

}
 //追号订单编码
function traceWrapid($trace_id, $issue, $lottery_id) {
//        //T130117001010028E
        switch ($lottery_id){
            case '1':
                $str = 'CQ';
                break;
            case '2':
                $str = 'SD';
                break;
            case '3':
                $str = 'HLJ';
                break;
            case '4':
                $str = 'XJ';
                break;
            case '5':
                $str = 'CQ';
                break;
            case '6':
                $str = 'JX';
                break;
            case '7':
                $str = 'GD';
                break;
            case '8':
                $str = 'TJ';
                break;
            case '9':
                $str = '3D';
                break;
            case '10':
                $str = 'P3';
                break;
            case '11':
                $str = 'FF';
                break;
            case '12':
                $str = 'JS';
                break;
            case '13':
                $str = 'KF';
                break;
            case '14':
                $str = 'PK';
                break;
            case '15':
                $str = 'JXS';
                break;
            case '16':
                $str = 'P10';
                break;

            case '17':
                $str = 'HBKS';
                break;
            case '18':
                $str = '5FC';
                break;
            
            case '19':
                $str = 'HN';
                break;

            default:
                throw new exception2("Unknown rules for lottery {$lottery_id}");
                break;
        }
        $str .= substr(str_replace('-', '', $issue), -8);
        $str .= str_pad($trace_id, 7, '0', STR_PAD_LEFT);
        $result = "{$str}T";
        return $result;
        //return 'T' . encode($trace_id) . 'E';
    }

