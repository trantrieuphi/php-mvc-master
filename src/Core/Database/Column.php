<?php

namespace Src\Core\Database;

final class Column
{
    public const NOT_NULL = 'NOT NULL';
    public const NULL = 'NULL';
    public const PRIMARY_KEY = 'PRIMARY KEY';
    public const AUTO_INCREMENT = 'AUTO_INCREMENT';
    public const DEFAULT = 'DEFAULT';
    public const UNIQUE = 'UNIQUE';
    public const VARCHAR = 'VARCHAR';
    public const INT = 'INT';
    public const TIMESTAMP = 'TIMESTAMP';
    public const CURRENT_TIMESTAMP = 'CURRENT_TIMESTAMP';
    public const ON_UPDATE = 'ON UPDATE';

    private string $name;
    private array $datatypes;

    /**
     * @param string $name
     * @param string | array $datatypes
     */
    public function __construct(string $name, $datatypes)
    {
        $this->name = $name;
        $this->datatypes = is_array($datatypes) ? $datatypes : [$datatypes];

        if (!$this->checkDatatypeExist(self::NOT_NULL))
            $this->datatypes[] = self::NOT_NULL;
    }

    /**
     * @param string $datatype
     * @return bool
     */
    private function checkDatatypeExist(string $datatype) : bool
    {
        return in_array($datatype, $this->datatypes);
    }

    public static function varchar(int $length) : string
    {
        return self::VARCHAR . '(' . $length . ')';
    }

    /**
     * Make null column
     */
    public function makeNull()
    {
        if (($key = array_search(self::NOT_NULL, $this->datatypes)) !== false) {
            unset($this->datatypes[$key]);
        }
    }

    public function makePrimaryKey()
    {
        if (!$this->checkDatatypeExist(self::PRIMARY_KEY))
            $this->datatypes[] = self::PRIMARY_KEY;
    }

    public function makeUnique()
    {
        if (!$this->checkDatatypeExist(self::UNIQUE))
            $this->datatypes[] = self::UNIQUE;
    }

    public function makeAutoIncrement()
    {
        if (!$this->checkDatatypeExist(self::AUTO_INCREMENT))
            $this->datatypes[] = self::AUTO_INCREMENT;
    }

    public function makeDefaultAs($value)
    {
        if (!$this->checkDatatypeExist(self::DEFAULT)) {
            $this->datatypes[] = self::DEFAULT;
            $this->datatypes[] = $value ?? self::NULL;
        }
    }

    public function makeUpdateOn($value)
    {
        if(!$this->checkDatatypeExist(self::ON_UPDATE)) {
            $this->datatypes[] = self::ON_UPDATE;
            $this->datatypes[] = $value;
        }
    }

    public function rename($name)
    {
        $this->name = $name;
    }

    public function toString()
    {
        return $this->name . " " . join(' ', $this->datatypes);
    }
}