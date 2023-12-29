<?php

namespace App\Raketech;

interface FlagProviderInterface
{
    public function provide(): FlagsCollectionInterface;

    public function testConnection(): bool;
}
