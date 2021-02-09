<?php
declare(strict_types=1);

namespace App\Services\Customer\Drivers;

use App\Services\Customer\Contracts\ClientContract;
use App\Services\Customer\Helpers\XmlParseHelper;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;

class RandomUserXmlDriver implements ClientContract
{
    private PendingRequest $request;
    private XmlParseHelper $helper;
    private array $config;

    public function __construct(PendingRequest $request, XmlParseHelper $helper, array $config)
    {
        $this->request = $request;
        $this->config = $config;
        $this->helper = $helper;
    }

    /**
     * @inheritDoc
     */
    public function results(array $options = []): Collection
    {
        $request = $this->request->get(
            $this->config['version'],
            $this->generateQueryParams($options)
        );

        return new Collection($this->helper->parse($request->body()));
    }

    private function generateQueryParams(array $options): array
    {
        return [
            'nationalities' => implode(',', $this->config['nationalities']),
            'inc' => implode(',', $this->config['fields']),
            'results' => (int)($options['count'] ?? $this->config['count']),
            'format' => 'xml'
        ];
    }
}
