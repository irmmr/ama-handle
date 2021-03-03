<?php
/**
 * The action database class
 * The action class uses as a mother class for
 * other query actions.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Db\Query;

use Irmmr\Handle\Db\Query;

/**
 * Class Action
 * @package Irmmr\Handle\Db\Query
 */
class Action
{
    /**
     * @var string The table name for select data.
     */
    protected string $tableName   = '';

    /**
     * @var array The query data.
     */
    protected array $queryData    = [];

    /**
     * @var array Where array conditions.
     */
    protected array $where        = [];

    /**
     * @var array Limit query.
     */
    protected array $limit        = [];

    /**
     * @var array Order data.
     */
    protected array $order        = [];

    /**
     * Get query data.
     * @return array
     */
    protected function getData(): array {
        return $this->queryData;
    }

    /**
     * Table set.
     * @param string $tableName
     * @return Action
     */
    public function setTable(string $tableName): Action {
        $this->tableName = trim($tableName);
        return $this;
    }

    /**
     * Where query for this app.
     * @param array $conditions
     * @return void
     */
    protected function whereManage(array $conditions): void {
        if (empty($conditions)) {
            return;
        }
        foreach ($conditions as $co => $val) {
            if (is_string($co) && !empty($co)) {
                $name = trim($co);
                $sp = explode(':', $name);
                $this->where[] = $name;
                $this->queryData[$sp[0].'_wh'] = trim($val);
            }
        }
    }

    /**
     * Manage order type.
     * @param string $column
     * @param int $mode
     */
    protected function orderManage(string $column, int $mode): void {
        if (empty($column)) {
            return;
        }
        if ($mode !== Query::ORDER_BY_ASC && $mode !== Query::ORDER_BY_DESC) {
            $mode = Query::ORDER_BY_ASC;
        }
        $this->order = [trim($column), $mode];
    }

    /**
     * Get the limit query.
     * @return string
     */
    protected function orderQuery(): string {
        $ord = count($this->order);
        if ($ord !== 2) {
            return '';
        }
        $orderType = $this->order[1] == 2 ? 'DESC' : 'ASC';
        return "ORDER BY `{$this->tableName}`.`{$this->order[0]}` {$orderType}";
    }

    /**
     * Limit query for data.
     * @param int $que
     * @param int|null $end
     * @return void
     */
    protected function limitManage(int $que, ?int $end = null): void {
        $this->limit = is_null($end) ? [$que] : [$que, $end];
    }

    /**
     * Get the limit query.
     * @return string
     */
    protected function limitQuery(): string {
        $limitCount = count($this->limit);
        if ($limitCount == 1) {
            return "LIMIT {$this->limit[0]}";
        } elseif ($limitCount == 2) {
            $lmQuery = implode(', ', $this->limit);
            return "LIMIT {$lmQuery}";
        } else {
            return '';
        }
    }

    /**
     * Get where query.
     * @return string
     */
    protected function whereQuery(): string {
        if (empty($this->where)) {
            return '';
        }
        $whereMaker = [];
        foreach ($this->where as $wh) {
            $sp = explode(':', $wh);
            $var = $sp[0];
            $ope = $sp[1] ?? 'eq';
            if ($ope == 'gt') {
                $ope = '>';
            } elseif ($ope == 'lt') {
                $ope = '<';
            } elseif ($ope == 'ne') {
                $ope = '!=';
            } elseif ($ope == 'ge') {
                $ope = '>=';
            } elseif ($ope == 'le') {
                $ope = '<=';
            } else {
                $ope = '=';
            }
            $whereMaker[] = "`{$var}`{$ope}:{$var}_wh";
        }
        $whQuery = implode(' AND ', $whereMaker);
        return " WHERE {$whQuery}";
    }

    /**
     * Check for where exists.
     * @return bool
     */
    protected function hasWhere(): bool {
        return !empty($this->where);
    }

    /**
     * Check for limit exists.
     * @return bool
     */
    protected function hasLimit(): bool {
        return !empty($this->limit);
    }

    /**
     * Check for order exists.
     * @return bool
     */
    protected function hasOrder(): bool {
        return !empty($this->order);
    }
}