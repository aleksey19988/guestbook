<?php


class Request
{
    private array $query;
    private array $request;
    private array $server;
    private array $files;

    public function __construct()
    {
        $this->query = $_GET;
        $this->request = $_POST;
        $this->server = $_SERVER;
        $this->files = $_FILES;
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

    public function getFiles(): array
    {
        return $this->files ?? [];
    }
}