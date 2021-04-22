<?php

namespace App\Samu;

class Product
{
    public function __construct($db)
    {
        $this->db = $db;
        $db->query("CREATE TABLE IF NOT EXISTS products (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            description VARCHAR(300) NOT NULL
        )");
    }

    public function get($id = null)
    {
        $query = "Select * from products";
        if ($id) {
            $query = "Select * from products where id = '$id';";
        }
        $resutl = $this->db->query($query);
        if ($resutl->num_rows === 0) {
            return $this->toJson();
        }
        return $this->toJson($resutl);
    }
    
    public function del($id)
    {
        if ($id) {
            $query = "delete from products where id = '$id'";
            return $this->toJson($this->db->query($query));
        }
        return $this->toJson();
    }

    public function patch($id, $data)
    {
        if ($id) {
            $query = "update products 
                set description = '$data'
                where id = '$id'";
            $this->db->query($query);
            return $this->toJson($this->db->query($query));
        }
        return $this->toJson();
    }

    public function post($data)
    {
        if ($data) {
            $query = "insert into products (description)
            values ('$data')";
            return $this->toJson($this->db->query($query));
        }
        return $this->toJson();
    }

    public function toJson($result = null)
    {
        $line = [];
        if ($result === true) {
            return json_encode($line);
        }
        if ($result) {
            while ($obj = $result->fetch_object()) {
                array_push($line, $obj);
            }
        }
        return json_encode($line);
    }
}



/*-- create
create table products (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(30) NOT NULL
);
-- insert
insert into products (description)
values ('test1');
--select
Select *
from products
where description like '%e%';
--update
update products
set description = 'Esto es una descripcion'
where id = 1;
--delete
delete from products
where id = 1;
*/
