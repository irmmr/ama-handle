<?php
/**
 * The query update db class.
 * The update action for database.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Db\Query;

use Irmmr\Handle\Db;
use Irmmr\Handle\Db\Query;
use Irmmr\Handle\Db\Query\Action\Delete;
use Irmmr\Handle\Db\Query\Action\Insert;
use Irmmr\Handle\Db\Query\Action\Select;
use Irmmr\Handle\Db\Query\Action\Update;

/**
 * Class Table
 * @package Irmmr\Handle\Db\Query
 */
class Table
{
    /**
     * @var string The table name for select data.
     */
    protected string $tableName   = '';

    /**
     * Action constructor.
     * @param string $table
     */
    public function __construct(string $table) {
        $this->tableName = $table;
    }

    /**
     * Select data from table.
     * @param array $rows
     * @return Select
     */
    public function select(array $rows = []): Select {
        return new Select($this->tableName, $rows);
    }

    /**
     * Insert data into table.
     * @param array $rows
     * @return Insert
     */
    public function insert(array $rows = []): Insert {
        return new Insert($this->tableName, $rows);
    }

    /**
     * Delete data from table.
     * @return Delete
     */
    public function delete(): Delete {
        return new Delete($this->tableName);
    }

    /**
     * Update data in table.
     * @param array $rows
     * @return Update
     */
    public function update(array $rows = []): Update {
        return new Update($this->tableName, $rows);
    }

    /**
     * Check if a table exists.
     * @return bool
     */
    public function isExists(): bool {
        return !empty($this->tableName) &&
            Db::execute("DESCRIBE `{$this->tableName}`") === true;
    }

    /**
     * Delete table.
     * @return bool
     */
    public function drop(): bool {
        return !$this->isExists() &&
            Db::execute("DROP TABLE `{$this->tableName}`") === true;
    }
}