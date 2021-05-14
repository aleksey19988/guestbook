<?php


class Request
{
    private array $query;
    private array $request;
    private array $server;
    private array $files;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->query = $_GET;
        $this->request = $_POST;
        $this->server = $_SERVER;
        $this->files = $_FILES;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getQuery(string $name)
    {
        return $this->query[$name] ?? null;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getRequest(string $name)
    {
        return $this->request[$name] ?? null;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return count($this->request) > 0;
    }

    /**
     * @return string
     */
    public function userAgent(): string
    {
        return $this->server['HTTP_USER_AGENT'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getIpAddress()
    {
        return $this->server['REMOTE_ADDR'] ?? '';
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files ?? [];
    }
}