<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include __DIR__ . '/vendor/autoload.php';

$client = new \pavlatch\Client([
    'serverUrl' => 'http://127.0.0.1/pavlatchServer/index.php',
    'secureKey' => '6a4068f2-2cde-494d-90e1-08ba5827a677',
]);

var_dump($client->upload('test.jpg', 'comment_15912838670aXfNqsKGkw0hexCtUwR7H.jpg'));
