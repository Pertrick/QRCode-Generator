<?php
class Database{

    const HOST =  'localhost';
    const USERNAME = 'root';
    const PASSWORD =  '';
    const DB  = 'promo';

    private static $instance = null;
    
    private function __construct(){}

    private function clone(){}

    public static function  getInstance()
    {
        if(is_null(self::$instance)){
            try{
            self::$instance =  mysqli_connect(self::HOST, self::USERNAME, self::PASSWORD, self::DB);
            }catch(Exception $e){
                echo $e->getMessage();
                die;
            }
        }

        return self::$instance;
    }

}