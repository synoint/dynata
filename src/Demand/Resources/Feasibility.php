<?php

namespace Syno\Dynata\Demand\Resources;

use Syno\Dynata\Demand\Client;

class Feasibility
{
    private const ENDPOINT = '/projects/%s/feasibility';

    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getAll(string $projectId): array
    {
        return $this->client->getAll(sprintf(self::ENDPOINT, $projectId));
    }
}