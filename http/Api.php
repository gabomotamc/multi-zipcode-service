<?php

namespace Http;

use CoffeeCode\Router\Router;

class Api
{
    public function handle(Router $router): bool
    {   
        $request = request();
        $pass = true;
        $headers = apache_request_headers();
        $response = [];

        if ( !isset( $headers['X-MZS-ID'] ) || $_ENV['APP_API_ID'] !== $headers['X-MZS-ID'] ) {
            $pass = false;
            $response['http_code'] = 401;
            $response['response']['success'] = false;
            $response['response']['message'] = "Invalidad API (ID) credencial";
            $response['response']['data'] = [];
            $response['response']['error'] = [];      
        }

        if ( !isset( $headers['X-MZS-KEY'] ) || $_ENV['APP_API_KEY'] !== $headers['X-MZS-KEY'] ) {
            $pass = false;
            $response['http_code'] = 401;
            $response['response']['success'] = false;
            $response['response']['message'] = "Invalidad API (KEY) credencial";
            $response['response']['data'] = [];
            $response['response']['error'] = [];            
        }        

        if ( !$pass ) {
            response($response);
        }

        return $pass;

    }
}
    