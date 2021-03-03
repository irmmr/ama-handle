<?php
/**
 * The db class.
 * The main database connector for system.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Db\Query;
use PDO;
use PDOException;

/**
 * Class Db
 * @package Irmmr\Handle
 */
class Db
{
    /**
     * @var PDO|null The connection handle.
     */
    private static ?PDO $connector = null;

    /**
     * Check if config assets are exists.
     * @return bool
     */
    public static function hasAssets(): bool {
        return defined('AMA_HANDLE_DB') &&
            is_array(AMA_HANDLE_DB);
    }

    /**
     * Manage auto connection for actions.
     */
    private static function openAutoConn(): void {
        if (!self::hasConnection() && AMA_HANDLE_DB['auto_make']) {
            self::makeConnection();
        }
    }

    /**
     * Manage auto connection for close that.
     */
    private static function closeAutoConn(): void {
        if (self::hasConnection() && AMA_HANDLE_DB['auto_make']) {
            self::closeAutoConn();
        }
    }

    /**
     * Database create connection using PDO.
     */
    public static function makeConnection(): void {
        if (!self::hasAssets()) {
            return;
        }
        try {
            self::$connector = new PDO("mysql:host=" . AMA_HANDLE_DB['host'] ?? '' . ";dbname=" . AMA_HANDLE_DB['name'] ?? '' . ";charset=" . AMA_HANDLE_DB['charset'] ?? '', AMA_HANDLE_DB['user'] ?? '', AMA_HANDLE_DB['pass'] ?? '');
            self::$connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Err::expLog($e, Err::DATABASE, 'MakeConnection');
        }
    }

    /**
     * Check if has database connection.
     * @return bool
     */
    public static function hasConnection(): bool {
        return !is_null(self::$connector);
    }

    /**
     * Tries to stop database connection.
     */
    public static function stopConnection(): void {
        self::$connector = null;
    }

    /**
     * Get the db main connection.
     * @return PDO|null
     */
    public static function getConnection(): ?PDO {
        return self::$connector;
    }

    /**
     * Get the db row count.
     * @param string $sql
     * @param array|null $bin
     * @return int
     */
    public static function getCount(string $sql, ?array $bin = null): int {
        self::openAutoConn(); // auto connection
        try {
            $db = self::getConnection()->prepare($sql);
            $db->execute($bin);
            self::closeAutoConn(); // auto connection
            return $db->fetchColumn();
        } catch (\Exception $e) {
            Err::expLog($e, Err::DATABASE, 'DatabaseGetCount');
        } finally {
            return 0;
        }
    }

    /**
     * Get the rows data from db.
     * @param string $sql
     * @param array|null $bin
     * @return array
     */
    public static function getData(string $sql, ?array $bin = null): array {
        self::openAutoConn(); // auto connection
        try {
            $db = self::getConnection()->prepare($sql);
            $db->execute($bin);
            $rows = $db->fetchAll();
            self::closeAutoConn(); // auto connection
            return $rows ?? [];
        } catch (\Exception $e) {
            Err::expLog($e, Err::DATABASE, 'DatabaseGetData');
        } finally {
            return [];
        }
    }

    /**
     * Add rows data to the db.
     * @param string $sql
     * @param array|null $bin
     * @return bool
     */
    public static function addData(string $sql, ?array $bin = null): bool {
        self::openAutoConn(); // auto connection
        try {
            $db = self::getConnection()->prepare($sql);
            $db->execute($bin);
            self::closeAutoConn(); // auto connection
            return $db->rowCount();
        } catch (\Exception $e) {
            Err::expLog($e, Err::DATABASE, 'DatabaseAddData');
        } finally {
            return false;
        }
    }

    /**
     * Delete rows data from db.
     * @param string $sql
     * @param array|null $bin
     * @return bool
     */
    public static function delData(string $sql, ?array $bin = null): bool {
        self::openAutoConn(); // auto connection
        try {
            $db = self::getConnection()->prepare($sql);
            $db->execute($bin);
            self::closeAutoConn(); // auto connection
            return $db->rowCount();
        } catch (\Exception $e) {
            Err::expLog($e, Err::DATABASE, 'DatabaseDelData');
        } finally {
            return false;
        }
    }

    /**
     * Database execute.
     * @param string $sql
     * @param array|null $bin
     * @return bool
     */
    public static function execute(string $sql, ?array $bin = null): bool {
        self::openAutoConn(); // auto connection
        try {
            $db = self::getConnection()->prepare($sql);
            $act = $db->execute($bin);
            self::closeAutoConn(); // auto connection
            return $act;
        } catch (\Exception $e) {
            Err::expLog($e, Err::DATABASE, 'DatabaseExecute');
        } finally {
            return false;
        }
    }

    /**
     * The query class handle.
     * @return Query
     */
    public static function query(): Query {
        return new Query();
    }
}