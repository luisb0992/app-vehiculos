<?php
namespace App\Traits;

trait DeviceDetected {

    public function nameDevicePlatorm(){

        return $this->device() .' / '.$this->platform();
    }

    public function device()
    {
        if($this->mobile()){
            if($this->tablet()){
                $device = 'Tablet';
            }else{
                $device = 'Mobile';
            }
        }else{
            $device = 'PC';
        }

        return $device;
    }

    public function platform()
    {

        if($this->iphone()){
            $platform = 'iOS';
        }elseif($this->android()){
            $platform = 'ANDROID';
        }elseif($this->windows()){
            $platform = 'WINDOWS';
        }

        return $platform;

    }

    //platforms
    public function windows(){
        return is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows"));
    }

    public function android(){
        return is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android"));
    }

    public function iphone(){
        return is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone"));
    }

    //device
    public function mobile(){
        return  is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
    }

    public function tablet()
    {
        return is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet"));
    }
}


?>
