<?php
namespace app\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class OpenCepService
{
    protected $resource;
    protected $method;
    protected $headers;

    public function __construct($method,$resource,$headers=[]){
        $this->method = $method;
        $this->resource = $resource;
        $this->headers = $headers;
    }

    public function client() {
        $config = [
            'base_uri' => $_ENV['API_CONTENT_CREATOR_BASE_URI']."/", 
            'headers' => [
                'X-CC-ID' => $_ENV['API_CONTENT_CREATOR_ID'],
                'X-CC-KEY' => $_ENV['API_CONTENT_CREATOR_KEY'],
                'Accept' => 'application/json',
            ],
            'timeout'  => 30,//seconds
            'allow_redirects' => false,
            'http_errors' => false
        ];

        if ( count($this->headers) ) {

            $config['headers'] = array_merge($config['headers'],$this->headers);
            
        }

        return new Client($config);
    }

    public function request($payloadType,$payload=[]){

        $body = [];
        if ( count($payload) ) {

            $body[$payloadType] = $payload;

        }

        try {

            $response = $this->client()->request($this->method, $this->resource, $body);

        } catch (ServerException $e) {

            return [
                'http_code' => 500,
                'response' => ['error' => $e ],
            ];
            

        } catch (ClientException $e) {

            return [
                'http_code' => 500,
                'response' => ['error' => $e ],
            ];
            

        }  /*catch ( \Throwable $e ) {
            return [
                'http_code' => 500,
                'response' => ['error' => $e ],
            ];
        }*/

        return [
            'http_code' => $response->getStatusCode(),
            'response' => json_decode($response->getBody(), true)
        ];
        
        /*
        $code = $response->getStatusCode(); // 200
        $reason = $response->getReasonPhrase(); // OK
        echo $response->getProtocolVersion(); // 1.1
        */
    }

}