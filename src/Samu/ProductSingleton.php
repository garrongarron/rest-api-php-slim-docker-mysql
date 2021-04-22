<?php

namespace App\Samu;

class ProductSingleton{
    static public $instance = null;
    static public function getInstance(){
        if(self::$instance == null){
            $link = new Database();
            self::$instance = new Product($link->run());
        }
        return self::$instance;
    }
}