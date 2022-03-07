<?php

namespace Src\Core\Database;

use Closure;

class Schema 
{
    use DatabaseDriver;

    /**
     * 
     */
    public static function create($name, Closure $callback)
    {
        $connection = self::connectDB();
        $table = new Table();
        $callback($table);

        $sql = "CREATE TABLE {$name} " . $table->toString();
        $connection->query($sql);
    }

    public static function drop($name)
    {
        $connection = self::connectDB();

        $sql = "DROP TABLE {$name}";
        $connection->query($sql);
    }
}