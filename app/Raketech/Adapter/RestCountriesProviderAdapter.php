<?php

namespace App\Raketech\Adapter;

use App\Raketech\FlagInterface;
use App\Raketech\FlagProviderInterface;
use App\Raketech\FlagsCollectionInterface;
use Illuminate\Support\Facades\Http;

class RestCountriesProviderAdapter implements FlagProviderInterface
{
    public function provide(): FlagsCollectionInterface
    {
        /** @var FlagsCollectionInterface $collection */
        $collection = app()->make(FlagsCollectionInterface::class);

        $response = Http::get("https://restcountries.com/v3.1/all?fields=name,flags");

        foreach ($response->json() as $flagData) {
            /** @var FlagInterface $flag */
            $flag = app()->make(FlagInterface::class);

            $flag->setCountryName($flagData['name']['common']);
            $flag->setUrl($flagData['flags']['png']);

            $collection->addFlag($flag);
        }

        return $collection;
    }

    public function testConnection(): bool
    {
        $response = Http::get("https://restcountries.com/v3.1/capital/lisbon?fields=name");

        return $response->status() === 200;
    }
}
