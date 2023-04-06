<?php

namespace App\Libraries;

class enkripsi
{

    public function twowayhash_enkripsi($msg)
    {
        $superkey = $_ENV["TTDKEY"];
        $twowaykey = $_ENV["twoWAYKEY"];
        $algo = "aes256";
        return openssl_encrypt($msg, $algo, $twowaykey, 0, $superkey);
        // return openssl_encrypt($msg, $algo, $twowaykey, 0, $superkey);
    }

    public function twowayhash_dekripsi($msg)
    {
        $superkey = $_ENV["TTDKEY"];
        $twowaykey = $_ENV["twoWAYKEY"];
        $algo = "aes256";
        return openssl_decrypt($msg, $algo, $twowaykey, 0, $superkey);
        // return openssl_encrypt($msg, $algo, $twowaykey, 0, $superkey);
    }

    public function hash256($data)
    {
        return hash("sha256", $data);
    }

    public function UUIDv4()
    {
        return "belum ada";
    }
}
