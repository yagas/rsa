<?php
/**
 * 私钥对象
*/

namespace yagas\rsa;

class PrivateRSA implements InterfaceRSA
{
    private $_instance;

    function __construct($privateKey, $passphrase='')
    {
        if(is_file($privateKey)) {
            $privateKey = file_get_contents($privateKey);
        }
        $this->_instance = openssl_pkey_get_private($privateKey, $passphrase);
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
        if(! openssl_private_encrypt($originString, $encryptString, $this->_instance, $padding)) {
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
        if(! openssl_private_decrypt($string, $originString, $this->_instance, $padding)) {
            return False;
        }
        return $originString;
    }

    /**
     * 对字符串进行签名
     * 签名失败返回False，成功返回签名字符串
     * @param String $originString  需要进行签名的字符串
     * @param int $signature_alg    可选项，签名加密得法
     * @return string|bool
     */
    public function sign($originString, $signature_alg=OPENSSL_ALGO_SHA1)
    {
        if(! openssl_sign($originString, $encryptString, $this->_instance, $signature_alg)) {
            return False;
        }
        return base64_encode($encryptString);
    }
}