<?php 

namespace Src\Database\Migrations;

use Src\Core\Database\Schema;
use Src\Core\Database\Table;

class CreateUserTable extends Migration
{
    public function __construct()
    {
        $this->name = 'users';
    }

    public function up()
    {
        Schema::create($this->name, function (Table $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps('birth_date')->nullable();
            $table->string('phone', 20)->nullable();
            $table->TimestampCreateAndUpdate();
        });
    }
}