<?php

namespace Src\Core\Database;

use Exception;
use mysqli;
use Src\Core\Database\DatabaseDriver;

class DB {
    /**
     * @default: table's name in DB is lowcase Classname + 's'
     * You can overwrite it by define static variable $table
     */
    protected static $table = null;
    private $where_db = 'TRUE';
    private $select_db = '*';
    private $limit_db = 1000; 

    use DatabaseDriver;

    private function resetQuery() {
        $this->where_db  = 'TRUE';
        $this->select_db = '*';
        $this->limit_db  = 1000;
    }

    private function prepareQuery() {
        if(empty($this->where_db))
            $this->where_db = "TRUE";
        else if(is_array($this->where_db))
            $this->where_db = join(' AND ', $this->where_db);
        else 
            $this->where_db = "TRUE";

        if(empty($this->select_db)) 
            $this->select_db = "*";
        else if(is_array($this->select_db))
            $this->select_db = join(',', $this->select_db);
        else
            $this->select_db = "*";
    }

    public static function create($data) {  
        $connection = self::connectDB();

        // Handle table name
        if(isset(static::$table)) {
            $table = static::$table;
        }
        else {
            $tmp = explode('\\', static::class);
            $table = strtolower(end($tmp)) . "s";
        }
        
        foreach($data as $key => $value) {
            $field_list[] = $key;
            $value_list[] = "'" . $connection->real_escape_string($value) . "'";
        }
        $field_list = join(',', $field_list);
        $value_list = join(',', $value_list);

        $sql = "INSERT INTO {$table} ({$field_list}) VALUES ({$value_list})";
        $result = $connection->query($sql);
        
        if( $result === TRUE )
            return true;
        return false;
    }

    public function update($data) {
        $this->prepareQuery();

        foreach($data as $key => $value) {
            $update_db[] = $key . " = '" . $this->connection->real_escape_string($value) . "'";
        }
        $update_db = join(',', $update_db);

        $sql = "UPDATE {$this->table} SET {$update_db} WHERE {$this->where_db} LIMIT {$this->limit_db}";
        $this->connection->query($sql);

        if($this->connection->affected_rows > 0)
            return true;
        return false;
    }

    public function delete() {
        $this->prepareQuery();

        $sql = "DELETE FROM {$this->table} WHERE {$this->where_db} LIMIT {$this->limit_db}";
        $this->connection->query($sql);

        if($this->connection->affected_rows > 0)
            return true;
        return false;
    }

    /**
     * find by ID
     * return schema
     */
    public function find($id) {
        $this->where_db = ["id = {$id}"];
        $this->limit_db = 1;
        $data = $this->first();

        $this->resetQuery();
        return $data;
    }

    public function select($columns) {
        if(is_string($this->select_db))
            $this->select_db = [];
        
        if(is_array($columns))
            $this->select_db = array_merge($this->select_db, $columns);
        else 
            $this->select_db[] = $columns;
        
        return $this;
    }

    public function where($column, $operator, $value) {
        if(is_string($this->where_db))
            $this->where_db = [];

        $value = $this->connection->real_escape_string($value);
        $this->where_db[] = "{$column} {$operator} '{$value}'";
        return $this;
    }

    public function limit($num_row) {
        $this->limit_db = $num_row; 
        return $this;
    }

    public function get() {
        $this->prepareQuery();

        $sql = "SELECT {$this->select_db} FROM {$this->table} WHERE {$this->where_db} LIMIT {$this->limit_db}";
        $result = $this->connection->query($sql);
        
        $data = [];
        while($row = $result->fetch_array()) {
            $data[] = new $this->schema($row);
        }

        $this->resetQuery();
        return $data;
    }

    public function first() {
        $this->prepareQuery();

        $sql = "SELECT {$this->select_db} FROM {$this->table} WHERE {$this->where_db} LIMIT 1";
        $result = $this->connection->query($sql);

        $data = null;
        while($row = $result->fetch_array()) {
            $data = new $this->schema($row);
        }

        $this->resetQuery();
        return $data;
    }
}