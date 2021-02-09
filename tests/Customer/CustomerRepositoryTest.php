<?php
declare(strict_types=1);

namespace Customer;

use App\Entities\Customer;
use App\Repositories\CustomerRepository;
use Cassandra\Custom;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\ToolsException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

/**
 * @covers \App\Repositories\CustomerRepository
 */
class CustomerRepositoryTest extends TestCase
{
    private CustomerRepository $customerRepository;

    public function testIfAllIsCorrectCount(): void
    {
        entity(Customer::class, 10)->create();
        self::assertSame(10, $this->customerRepository->all()->total());
    }

    public function testIfAscendingIsCorrect(): void
    {
        entity(Customer::class)->create([
            'email' => 'foo@example.com'
        ]);
        entity(Customer::class)->create([
            'email' => 'bar@example.com'
        ]);
        /** @var Customer $customer */
        $customer = $this->customerRepository->all(Criteria::ASC)->first();
        self::assertSame('foo@example.com', $customer->getEmail());
    }

    protected function setUp(): void
    {
        parent::setUp();
        try {
            $this->artisan('doctrine:schema:create');
        } catch (ToolsException $e) {
        }
        $this->beforeApplicationDestroyed(function () {
            $this->artisan('doctrine:schema:drop', [
                '--force' => true
            ]);
        });
        $this->customerRepository = $this->app->make(EntityManagerInterface::class)
            ->getRepository(Customer::class);
    }
}
