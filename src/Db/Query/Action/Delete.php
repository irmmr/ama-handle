<?php
/**
 * The delete db class.
 * The main database delete.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Db\Query\Action;
use Irmmr\Handle\Db;

/**
 * Class Delete
 * @package Irmmr\Handle\Db\Query
 */
class Delete extends Db\Query\Action
{
    /**
     * Delete constructor.
     * @param string $table
     */
    public function __construct(string $table) {
        $this->setTable($table);
    }

    /**
     * Get delete query.
     * @return string
     */
    public function getQuery(): string {
        $query = "DELETE FROM `{$this->tableName}`";
        $query .= $this->hasWhere() ? " {$this->whereQuery()}" : '';
        $query .= $this->hasLimit() ? " {$this->limitQuery()}" : '';
        return $query;
    }

    /**
     * Where represent.
     * @param array $conditions
     * @return $this
     */
    public function where(array $conditions): Delete {
        $this->whereManage($conditions);
        return $this;
    }

    /**
     * Limit represent.
     * @param int $que
     * @param int|null $end
     * @return $this
     */
    public function limit(int $que, ?int $end = null): Delete {
        $this->limitManage($que, $end);
        return $this;
    }

    /**
     * Run process.
     * @return bool
     */
    public function run(): bool {
        return Db::delData(
            $this->getQuery(),
            empty($this->queryData) ? null : $this->queryData
        );
    }
}