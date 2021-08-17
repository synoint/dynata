<?php

namespace Syno\Dynata\Demand;

use Psr\Http\Message\ResponseInterface;
use Syno\Dynata\HttpClient;
use GuzzleHttp\Exception\RequestException;

class Client
{
    const CLIENT_ID = 'api';

    /** @var string */
    private $apiDomain;

    private string $accessToken;

    private HttpClient $client;

    /**
     * @param HttpClient    $client
     * @param string        $apiDomain
     * @param string        $accessToken
     */
    public function __construct(
        HttpClient  $client,
        string      $apiDomain = '',
        string      $accessToken = ''
    )
    {
        $this->apiDomain    = $apiDomain;
        $this->accessToken  = $accessToken;
        $this->client       = $client;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): Client
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param string $uri
     * @param array $parameters
     *
     * @return array
     */
    public function get(string $uri, array $parameters = null): array
    {
        return $this->request('GET', $uri, $parameters);
    }

    /**
     * @param string $uri
     * @param array $parameters
     *
     * @return array
     */
    public function post(string $uri, array $parameters = null): array
    {
        return $this->request('POST', $uri, $parameters);
    }

    /**
     * @param string $uri
     * @param array $parameters
     *
     * @return array
     */
    public function patch(string $uri, array $parameters = null): array
    {
        return $this->request('PATCH', $uri, $parameters);
    }

    /**
     * @param string $uri
     * @param array $parameters
     *
     * @return array
     */
    public function put(string $uri, array $parameters = null): array
    {
        return $this->request('PUT', $uri, $parameters);
    }

    /**
     * @param string $uri
     * @param array $parameters
     *
     * @return array
     */
    public function delete(string $uri, array $parameters = null): array
    {
        return $this->request('DELETE', $uri, $parameters);
    }

    /**
     * @param string $requestType
     * @param string $url
     * @param array $parameters
     *
     * @return array
     */
    private function request(string $requestType, string $url, ?array $parameters): array
    {
        try {
            $response = $this->client->request(
                $requestType,
                $this->apiDomain . $url, $this->setParameters($requestType, $parameters)
            );

            $result = $this->getSuccessResponse($response);

        } catch (RequestException $exception) {
            $result = $this->getErrorResponse($exception->getResponse());
        }

        return $result;
    }

    /**
     * @param string $requestType
     * @param string $parameters
     *
     * @return array
     */
    private function setParameters(string $requestType, ?array $parameters): array
    {
        if($this->accessToken) {
            $headerParameters = [
                'headers' => ['Authorization' => 'Bearer ' . $this->accessToken]
            ];
        }

        if (!empty($parameters)) {
            $parameters = array_merge($headerParameters, [($requestType == 'GET' ? 'query' : 'json') => $parameters]);
        } else {
            $parameters = $headerParameters;
        }

        return $parameters;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    private function getSuccessResponse(ResponseInterface $response): array
    {
        $result = json_decode($response->getBody()->getContents(), true);
        return $result !== null ? $result : [];
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    private function getErrorResponse(ResponseInterface $response): array
    {
        $result = json_decode($response->getBody()->getContents(), true);

        if(isset($result['message'])) {
            $result = ['errors'=>[['field' => '', 'message' => $result['message']]]];
        }

        return $result !== null ? $result : [];
    }
}
