<?php

$router->get("/", function ($data='') {
    echo "<h1>Home</h1>";
    $data = ["realHttp" => $_SERVER["REQUEST_METHOD"]] + $data;
    echo "<h1>GET :: Spoofing {$_ENV['APP_URL']} </h1>", "<pre>", print_r($data, true), "</pre>";
    $docsLink = $_ENV['APP_URL'].'/docs/README.md';
    echo "<h1>Documentation</h1>";
    echo "Link: <a href={$docsLink}>Ver docs</a>";

});

$router->get("/api/docs", function ($data='') {
    $docsLink = $_ENV['APP_URL'].'/docs/README.md';
    echo "<h1>Documentation</h1>";
    echo "Link: <a href={$docsLink}>Ver docs</a>";

});