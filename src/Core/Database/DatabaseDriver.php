<?php

namespace Src\Core\Database;

use mysqli;

trait DatabaseDriver
{
    protected static function connectDB() : mysqli
    {
        $mysql = env('mysql');
        $connection = new mysqli(
            $mysql->host,
            $mysql->username,
            $mysql->password,
            $mysql->database
        );
        $connection->query("SET NAMES 'utf8'");

        return $connection;
    }
}