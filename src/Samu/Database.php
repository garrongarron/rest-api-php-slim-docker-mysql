<?php

namespace App\Samu;

use Exception;

class Database
{
    public function __construct()
    {
        error_reporting(0);
        $this->link = new \mysqli("mysql", "symfony", "secret", "symfony");
        if (mysqli_connect_errno()) {
            throw new Exception(mysqli_connect_error());
        }
    }

    public function run()
    {
        return $this->link;
    }
}
