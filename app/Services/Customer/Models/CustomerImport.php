<?php

namespace App\Services\Customer\Models;

use function _\get;
use App\Entities\Customer;
use App\Services\Customer\Contracts\ToImportContract;

class CustomerImport implements ToImportContract
{
    const MALE = 'male';

    const FEMALE = 'female';

    /**
     * @param array $row
     * @param \App\Entities\Customer|null    $customer
     *
     * @return \App\Entities\Customer
     */

     public function toImport($row, Customer $customer = null) : Customer
     {
        $customer = ($customer ?? new Customer())
            ->setFirstName(get($row, 'name.first'))
            ->setLastName(get($row, 'name.last'))
            ->setUsername(get($row, 'login.username'))
            ->setGender(get($row, 'gender') == self::MALE ? 0 : 1)
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
