<?php

namespace Syno\Dynata\Demand\Resources;

use Syno\Dynata\Demand\Client;

class Event
{
    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function all(): array
    {
        return $this->client->get('/events');
    }

    public function get(string $eventId): array
    {
        return $this->client->get('/events/' . $eventId);
    }
}