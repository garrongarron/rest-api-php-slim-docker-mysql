<?php

namespace App\Samu;


use App\Samu\Model;

class Chapter extends Model implements ModelInterface
{
    private $table = 'chapters';
   
    public function __construct($db)
    {
        $this->db = $db;
        $db->query("CREATE TABLE IF NOT EXISTS $this->table (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            description VARCHAR(300) NOT NULL,
            json MEDIUMTEXT NULL
        )");
    }

    public function get($id = null)
    {
        $query = "Select id, description from $this->table";
        if ($id) {
            $query = "Select * from $this->table where id = '$id';";
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
            $query = "delete from $this->table where id = '$id'";
            return $this->toJson($this->db->query($query));
        }
        return $this->toJson();
    }

    public function patch($id, $data)
    {
        if ($id) {
            $query = "update $this->table 
                set description = '$data->data'
                where id = '$id'";
            $this->db->query($query);
            return $this->toJson($this->db->query($query));
        }
        return $this->toJson();
    }

    public function post($data)
    {
        if ($data) {
            $query = "insert into $this->table (description)
            values ('$data->data')";
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
