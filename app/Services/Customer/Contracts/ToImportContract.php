<?php

namespace App\Services\Customer\Contracts;

use App\Entities\Customer;

interface ToImportContract
{
    /**
     * @param array|mixed                         $row
     *
     * @param \App\Entities\Customer|null $customer
     *
     * @return \App\Entities\Customer
     */
    public function toImport($row, Customer $customer = null) : Customer;
}
