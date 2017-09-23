
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>gfc彩票登录2017-9-18版本</title>
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
$private_key = '-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALvDe77nbuXSb+Rv
oBPjrPEstCtCk9gOzjDCg1PfYcB/AwLZHWaeOMFxHvkzlckb8LAQOCy0o5F6WyzI
NaWnOQyFWh/hORTvRSBEA2e6cZYxyVWMZUgJy58Izl0yoFewF2/Af+SJrmb/tdI+
1JRu+1QxMe7NHoGp2uY5LnCpwNn1AgMBAAECgYBGeG74TnpDzYBrVy3YaSoedm3E
kr9UZvIiQM7zarKQgdsKdZxgSF/60k8Srra3/UGPgvbiaIW/cxHHM/lWi/WPxVy9
jKalDUEKIdBiQAquR2alzEfLxvtGN/oiqf8bo2CzVuY0bGaWMaYBkcMp3TO8eJ7X
m94KOeDS79k5ItXG/QJBAO2xdLhKXXd6knyTcRgr2qPkRHvCjWuTXiRdI/tv4E2u
a4KRY7rNeguQQnmG7/jIlEGNJDJVLg/+Uh9lKeICTlMCQQDKOZOyWs3zJKkJ3WPb
6U7qxkdE+F0QnG0cw/VoVlK+dqSukb7nriPPhQpNyH/qjQe5p8QCVkcvdmLyvrkh
Pd2XAkEAyIwEPgXIjKlndSJ1tn4x0DwlqAIDjjNdp/LKDDhdmU1DuntvGMqLYbxK
yfyW9mJN7GzokGscHTRoF8MkLmPhrwJBALyMnJJSKe5HQzjIbCAR05wBDVhYPeWM
BAwrBXin6/RcCMYfbCD187u8btQBWoslvYszygTnzu2I808j1tcQqLcCQB4Rd2jt
AveNzk3hlrI+n7brJKVp7ENGq91qCxZRCXyKqsz+vNqA8nbu8166YD+yuAVVZ0Xn
edeTKZWCUDdjEUc=
-----END PRIVATE KEY-----';
$public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC7w3u+527l0m/kb6AT46zxLLQr
QpPYDs4wwoNT32HAfwMC2R1mnjjBcR75M5XJG/CwEDgstKORelssyDWlpzkMhVof
4TkU70UgRANnunGWMclVjGVICcufCM5dMqBXsBdvwH/kia5m/7XSPtSUbvtUMTHu
zR6BqdrmOS5wqcDZ9QIDAQAB
-----END PUBLIC KEY-----';

//echo $private_key;
$pi_key = openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的
////私钥加密
//function private_encrypt($data,$pi_key){
//    //加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
//    openssl_private_encrypt($data,$encrypted,$pi_key);
//    $encrypted = base64_encode($encrypted);
//    return $encrypted;
//}
////公钥解密
//function public_decrypt($encrypted,$pu_key){
//    openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来
//    return  $decrypted;
//}


//公钥加密
function public_encrypt($data,$pu_key){
    openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密
    $encrypted = base64_encode($encrypted);
    return  $encrypted;
}
//私钥解密
function private_decrypt($encrypted,$pi_key){
    openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密
    return $decrypted;
}

