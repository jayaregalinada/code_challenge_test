<?php
declare(strict_types=1);

namespace Stubs;

use App\Entities\Customer;
use App\Services\Customer\Contracts\ToImportContract;
use Illuminate\Support\Arr;
use function _\get;

class ImporterClassStub implements ToImportContract
{
    /**
     * @param mixed[] $row
     * @param Customer|null $customer
     * @return Customer
     */
    public function toImport($row, Customer $customer = null): Customer
    {
        $customer = ($customer ?? new Customer())
            ->setFirstName(Arr::get($row, 'name.first'))
            ->setLastName(get($row, 'name.last'))
            ->setUsername(get($row, 'login.username'))
            ->setGender(get($row, 'gender') === 'male' ? 0 : 1)
            ->setCountry(get($row, 'location.country'))
            ->setCity(get($row, 'location.city'))
            ->setPhone(get($row, 'phone'))
            ->setPassword(get($row, 'login.md5'));

        if ($customer !== null) {
            $customer->setEmail(get($row, 'email'));
        }

        return $customer;
    }
}
