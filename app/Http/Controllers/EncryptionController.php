<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;

class EncryptionController extends Controller
{
    public function encrypt($str)
    {
        var_dump($str);
        $encrypted = Crypt::encryptString($str);
        return $encrypted;
    }

    public function decrypt($str)
    {
        $encrypted = Crypt::decryptString($str);;
        return $encrypted;
    }

    public function md5($str)
    {
        $encrypted = md5($str);
        return $encrypted;
    }
}
