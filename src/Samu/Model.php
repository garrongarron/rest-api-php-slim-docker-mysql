<?php

namespace App\Samu;

use App\Samu\Database;

class Model
{
    static public $DB = null;
    static public function model(){
        if(self::$DB == null){
            self::$DB = new Database();            
        }
        $class = get_called_class();
        return new $class(self::$DB->run());
    }
}