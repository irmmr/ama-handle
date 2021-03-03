<?php
/**
 * The file dir class.
 * This just for dir methods.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Filer;

use Irmmr\Handle\Filer;

/**
 * Class FilerDir
 * @package Irmmr\Handle\Filer
 */
class FilerDir extends Filer
{
    /**
     * Get dir list or contents for filer.
     * @param string $path
     * @return array|false
     */
    public function list(string $path): array {
        if (parent::isDirExists($path)) {
            $contents = @scandir($path);
            if (is_array($contents)) {
                return array_diff($contents, ['.', '..']);
            }
        }
        return false;
    }

    /**
     * Delete dir if exists.
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool {
        return self::isDirExists($path) ? @rmdir($path) : false;
    }

    /**
     * Create a dir if not exists.
     * @param string $path
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    public function make(string $path, int $mode = 0777, bool $recursive = true): bool {
        return !self::isDirExists($path) ?
            @mkdir($path, $mode, $recursive) : false;
    }
}