//$list = [
//    'u'=>'jimm',
//    'si'=>'88888',//siteId
//    'ut'=>'azhu88341,1czhu12000,dz24hu0005',//userTree:当前用户层级关系 分公司_股东,总代,代理
//    'p'=>'b',//盘口
//    'it'=>'0',//0表示非试玩账号，1表示试玩账号
//    'ts'=>time(),//token
//];
//$list = [
//    'u'=>'gfcceshi71',
//    'si'=>'88888',//siteId
//    'ut'=>'azhu000_bzhu000,czhu000,dzhu000',//userTree:当前用户层级关系 分公司_股东,总代,代理
//    'p'=>'b',//盘口
//    'it'=>'0',//0表示非试玩账号，1表示试玩账号
//    'ts'=>time(),//token
//];
//$list = [
//    'u'=>'jingdian3001',
//    'si'=>'88888',//siteId
//    'ut'=>'azhu000_bzhu000,czhu000,dzhu000',//userTree:当前用户层级关系 分公司_股东,总代,代理
//    'p'=>'b',//盘口
//    'it'=>'0',//0表示非试玩账号，1表示试玩账号
//    'ts'=>time(),//token
//];
//$list = [
//    'u'=>'88888_shiwan02',
//    'si'=>'88888',//siteId
//    'ut'=>'azhu333_bzhu333,czhu333,dzhu333',//userTree:当前用户层级关系 分公司_股东,总代,代理
//    'p'=>'b',//盘口
//    'it'=>'1',//0表示非试玩账号，1表示试玩账号
//    'ts'=>time(),//token
//];
//(u+si+ut+p+it+ts+内部测试私钥内部测试私钥)
//function getSha1($u,$si,$ut,$p,$it,$ts){
//    $key = sha1($u.$si.$ut.$p.$it.$ts.'llFG8LMBHHGDuaEmqJ12a88Jlm9pD8p4FF5umFE4C7JHK21u6FuGB7qaq9GGh2v837FqNHaFDAN4FBph976g5qGa8NEDMuNE4al3H8Mp9EAL65hA2hpaEh9H');
//    return $key;
//}
//$sha = getSha1($list['u'],$list['si'],$list['ut'],$list['p'],$list['it'],$list['ts']);
//$str5 = json_encode($list);
////'{"u":"feimember3","si":1,"ut":"ds_gdm013,zdm013,ddm013","p":"A","it":1,"ts":1493961651}'
////$str3 = '{"u":2,"pan":"a","lid":30,"ct":"p","c":"admin","ts":1500955381,"un":"kkkk0002","s":"120"}';
//$param1 = public_encrypt($str5,$pu_key);
//
//$deparam1 = private_decrypt($param1,$pi_key);//解密
/**
 *获取用户层级
 * @param $list
 * @param $public_key
 * @return string
 */
