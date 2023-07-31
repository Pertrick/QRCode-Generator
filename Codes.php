<?php
require_once(__DIR__ . '/Database.php');
class Codes
{
    private $sql;
    private $randomCodes;

    public function __construct()
    {
        if(is_null($this->sql)){
            $this->sql = Database::getInstance();
        } 
    }
   
    public function generateRandomCode()
    {
        $bytes = random_bytes(20);
        $this->randomCodes = mb_strimwidth(bin2hex($bytes),0,17);
        return $this;
    }

    public function InsertToDB()
    {
        $insertQuery = "INSERT INTO qrcode SET code = '" . $this->randomCodes . "' ";
         mysqli_query($this->sql, $insertQuery);
    }
}

