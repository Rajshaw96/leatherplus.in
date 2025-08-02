<?php

Class Requests{

    public function encodeRequestHash($str){

        $enc1 = rand(1111,9999).md5($str);

        return base64_encode($enc1);
    }

    public function checkRequestHash($hash, $str){

        $hashstring = substr(base64_decode($hash), 4);

        if($hashstring == md5($str)){

            return true;
        }
        else{
            return false;
        }

    }
}

?>