<?php

namespace App\Raketech;

interface FlagInterface
{
    public function setCountryName(string $countryName): void;

    public function getCountryName(): string;

    public function setUrl(string $url): void;

    public function getUrl(): string;
}
