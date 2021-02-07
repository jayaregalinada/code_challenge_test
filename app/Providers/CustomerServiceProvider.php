<?php

namespace App\Providers;


use Illuminate\Http\Client\Factory;
use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Support\DeferrableProvider;

use App\Services\Customer\Manager;
use App\Services\Customer\Importer;
use App\Services\Customer\Contracts\ImporterContract;

class CustomerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->configure('customer');

        $this->app->singleton('customer.manager', function($app) {
            return new Manager($app, $app->make('config'), $app->make(Factory::class));
        });

        $this->app->bind(ImporterContract::class, function ($app) {
            return new Importer(
                $app->make('customer.manager'),
                $app->make(EntityManagerInterface::class),
                $app->make(Dispatcher::class)
            );
        });

    }

    public function provides()
    {
        return [
            'customer.manager'
        ];
    }
}
