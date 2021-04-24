<?php

namespace App\Samu\Modules;

use App\Samu\Model;
use App\Samu\ModelInterface;

class Chapter extends Model implements ModelInterface
{
    private $table = 'chapter';

    public function __construct($db)
    {
        $this->db = $db;
        $db->query("CREATE TABLE IF NOT EXISTS $this->table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title TINYTEXT NOT NULL,
            description TEXT NOT NULL,
            data MEDIUMTEXT NOT NULL,
            create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function get($id = null)
    {
        $query = "Select * from $this->table";
        if ($id) {
            $query = "Select * from $this->table 
            where id = '$id';";
        } else {
            $text = $this->scape($_REQUEST['s']);
            $query = "Select * from $this->table where 
            title like '%$text%' 
            OR 
            description like '%$text%'";
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

    public function scape($data)
    {
        return mysqli_real_escape_string($this->db, (string)$data);
    }
    public function patch($id, $data)
    {
        $description = $this->scape($data->description);
        $title = $this->scape($data->title);
        if ($id) {
            $query = "update $this->table 
                set 
                title = '$title',
                description = '$description'
                where id = '$id'";
            $this->db->query($query);
            return $this->toJson($this->db->query($query));
        }
        return $this->toJson();
    }

    public function post($data)
    {
        $description = $this->scape($data->description);
        $title = $this->scape($data->title);
        if ($data) {
            $query = "insert into $this->table 
            (title, description, data)
            values (
                '$title',
                '$description',
                '[{\"tag\":\"h1\",\"text\":\"Dummy Text\"}]'
            )";
            return $this->toJson($this->db->query($query));
        }
        return $this->toJson();
    }
}
