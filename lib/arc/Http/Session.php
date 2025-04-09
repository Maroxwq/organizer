<?php declare(strict_types=1);

namespace Arc\Http;

class Session {
    public function __construct()
    {
        session_start();
    }

    // public function __destruct()
    // {
    //     session_destroy();
    // }

    public function set(string $key, string $value): self
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function setFlash(string $key, string $value): self
    {
        $_SESSION['flash_messages'][$key] = $value;

        return $this;
    }

    public function getFlash(string $key): ?string
    {
        $flash = $_SESSION['flash_messages'][$key] ?? null;
        unset($_SESSION['flash_messages'][$key]);

        return $flash;
    }
}
