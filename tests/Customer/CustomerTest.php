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

    public function testCustomerList()
    {
        $this->get('customers');
        $this->assertResponseOk();
    }

    public function testSingleCustomer()
    {
        $this->get('customers/1');
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => ['full_name', 'email', 'username', 'gender', 'country', 'city', 'phone'],
        ]);
    }

    public function testCustomerNextPage()
    {
        $this->get('customers/?page=2');
        $this->assertResponseOk();
    }

    public function testCustomerListWithValidOrderQuery()
    {
        $this->get('customers/?order=ASC');
        $this->assertResponseOk();
        $this->get('customers/?order=DESC');
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'full_name',
                    'email',
                    'country',
                ],
            ],
        ]);
    }

    public function testCustomerListWithInvalidOrderQuery()
    {
        $this->get('customers/?order=latest');
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->get('customers/?order=asc');
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->get('customers/?order=desc');
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCustomerNotFound()
    {
        $this->get('customers/9999999');
        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
}