function getLoginKey($list,$public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC7w3u+527l0m/kb6AT46zxLLQr
QpPYDs4wwoNT32HAfwMC2R1mnjjBcR75M5XJG/CwEDgstKORelssyDWlpzkMhVof
4TkU70UgRANnunGWMclVjGVICcufCM5dMqBXsBdvwH/kia5m/7XSPtSUbvtUMTHu
zR6BqdrmOS5wqcDZ9QIDAQAB
-----END PUBLIC KEY-----'){
    $str5 = json_encode($list);
    $pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的
    $param1 = public_encrypt($str5,$pu_key);
    $key = sha1($list['u'].$list['si'].$list['ut'].$list['p'].$list['it'].$list['ts'].'llFG8LMBHHGDuaEmqJ12a88Jlm9pD8p4FF5umFE4C7JHK21u6FuGB7qaq9GGh2v837FqNHaFDAN4FBph976g5qGa8NEDMuNE4al3H8Mp9EAL65hA2hpaEh9H');
    return  ['param'=>$param1,'encrypt'=>$key];
}
//$loginKey =  getLoginKey($list);
$lotteryList = [
    '2' => '重庆时时彩',
    '26'=>'山东11选5',
    '8' => '新疆时时彩',
    '27'=>' 江西11选5',
    '24'=> '广东11选5',
    '14'=> '天津时时彩',
    '28'=> '福彩3D',
    '29'=> '排列三/五',
    '9' => '江苏快三',
    '30'=> '湖北快3',
    '6' => ' 北京赛车'
];
?>
<?php if(empty($_POST)){ ?>
    <div style=" width:100%; text-align:center; margin:20px auto auto; overflow:hidden;">
        <h2>这是api接口的php示例代码</h2>
    </div>
    <hr/>
    <style>
        .u-labler{
            width: 120px;
            margin-right: 10px;
            text-align: right;
            height:30px;
            line-height:30px;
        }
        select{
            height: 21px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
    <div style=" width:100%; text-align:center; margin:20px auto auto; overflow:hidden;">
        <h3>登录或者创建用户例子【默认是正确有金额的的用户登录账号】</h3>
        <!--//encrypt  SHA1加密 (dcUserType+odds+lid+clientType+dcCustomerId+dcToken+内部测试私钥)-->
        <!--param RSA加密-->
        <form action="" method="post">
            <label><span class="u-labler">&nbsp;&nbsp;&nbsp;分公司:</span><input type="text" name="siteId"  value="88888"/><span style="color: red">(必填)</span></label><br/>
            <label><span class="u-labler">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;股东:</span><input type="text" name="top3"  value="azhu000_bzhu000"/><span style="color: red">(必填)</span></label><br/>
            <label><span class="u-labler">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总代:</span><input type="text" name="top2"  value="czhu000"/><span style="color: red">(必填)</span></label><br/>
            <label><span class="u-labler">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;代理:</span><input type="text" name="top1"  value="dzhu000"/><span style="color: red">(必填)</span></label><br/>
            <label><span class="u-labler">会员名称:</span><input type="text" name="username"  value="jingdian3121"/></label><span style="color: red">(必填)</span><br/>
            <label><spanclass="u-labler">所选彩种:</span>
                <select name="lid"  >
                    <?php foreach ($lotteryList as $k=>$v){ ?>
                        <option value="<?php echo $k;?>"><?php echo $v; ?></option>
                    <?php }?>
                </select>
            </label>
<!--            <label><span class="u-labler">登录类型:</span>-->
<!--                <select name="logintype"  >-->
<!--                    <option value="0">正式会员</option>-->
<!--                    <option value="1">试玩会员</option>-->
<!--                </select>-->
<!--            </label>-->
            <label><span class="u-labler">登录端:</span>
                <select name="clientType"  >
                    <option value="pc">pc端（pc）</option>
                    <option value="wap">手机端（wap）</option>
                </select>
            </label>
            <label><span class="u-labler">盘口:</span>
                <select name="pankou"  >
                    <option value="a">A盘</option>
                    <option value="b">B盘</option>
                    <option value="c">C盘</option>
                    <option value="d">D盘</option>
                </select>
            </label><br/>
            <input type="submit" name="登录" value="登录"/>
        </form>
    </div>
    <hr/>
<?php }else{?>
    <?php
    if(empty($_POST['username']) ||empty($_POST['siteId']) ||empty($_POST['top3']) ||empty($_POST['top2']) ||empty($_POST['top1']) ){
        echo "<script>alert('必填不能为空!');</script>";
    }else{
        $list['u'] = $_POST['username'];
        $list['si'] = $_POST['siteId'];
        $list['ut'] = $_POST['top3'].','.$_POST['top2'].','.$_POST['top1'];
        $list['p'] = $_POST['pankou'];
        $list['it'] = 0;
        $list['ts'] = time();
        $post = getLoginKey($list);
        $post['lid'] =  $_POST['lid'];
        $post['clientType'] =  $_POST['clientType'];
        $url = 'http://pc.newgfc.com';
        echo "正在登录中.......................";
    ?>
        <form style="display: none" id="loginFrom" action="<?php echo $url;?>" method="post">
            <label>param:<input type="text" name="param" readonly value="<?php echo $post['param'];  ?>"/></label>
            <label>encrypt:<input type="text" name="encrypt" readonly value="<?php echo $post['encrypt']; ?>"/></label>
            <label>encrypt:<input type="text" name="encrypt" readonly value="<?php echo $post['encrypt']; ?>"/></label>
            <label>encrypt:<input type="text" name="clientType" readonly value="<?php echo $post['clientType']; ?>"/></label>
            <label>encrypt:<input type="text" name="lid" readonly value="<?php echo $post['lid']; ?>"/></label>
            <input type="submit" name="登录" value="登录"/>
        </form>
        <script type="text/javascript">
            var loginForm = document.getElementById("loginFrom");
            loginForm.submit();
        </script>
    <?php }?>
<?php }?>





