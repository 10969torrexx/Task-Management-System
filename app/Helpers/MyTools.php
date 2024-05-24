<?php
// app/Helpers/MyTools.php

if (! function_exists('myFunction')) {
    function encrypt($data) {
        if (strlen(AESCipher::$key) < AESCipher::$CIPHER_KEY_LEN) {
            AESCipher::$key = str_pad("AESCipher::$key", AESCipher::$CIPHER_KEY_LEN, "0"); //0 pad to len 16
        } else if (strlen(AESCipher::$key) > AESCipher::$CIPHER_KEY_LEN) {
            AESCipher::$key = substr(AESCipher::$key, 0, AESCipher::$CIPHER_KEY_LEN); //truncate to 16 bytes
        }
        
        $encodedEncryptedData = base64_encode(openssl_encrypt($data, AESCipher::$OPENSSL_CIPHER_NAME, AESCipher::$key, OPENSSL_RAW_DATA, AESCipher::$iv));
        $encodedIV = base64_encode(AESCipher::$iv);
        $encryptedPayload = $encodedEncryptedData.":".$encodedIV;
        
        return $encryptedPayload;
        
    }

    function decrypt($data) {
        if (strlen(AESCipher::$key) < AESCipher::$CIPHER_KEY_LEN) {
            AESCipher::$key = str_pad("AESCipher::$key", AESCipher::$CIPHER_KEY_LEN, "0"); //0 pad to len 16
        } else if (strlen(AESCipher::$key) > AESCipher::$CIPHER_KEY_LEN) {
            AESCipher::$key = substr(AESCipher::$key, 0, AESCipher::$CIPHER_KEY_LEN); //truncate to 16 bytes
        }
        
        $data = explode(":", $data);
        $decodedEncryptedData = base64_decode($data[0]);
        $decodedIV = base64_decode($data[1]);
        $decryptedPayload = openssl_decrypt($decodedEncryptedData, AESCipher::$OPENSSL_CIPHER_NAME, AESCipher::$key, OPENSSL_RAW_DATA, $decodedIV);
        
        return $decryptedPayload;
    }
}