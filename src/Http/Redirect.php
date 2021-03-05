<?php
/**
 * The http redirect class.
 * The http redirect class for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Http;

use Irmmr\Handle\Data;
use Irmmr\Handle\Http;

/**
 * Class Redirect
 * @package Irmmr\Handle\Http
 */
class Redirect
{
    /**
     * Redirect to new url.
     * @param string $url
     * @param bool $exit
     */
    public function to(string $url, bool $exit = true): void {
        if (!Http::header()->sent()) {
            Http::header()->set('Location', $url);
        } else {
            $this->noScript($url);
        }
        $exit and exit;
    }

    /**
     * No script redirect using html.
     * Not recommended!
     * @param string $url
     * @param int $timer Based on seconds
     */
    public function noScript(string $url, int $timer = 0): void {
        echo "<meta http-equiv=\"refresh\" content=\"{$timer};url={$url}\">";
    }

    /**
     * Script redirect using javascript.
     * Not recommended!
     * @param string $url
     * @param int $timer Based on seconds
     */
    public function script(string $url, int $timer = 0): void {
        $randName = Data::rand()->strLow();
        echo "<script>
            function redirectForce_{$randName}(url) {
                if (window.console) {
                    console.info('Attempt to redirect to:', url);
                    console.warn('If you are still here, there is an error in the service.');
                }
                window.location.href = url;
            }
            window.setTimeout(function () {redirectForce_{$randName}(\"{$url}\")}, {$timer}*1000);
            </script>";
    }
}