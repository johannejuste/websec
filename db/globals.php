<?php

//Hashing
$peberstring = "/7GM8MrHGtusdj05ANPKzZQOBfkNPYf+LXVViYmmzjVIk0d+ATKHzf9vqRKmb+kFMYA=";
$algo = "sha256";
// converts data to 256 bits and output it into the format of 64 hexadecimal characters

// Symmetric key encryption
$encrypt_algo = "aes-256-cbc"; //encryption algo (block cipher CBC)
$key = "megafedkey"; // Encryption and decryption key
$iv_len = openssl_cipher_iv_length($encrypt_algo);
$iv = openssl_random_pseudo_bytes($iv_len); 



// $ciphertextIv= openssl_encrypt($plaintext, $alg_cbc, $key, OPENSSL_RAW_DATA, $iv ); // encrypt with the $iv // convert it to hex/base64encode

// echo base64_encode($ciphertextIv)."<br>";