<?php

namespace App\Raketech;

class Flag implements FlagInterface
{

    protected string $countryName;

    protected $url;

    public function setCountryName(string $countryName): void
    {
        $this->countryName = $countryName;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
