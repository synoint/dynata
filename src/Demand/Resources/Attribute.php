<?php

namespace Syno\Dynata\Demand\Resources;

use Syno\Dynata\Demand\Client;

class Attribute
{
    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $countryCode, string $languageCode): array
    {
        return $this->client->getAll(sprintf('/attributes/%s/%s', $countryCode, $languageCode));
    }
}