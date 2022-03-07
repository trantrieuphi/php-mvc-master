<?php

namespace Src\Core\Database;

final class Table
{
    /**
     * @var Column[] $table
     */
    private array $table;
    private int $current;

    public function __construct()
    {
        $this->table = [];
        $this->current = -1;
    }

    /**
     * Create id column
     * @return $this
     */
    public function id()
    {
        $this->current++;
        $this->table[] = new Column('id', [
            Column::INT,
            Column::AUTO_INCREMENT,
            Column::PRIMARY_KEY
        ]);
        return $this;
    }

    /**
     * @param string $name : name column
     * @param int $length : length of varchar datatype
     * @return $this
     */
    public function string(string $name , int $length = 256)
    {
        $this->current++;
        $this->table[] = new Column($name, Column::varchar($length));

        return $this;
    }

    /**
     * @param string $name : name column with integer datatype
     * @return $this
     */
    public function integer(string $name)
    {
        $this->current++;
        $this->table[] = new Column($name, Column::INT);

        return $this;
    }

    /**
     * @param string $name : name column with timestamp datatype
     * @return $this
     */
    public function timestamps(string $name)
    {
        $this->current++;
        $this->table[] = new Column($name, Column::TIMESTAMP);

        return $this;
    }

    /**
     * Create create_at, update_at column
     */
    public function TimestampCreateAndUpdate()
    {
        $create_at = new Column('create_at', Column::TIMESTAMP);
        $create_at->makeDefaultAs(Column::CURRENT_TIMESTAMP);
        $this->table[] = $create_at;

        $update_at = new Column('update_at', Column::TIMESTAMP);
        $update_at->makeNull();
        $update_at->makeDefaultAs(null);
        $update_at->makeUpdateOn(Column::CURRENT_TIMESTAMP);
        $this->table[] = $update_at;

        $this->current += 2;
    }

    public function unique()
    {
        if(array_key_exists($this->current, $this->table))
            $this->table[$this->current]->makeUnique();

        return $this;
    }

    public function autoIncrement()
    {
        if(array_key_exists($this->current, $this->table))
            $this->table[$this->current]->makeAutoIncrement();

        return $this;
    }

    public function nullable()
    {
        if(array_key_exists($this->current, $this->table)) {
            $this->table[$this->current]->makeNull();
            $this->table[$this->current]->makeDefaultAs(null);
        }

        return $this;
    }

    public function toString()
    {
        $columns = array_map(function(Column $column) {
            return $column->toString();
        }, $this->table);

        return '(' . join(',', $columns) . ')';
    }
}