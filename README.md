一个简单的RSA加解密库
------
A SIMPLE RSA LIBRARY

```
use yagas/rsa/RSA;

$signString = RSA::privatePK(path or content)->sign('originString', OPENSSL_ALGO_MD5);

if(RSA::publicPK(path or content)->valid('originString', $signString, OPENSSL_ALGO_MD5)) {
    echo 'successful';
}
else {
    echo 'failed';
}

$encryptString = RSA::privatePK(path or content)->encrypt('hello', OPENSSL_PKCS1_PADDING);

$originString = RSA::publicPK(path or content)->decrypt($encryptString, OPENSSL_PKCS1_PADDING);
```