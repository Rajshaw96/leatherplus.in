<?php

Class Invoice{

    public function getinvoicenumber($prefix, $padding, $nextinvno){

        $printpadding = "";

        $looptorunprintzero = $padding - strlen($nextinvno);

        for($i=1; $i<=$looptorunprintzero; $i++){
            $printpadding = $printpadding."0";
        }

        return $prefix.$printpadding.$nextinvno;
    }
}

?>