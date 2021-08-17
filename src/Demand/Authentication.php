<?php

namespace Syno\Dynata\Demand;

class Authentication
{
    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function obtainAccessToken(string $password, string $username): array
    {
        return $this->client->post('/token/password',
            [
                'clientId' => $this->client::CLIENT_ID,
                'password' => $password,
                'username' => $username
            ]);
    }

    public function refreshAccessToken(string $refreshToken): array
    {
        return $this->client->post('/token/refresh',
            [
                'clientId'     => $this->client::CLIENT_ID,
                'refreshToken' => $refreshToken
            ]);
    }

    public function logout(string $refreshToken, string $accessToken): array
    {
        return $this->client->post('/logout',
            [
                'clientId'     => $this->client::CLIENT_ID,
                'refreshToken' => $refreshToken,
                'accessToken'  => $accessToken
            ]);
    }
}