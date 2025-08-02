<?php

Class UrlHelpers{

    public function baseUrl($path){

        return $GLOBALS['site_url'].$path;
    }
}

?>