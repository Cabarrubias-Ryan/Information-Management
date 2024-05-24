<?php

    function encryptData($data)
    {
        $key = 'a$7aH2>.1@a';
        $cipher = 'aes-256-cbc';

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);

        $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    function decryptData($encryptedData)
    {
        $key = 'a$7aH2>.1@a';
        $cipher = 'aes-256-cbc';

        $data = base64_decode($encryptedData);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $ivlen);
        $encrypted = substr($data, $ivlen);

        return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
    }

?>