<?php
/**
 * The insert db class.
 * The main database inset.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Db\Query\Action;
use Irmmr\Handle\Db;

/**
 * Class Insert
 * @package Irmmr\Handle\Db\Query\Action
 */
class Insert extends Db\Query\Action
{
    /**
     * @var array The inserts data.
     */
    private array $inserts      = [];

    /**
     * Insert constructor.
     * @param string $table
     * @param array $inserts
     */
    public function __construct(string $table, array $inserts = []) {
        $this->setTable($table);
        foreach ($inserts as $insert => $value) {
            if (!empty($insert) && is_string($insert)) {
                $name = trim($insert);
                $this->inserts[] = $name;
                $this->queryData[$name.'_in'] = $value;
            }
        }
    }

    /**
     * Get insert query.
     * @return string
     */
    public function getQuery(): string {
        $inserts = array_map(function ($key) {
            return "`{$key}`";
        }, $this->inserts);
        $empData = implode(', ', $inserts);
        $valData = array_map(function ($key) {
            return ":{$key}_in";
        }, $this->inserts);
        $valData = implode(', ', $valData);
        return "INSERT INTO `{$this->tableName}` ({$empData}) VALUES ({$valData})";
    }

    /**
     * Run insert execute.
     * @return bool
     */
    public function run(): bool {
        return Db::addData(
            $this->getQuery(),
            empty($this->queryData) ? null : $this->queryData
        );
    }
}