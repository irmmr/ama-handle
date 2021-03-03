<?php
/**
 * The error class.
 * This class load and run all error reporting and handling actions.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\App;

/**
 * Class Error
 * @package Irmmr\Handle\App
 */
class Error
{
    /**
     * Ama error stopper.
     * @param string $message
     * @param int $code
     * @param string $file
     * @param int $line
     * @param int $level
     */
    public static function stop(string $message, int $code, string $file, int $line, int $level): void {
        $page = Theme::get('error-normal');
        // Add error if we are in dev mode
        if (AMA_HANDLE_CONF['dev']) {
            $text = @file($file);
            $arr = array_slice($text, 0, $line);
            if (array_key_exists($line, $text)) {
                $arr[] = str_replace(PHP_EOL, '', $text[$line]);
            }
            $coder = count($text) >= $line ? implode('', $arr) : '';
            $page = Theme::get('error-handler', [
                'msg' => $message,
                'code' => $code,
                'file' => $file,
                'line' => $line,
                'level' => $level,
                'date' => date('Y-m-d H:i:s'),
                'text' => $coder
            ]);
        }
        // Stop all actions and die!
        die($page);
    }
}