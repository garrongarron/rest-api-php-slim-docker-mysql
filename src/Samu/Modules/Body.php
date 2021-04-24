<?php

namespace App\Samu\Modules;

use App\Samu\Model;
use App\Samu\ModelInterface;

class Body extends Model implements ModelInterface
{
    private $table = 'chapter';
    private $bk_table = 'chapter_bk';

    public function __construct($db)
    {
        $this->db = $db;
        $q = "CREATE TABLE IF NOT EXISTS $this->bk_table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            chapter_id INT NOT NULL,
            title TINYTEXT NOT NULL,
            description TEXT NOT NULL,
            data MEDIUMTEXT NOT NULL,
            create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )";
        $db->query($q);
    }

    public function get($id = null)
    {
        $query = "Select * from $this->table";
        if ($id) {
            $query = "Select id, data 
            from $this->table 
            where id = '$id';";
        }
        $resutl = $this->db->query($query);
        if ($resutl->num_rows === 0) {
            return $this->toJson();
        }
        return $this->toJson($resutl);
    }

    public function del($id)
    {
        // if ($id) {
        //     $query = "delete from $this->table 
        //          where id = '$id'";
        //     return $this->toJson($this->db->query($query));
        // }
        return $this->toJson();
    }

    public function patch($id, $data)
    {
        if ($id) {
            $data = $this->scape($data->data);
            $query = "update $this->table 
                set data = '$data'
                where id = '$id'";
            // error_log($query, 3, "/var/www/html/logs/meessages.log");
            $this->db->query($query);
            return $this->toJson($this->db->query($query));
        }
        return $this->toJson();
    }

    public function scape($data)
    {
        return mysqli_real_escape_string($this->db, (string)$data);
    }
    public function post($data)
    {
        if ($data) {
            $dataContent = $this->scape($data->data);
            $query = "update $this->table 
                set data = '$dataContent'
                where id = '$data->id'";

            $this->db->query($query);

            $query_bk = "INSERT INTO $this->bk_table (
                    chapter_id, title,
                    description,data
                )
                SELECT 
                    id,title,description,data
                FROM 
                    $this->table 
                WHERE
                    $this->table.id = '$data->id'";
            // error_log($query_bk, 3, "/var/www/html/logs/meessages.log");
            return $this->toJson($this->db->query($query_bk));
        }
        return $this->toJson();
    }
}
