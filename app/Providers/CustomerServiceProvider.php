<?php

namespace App\Providers;


use App\Services\Customer\Contracts\ImporterContract;
use App\Services\Customer\Helpers\XmlParseHelper;
use App\Services\Customer\Importer;
use App\Services\Customer\Manager;
use Doctrine\ORM\EntityManagerInterface;
use DOMDocument;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->configure('customer');

        $this->app->singleton('customer.manager', function ($app) {
            return new Manager($app, $app->make('config'), $app->make(Factory::class));
        });

        $this->app->bind(ImporterContract::class, function ($app) {
            return new Importer(
                $app->make('customer.manager'),
                $app->make(EntityManagerInterface::class),
                $app->make(Dispatcher::class)
            );
        });
        $this->app->singleton(XmlParseHelper::class, fn() => new XmlParseHelper(new DOMDocument()));
    }

    public function provides()
    {
        return [
            'customer.manager'
        ];
    }
}
