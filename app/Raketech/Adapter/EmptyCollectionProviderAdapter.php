<?php

namespace App\Raketech\Adapter;

use App\Raketech\FlagInterface;
use App\Raketech\FlagProviderInterface;
use App\Raketech\FlagsCollectionInterface;
use Illuminate\Support\Facades\Http;

class EmptyCollectionProviderAdapter implements FlagProviderInterface
{
    public function provide(): FlagsCollectionInterface
    {
        /** @var FlagsCollectionInterface $collection */
        $collection = app()->make(FlagsCollectionInterface::class);

        return $collection;
    }

    public function testConnection(): bool
    {
        return true;
    }
}
