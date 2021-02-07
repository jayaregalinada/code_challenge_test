<?php

namespace App\Services\Customer\Contracts;

interface ImporterContract {
    /**
     * @param \App\Services\Customer\Contracts\ToImportContract|string $contract
     * @param array                                                $options
     */
    public function import($contract, array $options = []) : void;
}
