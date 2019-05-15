<?php namespace MoodleSDK\Rest;

use MoodleSDK\Api\ApiCall;
use MoodleSDK\Log\ConsoleLog;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class RestApiCall implements ApiCall {

    private $debug;

    private $method;
    private $payload;
    private $responseType;
    private $url;

    public function __construct($url, $method, array $payload) {
        $this->url = $url;
        $this->method = $method;
        $this->payload = $payload;
    }

    public function execute() {
        $client = new Client([
            'base_uri' => $this->url,
        ]);

        var_dump($this->payload);
        var_dump($this->method);

        $requestUrl = $this->url . '&wsfunction=' . $this->method; // . '&' . http_build_query($this->payload);

        /** @var Response $response */
        $response = $client->post($requestUrl, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'curl' => [
                CURLOPT_USERAGENT => 'agurz/moodle-php-sdk',
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => false, // see http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
            ],
            'json' => $this->payload
        ]);


        var_dump((string)$response->getBody());
        die();


        //$payloadQueryString = http_build_query($this->payload);

        \Neos\Flow\var_dump($this->url);
        \Neos\Flow\var_dump($payloadQueryString);

//        if ($this->getDebug()) {
//            ConsoleLog::i()
//                ->section('cURL request: POST '.$this->url)
//                ->info($this->url.'&wsfunction='.$this->method.'&'.$payloadQueryString);
//        }
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url.'&wsfunction='.$this->method.'&'.$payloadQueryString,
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/plain',
            ],
//            CURLOPT_POST => 1,
//            CURLOPT_POSTFIELDS => $payloadQueryString,
//            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => false, // see http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
        ]);

        $response = curl_exec($curl);

        $info = curl_getinfo($curl);
        $err = curl_error($curl);

//        if ($this->getDebug()) {
//            ConsoleLog::i()
//                ->section('cURL response')
//                ->info($response)
//                ->infoAnx('INFO: '.json_encode($info))
//                ->infoAnx('ERR: '.$err);
//        }

        curl_close($curl);

        if ($err) {
            print_r($err);
            print_r($info);
        }

        return $response;
    }

    // Properties Getters & Setters

    public function getDebug() {
        return $this->debug;
    }

    public function setDebug($debug) {
        $this->debug = $debug;
        return $this;
    }

    public function getResponseType() {
        return $this->responseType;
    }

    public function setResponseType($responseType) {
        $this->responseType = $responseType;
        return $this;
    }

}
