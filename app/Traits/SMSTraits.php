<?php
namespace App\Traits;

trait SMSTraits{
    public function sendSMS($number, $message)
    {
        try {
            $url="http://66.45.237.70/api.php";
            $data=array(
                'username' =>"01322644599",
                'password' =>"4NBHSC3G",
                'number'   =>$number,
                'message'  =>$message
            );
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            $smsresult=curl_exec($ch);
            $p=explode("|",$smsresult);
            $sendstatus=$p[0];
            return true;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
