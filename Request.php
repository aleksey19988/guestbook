<?php


class Request
{
    private array $query;
    private array $request;
    private array $server;

    public function __construct()
    {
        $this->query = $_GET;
        $this->request = $_POST;
        $this->server = $_SERVER;
    }

    public function getQuery(string $name)
    {
        return $this->query[$name] ?? null;
    }

    public function getRequest(string $name)
    {
        return $this->request[$name] ?? null;
    }

    public function isPost(): bool
    {
        return count($this->request) > 0;
    }

    public function userAgent(): string
    {
        return $this->server['HTTP_USER_AGENT'] ?? '';
    }

    public function getIpAddress()
    {
        return $this->server['REMOTE_ADDR'] ?? '';
    }
}