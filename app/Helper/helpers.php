<?php

use App\Models\Setting;

if(!function_exists("setting")) {
    function setting($name)
    {
        //return Setting::first()->$name;

        $setting =  Setting::first();
        if($setting){
            return Setting::first()->$name;
        }
        else{
            return "no name found yet";
        }
    }
}
