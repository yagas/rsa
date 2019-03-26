<?php
/**
 * 公钥对象
*/

namespace yagas\rsa;

class PublicRSA implements InterfaceRSA
{
    private $_instance;

    function __construct($publicKey)
    {
        if(is_file($publicKey)) {
            $publicKey = file_get_contents($publicKey);
        }
        $this->_instance = openssl_pkey_get_public($publicKey);
    }

    function __destruct()
    {
        openssl_free_key($this->_instance);
    }

    /**
     * 使用私钥对字符串进行加密
     * 加密失败返回False，成功返回base64编码的加密数据
     * @param string $originString 需要进行加密的字符串
     * @param int $padding
     * @return bool|string
     */
    public function encrypt($originString, $padding=OPENSSL_PKCS1_PADDING)
    {
        if(! openssl_public_encrypt($originString, $encryptString, $this->_instance, $padding)) {
            return False;
        }
        return base64_encode($encryptString);

    }

    /**
     * 使用么钥对公钥加密的数据进行解密
     * @param string $encryptString 加密的base64编码数据
     * @param int $padding
     * @return bool|string
     */
    public function decrypt($encryptString, $padding=OPENSSL_PKCS1_PADDING)
    {
        $string = base64_decode($encryptString);
        if(! openssl_public_decrypt($string, $originString, $this->_instance, $padding)) {
            return False;
        }
        return $originString;
    }

    /**
     * 使用公密对签名进行校验
     * @param string $originString 需要进行校验的数据
     * @param string $encryptString base64编码的签名数据
     * @param int $signature_alg 加密算法
     * @return bool
     */
    public function valid($originString, $encryptString, $signature_alg=OPENSSL_ALGO_SHA1)
    {
        $encryptString = base64_decode($encryptString);
        return (bool)openssl_verify($originString, $encryptString, $this->_instance, $signature_alg);
    }
}