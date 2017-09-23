
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>gfc彩票登录2017-6-29版本</title>
</head>
<body>
<?php
/**
 * 步骤：
 * 1.所带参数
 *  商户名customer   token  请求时间   网站商户siteId  加密参数  用户名
 *
 *
 */
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
$key = "321FG8LMBHHGDuaEmqJ12a88Jlm9pD8p4FF5umFE4C7JHK21u6FuGB7qaq9GGh2v837FqNHaFDAN4FBph976g5qGa8NEDMuNE4al3H8Mp9EAL65hA2hpaEh9H";
define("PC_URL","http://10.10.197.5");
define('M_URL',"http://10.10.197.5");
define('dcCustomerSec',$key);
define('dcCustomerId','admin');
$dcToken = time();
/**
 * 登录的用户名
 */
$dcUsername = 'kkkk0002';
/**
 * 平台的用户所属的 网站id，客户自定义
 */
$dcSiteId = '120';//admin566889900
/**
 * 用户的级别树,方便分等级统计数据。 代理，总代理，股东，大股东，分公司
 * 为空的话默认3级分类（商户用户名->网站ID->用户名） 你可以通过添加中间级别来改变分类
 * 如：  parent1,parent2,parent3 那么用户的等级树就是：  商户用户名->parent1->parent2->parent3->网站ID->用户名
 */
$dcUserTree = 'shareholders,totalagent1,agent002';
/**
 * 平台的用户盘口，可选值：a,b c d。赔率依次降低。 默认a盘。
 */
$odds = 'a';
/**
 * 默认的客户端方式 p：pc端，m:手机端
 *
 */
$clientType = 'p';
/**
 * 默认皮肤，用户的默认皮肤.
 * 可选值： reb black blue green //值依次参考： 1 用户自定义 》2 dcSkin参数设置 》3 默认 black
 */
$dcSkin = 'black';
/**
 * 用户类型    2会员 3测试帐号
 */
$dcUserType = 2;  //is_test  pan
$params = "?dcUserType={$dcUserType}&odds={$odds}&lid=2&clientType={$clientType}&dcSkin={$dcSkin}&dcCustomerId=" . dcCustomerId . "&dcToken={$dcToken}&dcUsername={$dcUsername}&dcSiteId={$dcSiteId}&dcUserTree={$dcUserTree}";
/**
 * 验证加密 只需要按照顺序 dcCustomerId dcToken dcUsername dcSiteId
 */
$dcEncryptStr = dcEncrypt("dcCustomerId=" . dcCustomerId . "&dcToken={$dcToken}&dcUsername={$dcUsername}&dcSiteId={$dcSiteId}&dcUserTree=".$dcUserTree, dcCustomerSec);

$params.='&dcEncrypt=' . $dcEncryptStr;
/**
 * 最后的登录url
 *
 * (string user, string siteId, string userTree, string encrypt, string pan, string isTest, string loginIp, string r, string lid, string platformURL)
加密字符串 内容组成为:
SHA1加密 (u+si+ut+p+it+ts+内部测试私钥)
内部测试私钥:
llFG8LMBHHGDuaEmqJ12a88Jlm9pD8p4FF5umFE4C7JHK21u6FuGB7qaq9GGh2v837FqNHaFDAN4FBph976g5qGa8NEDMuNE4al3H8Mp9EAL65hA2hpaEh9H
 */
//$loginUrl =PC_URL.$params;
$loginUrl =M_URL.$params;
?>
<div style=" width:100%; text-align:center; margin:20px auto auto; overflow:hidden;">
    <h2>这是api接口的php示例代码</h2>
</div>
<hr/>

<div style=" width:100%; text-align:center; margin:20px auto auto; overflow:hidden;">
    <h3>登录或者创建用户例子</h3>
    <a href="<?php echo $loginUrl; ?>">点击登录ds彩票,如果用户第一次登录将会自动创建</a>
</div>
<hr/>
