<?php
/**
 * The query db class.
 * The main database query for system.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Db;
use Irmmr\Handle\Db\Query\Table;

/**
 * Class Query
 * @package Irmmr\Handle\Db
 */
class Query
{
    /**
     * Orders mode for database order by.
     */
    const ORDER_BY_ASC  = 1;
    const ORDER_BY_DESC = 2;

    /**
     * Table query data.
     * @param string $name
     * @return Table
     */
    public function table(string $name): Table {
        return new Table($name);
    }
}