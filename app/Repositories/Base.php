<?php

namespace App\Repositories;

class Base
{
    public function encryptPass($pass)
    {
        return openssl_encrypt($pass,config('app.cipher'),env('APP_KEY'),0,config('app.encryption_iv'));
    }
    public function decryptPass($pass)
    {
        return openssl_decrypt($pass,config('app.cipher'),env('APP_KEY'),0,config('app.encryption_iv'));
    }

}
