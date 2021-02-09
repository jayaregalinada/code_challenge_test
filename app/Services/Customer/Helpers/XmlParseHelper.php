<?php
declare(strict_types=1);

namespace App\Services\Customer\Helpers;

use DOMDocument;
use SimpleXMLElement;
use Throwable;
use function simplexml_load_string;

class XmlParseHelper
{
    private DOMDocument $document;

    /**
     * XmlParseHelper constructor.
     * @param DOMDocument $document
     */
    public function __construct(DOMDocument $document)
    {
        $this->document = $document;
    }

    public function parse(string $xml): XmlParseHelper
    {
        $this->document->loadXML($xml);

        return $this;
    }

    private function loadXml(string $xml)
    {
        try {
            return simplexml_load_string($xml);
        } catch (Throwable $exception) {
            return null;
        }
    }
}
