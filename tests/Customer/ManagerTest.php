<?php

namespace Customer;

use TestCase;
use App\Services\Customer\Manager;
use Illuminate\Http\Client\Factory;

class ManagerTest extends TestCase
{

    public function testCustomDriver()
    {
        $manager = new Manager(
            $this->app,
            $this->app['config']->set('customer.importer_drivers.' . __CLASS__, [
                'driver' => __CLASS__
            ]),
            $this->app[Factory::class]->fake()
        );

        $manager->extend(__CLASS__, function () {
            return $this;
        });
        $this->assertEquals($manager, $manager->driver(__CLASS__));
    }

    /**
     * @expectException \InvalidArgumentException::class
     */
    // public function testCustomDriverNotFound()
    // {
    //     $this->expectException(\InvalidArgumentException::class);

    //     $manager = new Manager(
    //         $this->app,
    //         $this->app['config']->set('customer.importer_drivers.' . __CLASS__, [
    //             'driver' => __CLASS__
    //         ]),
    //         $this->app[Factory::class]->fake()
    //     );
    // }

    public function testSetCustomDriverAsDefault()
    {
        $manager = new Manager(
            $this->app,
            $this->app['config']->set('customer.importer_drivers.' . __CLASS__, [
                'driver' => __CLASS__
            ]),
            $this->app[Factory::class]->fake()
        );
        $manager->extend(__CLASS__, function () {
            return $this;
        });
        $manager->setDefaultDriver(__CLASS__);
        $this->assertSame(__CLASS__, $manager->getDefaultDriver());
    }
}
