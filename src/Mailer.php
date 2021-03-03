<?php
/**
 * The mailer class.
 * The mailer handle for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Mailer\Smtp;

/**
 * Class Mailer
 * @package Irmmr\Handle
 */
class Mailer
{
    /**
     * Send email as smtp protocol.
     * @return Smtp
     */
    public static function smtp(): Smtp {
        return new Smtp();
    }
}