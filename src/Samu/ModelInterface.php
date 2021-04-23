<?php

namespace App\Samu;

interface ModelInterface
{
    public function get($id = null);
    public function del($id);
    public function patch($id, $data);
    public function post($data);
}