<?php


class Cookies
{
    private array $cookies;

    public function __construct()
    {
        $this->cookies = $_COOKIE;
    }

    public function setCookie(string $name, string $value): void
    {
        setcookie("{$name}", "{$value}", time() + 3600, '/');
        $this->cookies[$name] = $value;
    }

    public function getCookie(string $name)
    {
        return $this->cookies[$name] ?? '';
    }

    public function getAllCookies(): array
    {
        return $this->cookies;
    }

    public function delCookie(string $name): void
    {
        setcookie("{$name}",'',time() - 3600, '/');
        $this->cookies[$name] = '';
    }
}