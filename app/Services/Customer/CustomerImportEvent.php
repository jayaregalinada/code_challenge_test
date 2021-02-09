<?php

namespace App\Services\Customer;

class CustomerImportEvent
{
    /**
     * @var mixed[] $results
     */
    public array $results;

    public int $index;

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param array $results
     */
    public function setResults(array $results): CustomerImportEvent
    {
        $this->results = $results;

        return $this;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param int $index
     */
    public function setIndex(int $index): CustomerImportEvent
    {
        $this->index = $index;

        return $this;
    }
}
