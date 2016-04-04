<?php
namespace Malwr;

/**
 * Light-weight Factory to construct HTTP calls
 */
class ApiBase
{
    /**
     * @var Malwr API endpoint prefix
     */
    const API_ENDPOINT = 'https://malwr.com/api/';

    /**
     * @var ClientInterface - http client
     */
    protected $_client;

    /**
     * @var string - Malwr api key
     */
    protected $_apiKey;

    /**
     * Constructor
     * @param string          $apiKey
     * @param \Guzzle\Http\ClientInterface $client
     */
    public function __construct($apiKey, \Guzzle\Http\ClientInterface $client = null) {
        $this->_apiKey =  $apiKey;

        if ( empty( $client) ) {
            $this->_client = new \Guzzle\Http\Client(self::API_ENDPOINT);
        }
    }

    /**
     * Util function to make post request
     * @param string          $endpoint
     * @param array           $params
     * @return (?)
     * @see \Guzzle\Http\Client
     * @throw \Malwr\Exceptions\RateLimitException
     * @throw \Malwr\Exceptions\InvalidApiKeyException
     */
    protected function makePostRequest($endpoint, array $params) {
        try {
            $request = $this->_client->post($endpoint, null, $params);
            $response = $request->send();
            $this->validateResponse($response->getStatusCode());
            return $response;
        } catch(\Guzzle\Http\Exception\ClientErrorResponseException $e) {
            $this->validateResponse($e->getResponse()->getStatusCode());
        }
    }


    /**
     * Util function to make get request
     * @param string          $endpoint
     * @param array           $params
     * @return (?)
     * @throw \Malwr\Exceptions\RateLimitException
     * @throw \Malwr\Exceptions\InvalidApiKeyException
     */
    protected function makeGetRequest($endpoint, array $params) {
        // Constructs get url
        // e.g:
        // endpoint = 'ip-address/report'
        //
        // params => array(
        //                'ip'       => '192.168.2.1',
        //                'apikey'   => 'supersecureapikey'
        //            )
        //
        // It maps to:
        // https://www.virustotal.com/vtapi/v2/ip-address/report?ip=192.168.2.1&apikey=supersecureapikey
        try {
            $url = self::API_ENDPOINT . $endpoint . '?'. http_build_query($params);
            $request = $this->_client->get($url);
            $response = $request->send();
            $this->validateResponse($response->getStatusCode());
            return $response;
        } catch(\Guzzle\Http\Exception\ClientErrorResponseException $e) {
            $this->validateResponse($e->getResponse()->getStatusCode());
        }
    }

    /**
     * Validate response by looking up the http status code
     * @param int $statusCode - http status code
     * @throw \Malwr\Exceptions\RateLimitException
     * @throw \Malwr\Exceptions\InvalidApiKeyException
     */
    protected function validateResponse($statusCode) {
        switch($statusCode) {
            case 204:
                throw new Exceptions\RateLimitException('Too many requests');
            case 403:
                throw new Exceptions\InvalidApiKeyException(sprintf('Key %s is invalid', $this->_apiKey));
            default:
                return;
        }
    }
}

?>