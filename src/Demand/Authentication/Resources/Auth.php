<?php

namespace Syno\Dynata\Demand\Authentication\Resources;

use Syno\Dynata\Demand\Authentication\Client;
use GuzzleHttp;

class Auth
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function obtainAccessToken(string $username, string $password): string
    {
        $response = $this->client->post(
            sprintf('%s/token/password', $this->client->getApiUrl()),
            [
                GuzzleHttp\RequestOptions::JSON =>
                    [
                        'clientId' => $this->client->getClientId(),
                        'password' => $password,
                        'username' => $username
                    ]
            ]
        );

        $body = json_decode($response->getBody()->getContents(), true);

        return $body['accessToken'];
    }
}
