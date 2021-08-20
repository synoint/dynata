<?php
namespace Syno\Dynata\Demand\Authentication;

use GuzzleHttp;

class Client extends GuzzleHttp\Client
{
    /** @var string */
    private $clientId;

    /** @var string */
    private $apiUrl;

    public function __construct(
        string  $apiUrl,
        string  $clientId,
        array   $config = []
    )
    {
        $this->apiUrl   = $apiUrl;
        $this->clientId = $clientId;

        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

}
