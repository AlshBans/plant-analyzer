<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        file_put_contents("latest_data.json", json_encode($data, JSON_PRETTY_PRINT));
        echo json_encode([
            "status" => "success",
            "message" => "Data received",
            "data" => $data
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No JSON received"
        ]);
    }
} else {
    // 👇 This part will show something when you open it in a browser
    if (file_exists("latest_data.json")) {
        $data = json_decode(file_get_contents("latest_data.json"), true);
        echo json_encode([
            "status" => "ok",
            "source" => "browser",
            "latest_data" => $data
        ], JSON_PRETTY_PRINT);
    } else {
        echo json_encode([
            "status" => "ok",
            "message" => "No data received yet"
        ]);
    }
}
?>
