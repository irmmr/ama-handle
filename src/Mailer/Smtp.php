<?php
/**
 * The mailer smtp class.
 * The mailer smtp handle for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Mailer;

use Irmmr\Handle\Err;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP as Smt;
use PHPMailer\PHPMailer\Exception;

/**
 * Class Smtp
 * @package Irmmr\Handle\Mailer
 */
class Smtp
{
    /**
     * From destination.
     * @var string|null
     */
    private ?string $from = null;

    /**
     * From name.
     * @var string|null
     */
    private ?string $fromName = null;

    /**
     * To list.
     * @var array
     */
    private array $to = [];

    /**
     * The php mailer main handle.
     * @var PHPMailer|null
     */
    private ?PHPMailer $mail = null;

    /**
     * Smtp constructor.
     */
    public function __construct() {
        $this->mail = new PHPMailer();
        $this->mail->isSMTP(); // send email as a smtp mail
        // manage smtp server settings
        $this->mail->Host       = AMA_HANDLE_EMS['host'];
        $this->mail->SMTPAuth   = AMA_HANDLE_EMS['auth'];
        $this->mail->Username   = AMA_HANDLE_EMS['user'];
        $this->mail->Password   = AMA_HANDLE_EMS['pass'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = AMA_HANDLE_EMS['port'];
        $this->mail->SMTPDebug  = Smt::DEBUG_SERVER;
        // Set mail charset to utf-8
        $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
        // set mail type as html
        $this->mail->isHTML();
        // set optional from
        $this->from(AMA_HANDLE_EMS['mail'], AMA_HANDLE_EMS['name']);
        // error handle
        $this->mail->Debugoutput = function ($message, $level) {
            Err::log($message, 'mailer', 0, 'SmtpMailer', $level);
        };
    }

    /**
     * Change debug mode.
     * @param int $mode
     * @return $this
     */
    public function debug(int $mode): Smtp {
        $this->mail->SMTPDebug = $mode;
        return $this;
    }

    /**
     * Set from.
     * @param string $mail
     * @param string|null $name
     * @return $this
     */
    public function from(string $mail, ?string $name = null): Smtp {
        try {
            $this->from = $mail;
            $this->fromName = $name;
            $this->mail->setFrom($mail, $name ?? '');
        } catch (\Exception $e) {}
        return $this;
    }

    /**
     * Add to.
     * @param string $mail
     * @param string|null $name
     * @return $this
     */
    public function to(string $mail, ?string $name = null): Smtp {
        try {
            $this->to[] = [$mail, $name];
            $this->mail->addAddress($mail, $name ?? '');
        } catch (\Exception $e) {}
        return $this;
    }

    /**
     * Add replayTo.
     * @param string $mail
     * @param string|null $name
     * @return $this
     */
    public function reply(string $mail, ?string $name = null): Smtp {
        try {
            $this->mail->addReplyTo($mail, $name ?? '');
        } catch (\Exception $e) {}
        return $this;
    }

    /**
     * Add cc.
     * @param string $mail
     * @param string|null $name
     * @return $this
     */
    public function cc(string $mail, ?string $name = null): Smtp {
        try {
            $this->mail->addCC($mail, $name ?? '');
        } catch (\Exception $e) {}
        return $this;
    }

    /**
     * Add bcc.
     * @param string $mail
     * @param string|null $name
     * @return $this
     */
    public function bcc(string $mail, ?string $name = null): Smtp {
        try {
            $this->mail->addBCC($mail, $name ?? '');
        } catch (\Exception $e) {}
        return $this;
    }

    /**
     * Set content type to html or not.
     * @param bool $status
     * @return Smtp
     */
    public function html(bool $status): Smtp {
        $this->mail->isHTML($status);
        return $this;
    }

    /**
     * Add attachment file.
     * @param string $path
     * @param string|null $file
     * @return $this
     */
    public function attach(string $path, ?string $file = null): Smtp {
        try {
            $this->mail->addAttachment($path, $file ?? '');
        } catch (\Exception $e) {}
        return $this;
    }

    /**
     * Set subject.
     * @param string $subject
     * @return $this
     */
    public function subject(string $subject): Smtp {
        $this->mail->Subject = trim($subject);
        return $this;
    }

    /**
     * Set content.
     * @param string $content
     * @return $this
     */
    public function content(string $content): Smtp {
        $this->mail->Body = trim($content);
        return $this;
    }

    /**
     * Set alt content.
     * @param string $content
     * @return $this
     */
    public function altContent(string $content): Smtp {
        $this->mail->AltBody = trim($content);
        return $this;
    }

    /**
     * Send email.
     * @return bool
     */
    public function send(): bool {
        try {
            return $this->mail->send();
        } catch (\Exception $e) {}
        return false;
    }

    /**
     * Add some custom headers.
     * @param string $header
     * @param string $value
     * @return $this
     */
    public function header(string $header, string $value): Smtp {
        try {
            $this->mail->addCustomHeader($header, $value);
        } catch (\Exception $e) {}
        return $this;
    }

    /**
     * Get the main mail handle.
     * @return PHPMailer|null
     */
    public function get(): ?PHPMailer {
        return $this->mail;
    }
}