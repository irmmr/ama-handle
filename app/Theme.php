<?php
/**
 * The theme class.
 * This class loads all themes from assets folder to show.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\App;

/**
 * Class Theme
 * @package Irmmr\Handle\App
 */
class Theme
{
    /**
     * Get theme content.
     * @param string $theme
     * @param array $replace
     * @return string
     */
    public static function get(string $theme, array $replace = []): string {
        $path = AMA_HANDLE_PATH . '/assets/theme/' . $theme . '.html';
        if (!file_exists($path) || !@is_readable($path) || !@is_file($path)) {
            return '';
        }
        $content = @file_get_contents($path);
        if (empty($content)) {
            return $content;
        }
        foreach ($replace as $rep => $val) {
            $content = str_replace("{{$rep}}", $val, $content);
        }
        return $content;
    }

    /**
     * Print theme codes.
     * @param string $theme
     * @param array $replace
     */
    public static function do(string $theme, array $replace = []): void {
        echo self::get($theme, $replace);
    }
}