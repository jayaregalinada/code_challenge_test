<?php

namespace App\Services\Customer\Contracts;

use Illuminate\Support\Collection;

interface ClientContract
{
    /**
     * @var array
     */
    public function results(array $options = []) : Collection;
}
