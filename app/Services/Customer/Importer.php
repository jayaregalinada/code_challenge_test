<?php

namespace App\Services\Customer;

use App\Entities\Customer;
use App\Services\Customer\Manager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Events\Dispatcher;
use App\Services\Customer\Contracts\ImporterContract;

class Importer implements ImporterContract
{

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $dispatcher;

    /**
     * @var \App\Services\Customer\Manager
     */
    protected $manager;

    public function __construct(Manager $manager, EntityManagerInterface $entityManager, Dispatcher $dispatcher)
    {
        $this->manager = $manager;
        $this->entityManager = $entityManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param \App\Services\Customer\Contracts\ToImportContract|string  $contract
     * @param array                                                     $options
     */
    public function import($contract, array $options = []) : void
    {
        $results = $this->manager->results($options);
        $results->each(function ($result, $index) use ($contract) {
            $this->entityManager->persist(
                $this->createOrUpdate($this->checkIfString($contract), $result)
            );
            $this->dispatchPersist($result, $index);
        });

        $this->entityManager->flush();
    }

    /**
     * @param \App\Services\Customer\Contracts\ToImportContract|string $contract
     *
     * @return \App\Services\Customer\Contracts\ToImportContract
     */
    protected function checkIfString($contract)
    {
        return is_string($contract) ? new $contract : $contract;
    }

    /**
     * @param \App\Entities\Customer $customer
     *
     * @return \App\Entities\Customer|object
     */
    protected function findEntity(Customer $customer) : Customer
    {
        return $this->entityManager->getRepository(get_class($customer))
                ->findOneBy(['email' => $customer->getEmail()]) ?? $customer;
    }

    protected function dispatchPersist($result, $index) : void
    {
        if ($this->dispatcher !== null) {
            $this->dispatcher->dispatch('customer.import', compact('result', 'index'));
        }
    }

     /**
     * @param \App\Services\Customer\Contracts\ToImportContract $contract
     * @param array|mixed                                   $result
     *
     * @return \App\Entities\Customer
     */
    protected function createOrUpdate($contract, $result) : Customer
    {
        $importClass = $contract->toImport($result);
        $entity = $this->findEntity($importClass);
        if ($entity->getId() !== null) {
            return $contract->toImport($result, $entity);
        }

        return $importClass;
    }
}
