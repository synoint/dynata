<?php

namespace Syno\Dynata\Demand;

use Psr\Http\Message\ResponseInterface;
use Syno\Dynata\HttpClient;
use Syno\Dynata\Demand\Authentication\Resources\Auth;
use GuzzleHttp\Exception\RequestException;

class Client
{
    public string $accessToken;

    private HttpClient $client;
    private Auth       $auth;
    private string     $apiUrl;

    public function __construct(
        Auth    $auth,
        string  $apiUrl
    )
    {
        $this->apiUrl  = $apiUrl;
        $this->auth    = $auth;
        $this->client  = new HttpClient();
    }

    public function authenticate(string $username, string $password): Client
    {
        $this->accessToken = $this->auth->obtainAccessToken($username, $password);

        return $this;
    }

    public function getAll(string $url): array
    {
        $data   = [];

        while($url) {

            $response = $this->get($url);

            $url = null;

            if(isset($response['data'])){
                $data = array_merge($data, $response['data']);

                if(isset($response['meta']['links']['next'])){
                    $url = str_replace($this->apiUrl, '', $response['meta']['links']['next']);
                }
            }
        }

        return $data;
    }

    public function get(string $uri, array $parameters = null): array
    {
        return $this->request('GET', $uri, $parameters);
    }

    public function post(string $uri, array $parameters = null): array
    {
        return $this->request('POST', $uri, $parameters);
    }

    public function patch(string $uri, array $parameters = null): array
    {
        return $this->request('PATCH', $uri, $parameters);
    }

    public function put(string $uri, array $parameters = null): array
    {
        return $this->request('PUT', $uri, $parameters);
    }

    public function delete(string $uri, array $parameters = null): array
    {
        return $this->request('DELETE', $uri, $parameters);
    }

    private function request(string $requestType, string $url, ?array $parameters): array
    {
        try {
            $response = $this->client->request(
                $requestType,
                $this->apiUrl . $url, $this->setParameters($requestType, $parameters)
            );

            $result = $this->getSuccessResponse($response);

        } catch (RequestException $exception) {
            $result = $this->getErrorResponse($exception->getResponse());
        }

        return $result;
    }

    private function setParameters(string $requestType, ?array $parameters): array
    {
        $headerParameters = [
            'headers' => ['Authorization' => 'Bearer '.$this->accessToken]
        ];

        if (!empty($parameters)) {
            $parameters = array_merge($headerParameters, [($requestType == 'GET' ? 'query' : 'json') => $parameters]);
        } else {
            $parameters = $headerParameters;
        }

        return $parameters;
    }

    private function getSuccessResponse(ResponseInterface $response): array
    {
        $result = json_decode($response->getBody()->getContents(), true);
        return $result !== null ? $result : [];
    }

    private function getErrorResponse(ResponseInterface $response): array
    {
        $result = json_decode($response->getBody()->getContents(), true);

        if(isset($result['message'])) {
            $result = ['errors'=>[['field' => '', 'message' => $result['message']]]];
        }

        return $result !== null ? $result : [];
    }
}
