<?php

namespace Customer;

use TestCase;
use App\Entities\Customer;
use Illuminate\Http\Response;
use Doctrine\ORM\Tools\ToolsException;

class CustomerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        try {
            $this->artisan('doctrine:schema:create');
            entity(Customer::class, 30)->create();
        } catch (ToolsException $th) {

        }

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('doctrine:schema:drop');
        });
    }

    protected function tearDown() : void
    {
        $this->artisan('doctrine:schema:drop', [
            '--force' => true,
        ]);
    }

    public function test_customer_list()
    {
        $this->get('customers');
        $this->assertResponseOk();
    }
}
