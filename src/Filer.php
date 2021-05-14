<?php
/**
 * The filer class.
 * The file is a file and directory handle ofr ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Filer\Dir;
use Irmmr\Handle\Filer\File;
use Irmmr\Handle\Filer\Extract;

/**
 * Class Filer
 * @package Irmmr\Handle
 */
class Filer
{
    /**
     * Check if file exists.
     *
     * @param string $path
     * @return bool
     */
    public static function isExists(string $path): bool {
        return file_exists($path);
    }

    /**
     * Check if a file exists.
     *
     * @param string $path
     * @return bool
     */
    public static function isFileExists(string $path): bool {
        return self::isExists($path) && self::isFile($path);
    }

    /**
     * Check if a dir exists.
     *
     * @param string $path
     * @return bool
     */
    public static function isDirExists(string $path): bool {
        return self::isExists($path) && self::isDir($path);
    }

    /**
     * Check if file writeable.
     *
     * @param string $path
     * @return bool
     */
    public static function isWriteable(string $path): bool {
        return @is_writeable($path);
    }

    /**
     * Check if file is readable.
     *
     * @param string $path
     * @return bool
     */
    public static function isReadable(string $path): bool {
        return @is_readable($path);
    }

    /**
     * Check if path is dir and exists.
     *
     * @param string $path
     * @return bool
     */
    public static function isDir(string $path): bool {
        return @is_dir($path);
    }

    /**
     * Check if path is a file.
     *
     * @param string $path
     * @return bool
     */
    public static function isFile(string $path): bool {
        return @is_file($path);
    }

    /**
     * File file class.
     *
     * @return File
     */
    public static function file(): File {
        return new File();
    }

    /**
     * File dir class.
     *
     * @return Dir
     */
    public static function dir(): Dir {
        return new Dir();
    }

    /**
     * File dir extract.
     *
     * @param string ...$path
     * @return Extract
     */
    public static function extract(string ...$path): Extract {
        return new Extract($path);
    }
}