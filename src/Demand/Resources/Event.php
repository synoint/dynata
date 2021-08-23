<?php

namespace Syno\Dynata\Demand\Resources;

use Syno\Dynata\Demand\Client;

class Event
{
    private const ENDPOINT = '/events';

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

    public function get(string $eventId): array
    {
        return $this->client->getAll(self::ENDPOINT . '/' . $eventId);
    }
}