<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$data = json_decode(file_get_contents("php://input"), true);
$city = $data["city"];
$api_id = "0af5ee15a189dfdb3933de780e451027";

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$api_id}",
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($ch);
$data = json_decode($response, true);


if ($data["cod"] == 200) {
    echo json_encode(array("data" => $response, "status" => true));
} else {
    echo json_encode(array("data" => "City Not Found", "status" => false));
}

// if (curl_errno($ch)) {
//     echo json_encode(array("data" => curl_error($ch), "status" => false));
// } else {
//     echo json_encode(array("data" => $response, "status" => true));
// }

curl_close($ch);
