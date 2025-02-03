<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$city = json_decode(file_get_contents("php://input"), true);
$api_id = "0af5ee15a189dfdb3933de780e451027";

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$api_id}",
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);
