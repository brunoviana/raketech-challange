<?php

namespace App\Providers;

use App\Raketech\Adapter\EmptyCollectionProviderAdapter;
use App\Raketech\Flag;
use App\Raketech\FlagInterface;
use App\Raketech\FlagProviderInterface;
use App\Raketech\FlagsCollection;
use App\Raketech\FlagsCollectionInterface;
use Illuminate\Support\ServiceProvider;

class FlagsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlagInterface::class, Flag::class);
        $this->app->bind(FlagsCollectionInterface::class, FlagsCollection::class);

        $this->app->singleton(FlagProviderInterface::class, function($app) {
            $configProviders = config("flags.providers");

            $defaultProviderKey = config('flags.default_provider');
            $defaultProvider = $configProviders[$defaultProviderKey];

            unset($configProviders[$defaultProviderKey]);

            $providers = [$defaultProviderKey => $defaultProvider, ...$configProviders];

            foreach ($providers as $providerName) {
                /** @var FlagProviderInterface $provider */
                $provider = new $providerName;

                if ($provider->testConnection() ) {
                    return $provider;
                }
            }

            return new EmptyCollectionProviderAdapter();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
