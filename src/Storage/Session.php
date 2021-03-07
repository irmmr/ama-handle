<?php
/**
 * The storage session class.
 * The storage session class for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Storage;

/**
 * Class Session
 * @package Irmmr\Handle\Storage
 */
class Session
{
    /**
     * Auto start session.
     * @var bool
     */
    private bool $autoStart;

    /**
     * Session constructor.
     * @param bool $autoStart
     */
    public function __construct(bool $autoStart = true) {
        $this->autoStart = $autoStart;
    }

    /**
     * Start a session.
     * @param array $options
     * @return bool
     */
    public function start(array $options = []): bool {
        return $this->isStarted() ? false : session_start($options);
    }

    /**
     * Get session status.
     * @return int
     */
    public function status(): int {
        return session_status();
    }

    /**
     * Get or change session id.
     * @param string|null $id
     * @return string
     */
    public function id(string $id = null): string {
        return session_id($id);
    }

    /**
     * Check session status.
     * @param int $status
     * @return bool
     */
    public function isStatus(int $status): bool {
        return $this->status() === $status;
    }

    /**
     * Check if session started.
     * @return bool
     */
    public function isStarted(): bool {
        return $this->isStatus(PHP_SESSION_ACTIVE);
    }

    /**
     * Abort session.
     * @return bool
     */
    public function abort(): bool {
        return session_abort();
    }

    /**
     * Destroy session.
     * @return bool
     */
    public function destroy(): bool {
        return $this->isStarted() ? session_destroy() : false;
    }

    /**
     * Get a session data.
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function get(string $name, $default = null) {
        if ($this->autoStart) {
            $this->start();
        }
        return $_SESSION[$name] ?? $default;
    }

    /**
     * Check if a session is exists.
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool {
        return isset($_SESSION[$name]);
    }

    /**
     * @param string $name
     * @param $value
     * @return void
     */
    public function set(string $name, $value): void {
        if ($this->autoStart) {
            $this->start();
        }
        $_SESSION[$name] = $value;
    }

    /**
     * Reset session data.
     * @return bool
     */
    public function reset(): bool {
        return session_reset();
    }

    /**
     * Set multi sessions as array.
     * @param array ...$sessions
     */
    public function setMulti(array ...$sessions): void {
        if (empty($sessions)) {
            return;
        }
        foreach ($sessions as $session) {
            $name = $session[0] ?? '';
            if (empty($name) || !is_string($name)) {
                continue;
            }
            $this->set(trim($name), $session[1] ?? null);
        }
    }

    /**
     * Get session list.
     * @return array
     */
    public function list(): array {
        if (!isset($_SESSION) || !is_array($_SESSION)) {
            return [];
        }
        return $_SESSION;
    }
}