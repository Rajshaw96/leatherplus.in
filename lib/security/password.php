<?php

Class Password{

    public function encryptPassword($password){

        $encpass = "thunder@Security".md5($password);

        return md5($encpass);
    }
}

?>