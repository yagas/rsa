<?php namespace yagas\rsa;
/**
 * RSA数字签名对象
 * User: yagas@sina.com
 * Date: 2019/3/26 0026
 * Time: 上午 8:23
 */

class RSA {
    /**
     * 私钥文件对象
     * @param $key
     * @return PrivateRSA
     */
    public static function privatePk($key)
    {
        return new PrivateRSA($key);
    }

    /**
     * 公钥文件对象
     * @param $key
     * @return PublicRSA
     */
    public static function publicPk($key)
    {
        return new PublicRSA($key);
    }
}