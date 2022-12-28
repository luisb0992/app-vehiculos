<?php
namespace App\Traits;

trait UtilsLogs {



    public function nameDevicePlatorm(){

        return $this->device() .' / '.$this->platform();
    }

    protected function device()
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

    protected function platform()
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
    protected function windows(){
        return is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows"));
    }

    protected function android(){
        return is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android"));
    }

    protected function iphone(){
        return is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone"));
    }

    //device
    protected function mobile(){
        return  is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
    }

    protected function tablet()
    {
        return is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet"));
    }

    public function eventName($name){
        $event = [
            'Creación' => 'created',
            'Actualización' => 'updated',
            'Eliminado' => 'deleted'
        ];

        return array_search($name, $event);
    }
}


?>
