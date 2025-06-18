<?php
namespace app\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class ViaCepService
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
            'base_uri' => $_ENV['API_VIA_CEP_BASE_URI']."/", 
            'headers' => [
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
        $httpCode = "";
        $reason = ""; 
        $protocolVersion = ""; 
        
        if ( count($payload) ) {
            $body[$payloadType] = $payload;
        }

        try {

            $response = $this->client()->request($this->method, $this->resource, $body);

        } catch (ServerException $e) {
            return [
                'http_code' => 500,
                'response' => ['error' => $e, 'message' => 'Server error', 'data' => []],
            ];
        } catch (ClientException $e) {
            return [
                'http_code' => 500,
                'response' => ['error' => $e, 'message' => 'Client error', 'data' => []],
            ];
        } catch ( \Throwable $e ) {
            return [
                'http_code' => 500,
                'response' => ['error' => $e, 'message' => 'Throwable error', 'data' => []],
            ];
        }

        $httpCode = $response->getStatusCode(); // 200
        $reason = $response->getReasonPhrase(); // OK
        $protocolVersion = $response->getProtocolVersion(); // 1.1

        return [
            'http_code' => $httpCode,
            'response' => [
                "data" => $this->prepareResponse( json_decode( $response->getBody(), true) ),
                "error" => []
            ]
        ];

    }

    public function prepareResponse($response) {

        return [
            'zipcode' => isset($response['cep']) ? $response['cep'] : "",
            'street' => isset($response['logradouro']) ? $response['logradouro'] : "",
            'complement' => isset($response['complemento']) ? $response['complemento'] : "",
            'unity' => isset($response['unidade']) ? $response['unidade'] : "",
            'neighbourhood' => isset($response['bairro']) ? $response['bairro'] : "",
            'city' => isset($response['localidade']) ? $response['localidade'] : "",
            'federal_unit' => isset($response['uf']) ? $response['uf'] : "",
            'state' => isset($response['estado']) ? $response['estado'] : "",
            'region' => isset($response['regiao']) ? $response['regiao'] : "",
            'ibge' => isset($response['ibge']) ? $response['ibge'] : "",
            'gia' => isset($response['gia']) ? $response['gia'] : "",
            'ddd' => isset($response['ddd']) ? $response['ddd'] : "",
            'siafi' => isset($response['siafi']) ? $response['siafi'] : "",                                                                                                                   
        ];
    }

}