<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/22
 * Time: 11:51
 * rsa加密 但有长度限制
 */

namespace app\Service\DS\model;


class Rsa
{
    /**
     * RSA私钥
     * 不能换换
     * @var string
     */
    public $private_key =  '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDDpaYdyhR3ctXyjIA8WIOY9fCFcbtb6Ivd7XKd3BAso+uJVJ+w
PBj2IJrvTef0JeL8mwdcQmhM+g8n4LrUD4TF6OKlqMKniORpD3R4i5Z4aJgiwF1m
eeXUAPN8NCkaJKw9+QSZX57fFa/cj466Pv9RioBRrDxzfMtvST5ZLK0FGwIDAQAB
AoGAPIqt9Nnrq2rlucCwjfv1/Qdd/m1LRQ2Y+nvX0/GdL7Mp171QDQEL2F4Ok67P
8EUpEHIIvQvvqqJWvkhUh/qlYu402cCB+pG2g6xwRBQNebbxhf8rItxCk+7Q2K43
nlkCOxGvpXIBKskiZsyctcx0TMGrFSrgY4GROK0HiRMaaEECQQDma1oGYkcoeH1w
ZC9DwE/8QCToCWe2FQ9UAbmrQl8PSbpFB8L/lF3Z2dJR2QDxqX/gWvg9CeIK2r52
+pFM6L6/AkEA2V4MpvmIn6AP8GikhIJ38c58rMnr41sEE8n6SnzwzN6TNJwahR7X
86qd5TOfiTGMt3pk+Pk6eKWHVo3T267spQJACrPJxqoh6/tMuD+vAlKYZHsGO9DU
BF0ODTTXTuESUT93a2Vk5UIa6dd4MV0G8jKRQfZ3uT4QRbjLR/NzdEMLOQJBAMo0
6YQzQdtspSc50UHLtRTmx6hdtuirdKGMFSBSFhgfPcWFKk6IINB1+aiMW27e/053
t5K9Fp3BLqNgEKOemFkCQChAhgc7j/bLYsMxtaxZBH8/AJ+8tMcAlJrBKirgfeV6
aDqcpCiu5rzCFhEc3f05TAOuy+JzZZzRdj0KukVF4v8=
-----END RSA PRIVATE KEY-----';
    /**
     * RSA公钥
     * @var string
     */
    public $public_key ='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDpaYdyhR3ctXyjIA8WIOY9fCF
cbtb6Ivd7XKd3BAso+uJVJ+wPBj2IJrvTef0JeL8mwdcQmhM+g8n4LrUD4TF6OKl
qMKniORpD3R4i5Z4aJgiwF1meeXUAPN8NCkaJKw9+QSZX57fFa/cj466Pv9RioBR
rDxzfMtvST5ZLK0FGwIDAQAB
-----END PUBLIC KEY-----';

    /**
     * 获取公钥返回资源id
     */
    public function getRSA_pubId(){
        $pu_key = openssl_pkey_get_public($this->public_key);//这个函数可用来判断公钥是否是可用的
        return $pu_key;
    }
    /**
     * 获取私钥返回资源id
     */
    public function getRSA_priId(){
        $pi_key = openssl_pkey_get_private($this->private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        return $pi_key;
    }
    /**
     * 公钥加密
     * @param $data
     * @param $pu_key
     * @return string
     */
    public function public_encrypt($data){
        $pu_key = $this->getRSA_pubId();
        openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密
        $encrypted = base64_encode($encrypted);
        return  $encrypted;
    }

    /**私钥解密
     * @param $encrypted
     * @param $pi_key
     * @return mixed
     */
    public function private_decrypt($encrypted){
        $pi_key = $this->getRSA_priId();
        openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密
        return $decrypted;
    }

}