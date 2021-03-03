<?php
/**
 * The query update db class.
 * The update action for database.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Db\Query\Action;
use Irmmr\Handle\Db;

/**
 * Class Update
 * @package Irmmr\Handle\Db\Query\Action
 */
class Update extends Db\Query\Action
{
    /**
     * @var array The update process values.
     */
    private array $up = [];

    /**
     * Update constructor.
     * @param string $table
     * @param array $rows
     */
    public function __construct(string $table, array $rows = []) {
        $this->setTable($table);
        foreach ($rows as $row => $value) {
            if (empty($row) || !is_string($row)) {
                continue;
            }
            $name = trim($row);
            $this->up[] = $name;
            $this->queryData[$name.'_up'] = $value;
        }
    }

    /**
     * Where represent.
     * @param array $conditions
     * @return $this
     */
    public function where(array $conditions): Update {
        $this->whereManage($conditions);
        return $this;
    }

    /**
     * Get query.
     * @return string
     */
    public function getQuery(): string {
        $query = "UPDATE `{$this->tableName}`";
        $data = array_map(function ($key) {
            return "`{$key}`=:{$key}_up";
        }, $this->up);
        $query .= " SET " . implode(', ', $data);
        $query .= $this->hasWhere() ? " {$this->whereQuery()}" : '';
        return $query;
    }

    /**
     * Run process.
     * @return bool
     */
    public function run(): bool {
        return Db::addData(
            $this->getQuery(),
            empty($this->queryData) ? null : $this->queryData
        );
    }
}