<?php
/**
 * The insert db class.
 * The main database inset.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Db\Query\Action;
use Irmmr\Handle\Db;
use Irmmr\Handle\Db\Query;

/**
 * Class Select
 * @package Irmmr\Handle\Db\Query\Action
 */
class Select extends Query\Action
{
    /**
     * @var array The selectors data.
     */
    private array $selects      = [];

    /**
     * Select constructor.
     * @param string $table
     * @param array $selects
     */
    public function __construct(string $table, array $selects = []) {
        $this->setTable($table);
        foreach ($selects as $select) {
            if (!empty($select) && is_string($select)) {
                $this->selects[] = trim($select);
            }
        }
    }

    /**
     * Get data selectors as string.
     * @return string
     */
    private function getSelectors(): string {
        $data = array_map(function ($key) {
            return "`{$key}`";
        }, $this->selects);
        return empty($data) ? '*' : implode(', ', $data);
    }

    /**
     * Make this selector query.
     * @return string
     */
    public function getQuery(): string {
        $selects = $this->getSelectors();
        $query = "SELECT {$selects} FROM `{$this->tableName}`";
        $query .= $this->hasWhere() ? " {$this->whereQuery()}" : '';
        $query .= $this->hasOrder() ? " {$this->orderQuery()}" : '';
        $query .= $this->hasLimit() ? " {$this->limitQuery()}" : '';
        return $query;
    }

    /**
     * Get data from database by select.
     * @return array
     */
    public function get(): array {
        return Db::getData(
            $this->getQuery(),
            empty($this->queryData) ? null : $this->queryData
        );
    }

    /**
     * Select count from data.
     * @return int
     */
    public function getCount(): int {
        $query = "SELECT COUNT(*) FROM `{$this->tableName}`";
        $query .= $this->hasWhere() ? " {$this->whereQuery()}" : '';
        $query .= $this->hasLimit() ? " {$this->limitQuery()}" : '';
        return Db::getCount(
            $query,
            empty($this->queryData) ? null : $this->queryData
        );
    }

    /**
     * Where represent.
     * @param array $conditions
     * @return $this
     */
    public function where(array $conditions): Select {
        $this->whereManage($conditions);
        return $this;
    }

    /**
     * Order represent.
     * @param string $column
     * @param int $mode
     * @return $this
     */
    public function orderBy(string $column, int $mode = Query::ORDER_BY_ASC): Select {
        $this->orderManage($column, $mode);
        return $this;
    }

    /**
     * Limit represent.
     * @param int $que
     * @param int|null $end
     * @return $this
     */
    public function limit(int $que, ?int $end = null): Select {
        $this->limitManage($que, $end);
        return $this;
    }
}