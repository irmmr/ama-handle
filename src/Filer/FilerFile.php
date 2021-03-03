<?php
/**
 * The file file class.
 * This just for file methods.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Filer;

use Irmmr\Handle\Filer;

/**
 * Class FilerFile
 * @package Irmmr\Handle\Filer
 */
class FilerFile extends Filer
{
    /**
     * Get file content on type string.
     * @param string $path
     * @return string
     */
    public function content(string $path): string {
        return parent::isFileExists($path) && parent::isReadable($path) ?
            @file_get_contents($path) : '';
    }

    /**
     * Write and create a file in filer.
     * @param string $path
     * @param string $content
     * @return bool
     */
    public function write(string $path, string $content = ''): bool {
        return parent::isFileExists($path) && parent::isWriteable($path) ?
            @file_put_contents($path, $content) : false;
    }

    /**
     * Append data to a file in filer.
     * @param string $path
     * @param string $content
     * @return bool
     */
    public static function append(string $path, string $content = ''): bool {
        return parent::isFileExists($path) && parent::isWriteable($path) ?
            @file_put_contents($path, $content, FILE_APPEND) : false;
    }

    /**
     * Delete a file if exists.
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool {
        return parent::isFileExists($path) ? @unlink($path) : false;
    }

    /**
     * Get file size.
     * @param string $path
     * @return int
     */
    public function size(string $path): int {
        return @filesize($path);
    }
}