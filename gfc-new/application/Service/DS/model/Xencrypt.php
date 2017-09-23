<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/21
 * Time: 20:54
 * 常用对称加密算法类
AES/CBC/PKCS5Padding的加密解密方式
 */

namespace app\Service\DS\model;


class Xencrypt
{
    private $iv = "0102030405060708";//密钥偏移量IV，可自定义
    private $encryptKey = "12345678123456781234567812345678";//AESkey，可自定义

    //加密
    public function encrypt($encryptStr) {
        $localIV = $this->iv;
        $encryptKey = $this->encryptKey;

        //Open module
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, $localIV);

        //print "module = $module <br/>" ;

        mcrypt_generic_init($module, $encryptKey, $localIV);

        //Padding
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $pad = $block - (strlen($encryptStr) % $block); //Compute how many characters need to pad
        $encryptStr .= str_repeat(chr($pad), $pad); // After pad, the str length must be equal to block or its integer multiples

        //encrypt
        $encrypted = mcrypt_generic($module, $encryptStr);

        //Close
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);

        return base64_encode($encrypted);

    }

    //解密
    public function decrypt($encryptStr) {
        $localIV = $this->iv;
        $encryptKey = $this->encryptKey;

        //Open module
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, $localIV);

        //print "module = $module <br/>" ;

        mcrypt_generic_init($module, $encryptKey, $localIV);

        $encryptedData = base64_decode($encryptStr);
        $encryptedData = mdecrypt_generic($module, $encryptedData);

        return $encryptedData;
    }
}