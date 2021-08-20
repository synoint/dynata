<?php

namespace Syno\Dynata\Demand\Resources;

use Syno\Dynata\Demand\Client;

class SupplySource
{
    private const ENDPOINT = '/sources';

    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getAll(): array
    {
        return $this->client->getAll(self::ENDPOINT);
    }
}