<?php

namespace Syno\Dynata\Demand\Resources;

use Syno\Dynata\Demand\Client;

class LineItem
{
    private const ENDPOINT = '/countries';

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