<?php namespace yagas\rsa;
/**
 * RSA接口规则
 * User: yagas@sina.com
 * Date: 2019/3/26 0026
 * Time: 上午 8:28
 */

interface InterfaceRSA {
    public function encrypt($originString, $padding);
    public function decrypt($string, $padding);
}