<?php

namespace Src\Database\Migrations;

use Src\Core\Database\Schema;

abstract class Migration
{
    protected string $name;
    /**
     * Create table in datable
     */
    abstract protected function up();

    /**
     * Drop table
     */
    protected function down()
    {
        Schema::drop($this->name);
    }

    public function migrate()
    {
        echo "Creating table " . strtoupper($this->name) . " ..." . PHP_EOL;
        $this->up();
        echo "Finish create table " . strtoupper($this->name) . PHP_EOL;
    }

    public function rollback()
    {
        echo "Droping table " . strtoupper($this->name) . " ..." . PHP_EOL;
        $this->down();
        echo "Finish drop table " . strtoupper($this->name) . PHP_EOL;
    }

    public function refresh()
    {
        $this->rollback();
        $this->migrate();
    }




}