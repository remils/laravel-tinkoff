<?php

namespace Remils\LaravelTinkoff\Dto;

use Illuminate\Support\Collection;

class TerminalDto
{
    protected $url;

    protected $key;

    protected $password;

    public function __construct(Collection $data)
    {
        $this->url      = $data->get('url');
        $this->key      = $data->get('key');
        $this->password = $data->get('password');
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
