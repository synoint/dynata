<?php

namespace Syno\Dynata\Demand\Resources;

use Syno\Dynata\Demand\Client;

class Study
{
    private const ENDPOINT = '/studyMetadata';

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