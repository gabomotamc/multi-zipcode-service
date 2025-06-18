<?php
namespace app\Controllers\Api;

class RouteController {

    public function error($params) {
        $httpCode = (int)$params['httpCode'];
        response(
            ['response' => [
                'message' => 'Route error',
                'error' => $httpCode,
                'data' => []
            ], 
            'http_code' => $httpCode
            ]
        );
    }
}    