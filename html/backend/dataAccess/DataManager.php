<?php
declare(strict_types=1);
namespace backend\dataAccess;

class DataManager {
    
    private $db;
    private $result;
    public function __construct() {
        $this->db = mysqli_connect("localhost", "test", "test", "alertsystem");
    }

    public function query($query) {
        $this->result = mysqli_query($this->db, $query);
    }

    public function fetchAll() {
        return mysqli_fetch_all ($this->result, MYSQLI_ASSOC);
    }

    public function fetch() {
        return mysqli_fetch_assoc ($this->result);
    }

    public function lastId() {
        return mysqli_insert_id($this->db);
    }

    public function rowsAffected() {
        return mysqli_affected_rows($this->db);
    }
}