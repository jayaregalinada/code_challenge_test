<?php

namespace App\Services\Customer;

use App\Services\Customer\Contracts\ClientContract;
use App\Services\Customer\Drivers\RandomUserXmlDriver;
use App\Services\Customer\Helpers\XmlParseHelper;
use Closure;
use InvalidArgumentException;
use Illuminate\Config\Repository;
use Illuminate\Http\Client\Factory;
use Illuminate\Contracts\Events\Dispatcher;
use App\Services\Customer\RandomUserClient;

class Manager
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $drivers = [];

    /**
     * @var array
     */
    protected $customDrivers = [];

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var \Illuminate\Http\Client\Factory
     */
    protected $factory;

    /**
     * Manager constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Container\Container $app
     * @param \Illuminate\Config\Repository|null                                                     $config
     * @param \Illuminate\Http\Client\Factory|null                                                   $factory
     */

    public function __construct($app, Repository $config = null, Factory $factory = null)
    {
        $this->app = $app;
        $this->config = $config ?? $this->app['config'];
        $this->factory = $factory ?? $this->app[Factory::class];
    }

    public function setDefaultDriver($name): void
    {
        $this->config->set('customer.importer_default_driver', $name);
    }

    public function getDefaultDriver() : string
    {
        return $this->config->get('customer.importer_default_driver');
    }

    public function extend($driver, Closure $callback) : Manager
    {
        $this->customDrivers[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }

    public function driver($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
        return $this->drivers[$name] = $this->getDriver($name);
    }

    private function getDriver($name)
    {
        return $this->drivers[$name] ?? $this->resolve($name);
    }

    private function resolve($name)
    {
        $config = $this->getConfig($name);

        if ($config === null) {
            throw new InvalidArgumentException("Customer Importer client [${name}] is not defined.");
        }

        if (isset($this->customDrivers[$config['driver']])) {
            return $this->callCustomDriver($config);
        }

        $method = 'create' . ucfirst($config['driver']) . 'Driver';

        if (method_exists($this, $method)) {
            return $this->{$method}($config);
        }

        throw new InvalidArgumentException("Driver [${config['driver']}] is not supported.");
    }

    private function getConfig($name)
    {
        return $this->config->get("customer.importer_drivers.${name}");
    }

    private function callCustomDriver(array $config)
    {
        return $this->customDrivers[$config['driver']]($this->app, $config);
    }

    private function createDefaultDriver(array $config): ClientContract
    {
        return new RandomUserClient(
            $this->factory->baseUrl($config['url'])->asForm(),
            $config
        );
    }

    private function createXmlDriver(array $config): ClientContract
    {
        return new RandomUserXmlDriver(
            $this->factory->baseUrl($config['url'])->asForm(),
            $this->app->make(XmlParseHelper::class),
            $config
        );
    }

}

