<?php
$router->group("api/v1/zipcode",\Http\Api::class)->namespace("app\Controllers\Api\V1");
$router->post("/search", "ZipcodeController:search", "api.v1.zipcode.search");

/**
 * Group Error
 * This monitors all Router errors. Are they: 400 Bad Request, 404 Not Found, 405 Method Not Allowed and 501 Not Implemented
 */
$router->group("api/v1/error",\Http\php::class)->namespace("app\Controllers\Api");
$router->get("/{httpCode}", "RouteController:error");