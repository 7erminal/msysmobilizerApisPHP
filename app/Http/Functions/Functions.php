<?php

namespace App\Http\Functions;
use Illuminate\Support\Facades\Log;

class Functions{
    public function validateNumber($number){
        $numPrefix = substr($number, 0, 3);

        Log::debug("Number prefix is ");
        Log::debug($numPrefix);
    
        $newNum = $number;
    
        if($numPrefix=="233"){
            Log::debug("About to replace ".$numPrefix." with 0 in ".$number);
            $newNum = str_replace($numPrefix,"0", $number);
        } else if ($numPrefix=="+23"){
            $numPrefix = substr($number, 0, 4);
            Log::debug("About to replace ".$numPrefix." with 0 in ".$number);
            $newNum = str_replace($numPrefix,"0", $number);
        }
    
        return $newNum;
    }
}