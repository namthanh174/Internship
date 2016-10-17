<?php
class Checksum {
    // Used used binaray in Hex format
    private $privateKey = "ec340029d65c7125783d8a8b27b77c8a0fcdc6ff23cf04b576063fd9d1273257"; // default
    private $keySize = 32;
    private $profile;
    private $hash = "sha1";

    function __construct($option, $key = null, $hash = "sha1") {
        $this->profile = $option;
        $this->hash = $hash;

        // Use Default Binary Key or generate yours
        $this->privateKey = ($key === null) ? pack('H*', $this->privateKey) : $key;
        $this->keySize = strlen($this->privateKey);
    }

    private function randString($length) {
        $r = 0;
        switch (true) {
            case function_exists("openssl_random_pseudo_bytes") :
                $r = bin2hex(openssl_random_pseudo_bytes($length));
                break;
            case function_exists("mcrypt_create_ivc") :
            default :
                $r = bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
                break;
        }
        return strtoupper(substr($r, 0, $length));
    }

    public function generate($keys = false) {
        // 10 ramdom char
        $keys = $keys ?  : $this->randString(10);
        $keys = strrev($keys); // reverse string

        // Add keys to options
        $this->profile->keys = $keys;

        // Serialise to convert to string
        $data = json_encode($this->profile);

        // Simple Random Chr authentication
        $hash = hash_hmac($this->hash, $data, $this->privateKey);
        $hash = str_split($hash);

        $step = floor(count($hash) / 15);
        $i = 0;

        $key = array();
        foreach ( array_chunk(str_split($keys), 2) as $v ) {
            $i = $step + $i;
            $key[] = sprintf("%s%s%s%s%s", $hash[$i ++], $v[1], $hash[$i ++], $v[0], $hash[$i ++]);
            $i ++; // increment position
        }
        return strtoupper(implode("-", $key));
    }

    public function check($key) {
        $key = trim($key);
        if (strlen($key) != 29) {
            return false;
        }
        // Exatact ramdom keys
        $keys = implode(array_map(function ($v) {
            return $v[3] . $v[1];
        }, array_map("str_split", explode("-", $key))));

        $keys = strrev($keys); // very important
        return $key === $this->generate($keys);
    }
}
