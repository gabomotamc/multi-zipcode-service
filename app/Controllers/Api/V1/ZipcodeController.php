<?php
namespace app\Controllers\Api\V1;

use app\Services\OpenCepService;
use app\Services\ViaCepService;

class ZipcodeController
{
    public function search() { 
        try {
            
            $request = request();
            $zipcode = onlyNumbers($request->zipcode);

            $service = new ViaCepService(
                $method = "GET", 
                $resource = "ws/{$zipcode}/json",
                $headers = [ "Content-Type" => "application/json" ]
            );

            $res = $service->request($payloadType = "json" , $payload = []);
            $res['response']['message'] = "Zipcode result";

            response($res);

        } catch ( \Throwable $e ) {

            response(['response' => ['error' => $e, 'message' => "Error", 'data' => [] ], 'http_code' => 500]);

        }
    }
}