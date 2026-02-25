<?php
header('Content-Type: application/json');

// 🔑 Your API keys

$plantIdApiKey = getenv('OPENAI_KEY');
$openAiKey = getenv('PLANT_ID_KEY');


if (!isset($_FILES['plantImage'])) {
    echo json_encode(['error' => 'No image uploaded.']);
    exit;
}

$imageData = base64_encode(file_get_contents($_FILES['plantImage']['tmp_name']));

// -----------------------------
// 1️⃣ Identify Plant (Plant.id)
// -----------------------------
$ch = curl_init('https://api.plant.id/v2/identify');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Api-Key: $plantIdApiKey"
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'images' => [$imageData],
        'plant_details' => ['common_names','scientific_name','url','wiki_description']
    ])
]);
$response = curl_exec($ch);
curl_close($ch);
$plantData = json_decode($response, true);

$suggestions = $plantData['suggestions'] ?? [];
$best = $suggestions[0] ?? [];
$plant_name = $best['plant_name'] ?? 'Unknown';
$botanical_name = $best['plant_details']['scientific_name'] ?? 'Unknown';

// -----------------------------
// 2️⃣ Health Assessment
// -----------------------------
$ch = curl_init('https://api.plant.id/v2/health_assessment');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Api-Key: $plantIdApiKey"
    ],
    CURLOPT_POSTFIELDS => json_encode(['images' => [$imageData]])
]);
$healthResponse = curl_exec($ch);
curl_close($ch);
$healthData = json_decode($healthResponse, true);

$disease = $healthData['health_assessment']['diseases'][0]['name'] ?? 'None';
$health_status = $disease == 'None' ? 'Healthy' : 'Diseased';

// -----------------------------
// 3️⃣ Detailed AI Report (OpenAI with JSON mode)
// -----------------------------
$prompt = "
You are a botanist and plant expert.
Analyze the given plant information and return a structured report in JSON format with these exact fields:
plant_name, botanical_name, uses, health_status, disease_name, solution.

Information:
Botanical Name: $botanical_name
Health Status: $health_status
Disease Name: $disease

Write one detailed paragraph for each field's content.
";

$payload = [
    "model" => "gpt-4o-mini",
    "response_format" => ["type" => "json_object"], // forces valid JSON
    "messages" => [
        ["role" => "system", "content" => "You are a helpful plant analysis assistant."],
        ["role" => "user", "content" => $prompt]
    ],
    "max_tokens" => 900
];

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $openAiKey"
    ],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);
$chatResponse = curl_exec($ch);
curl_close($ch);

if (!$chatResponse) {
    echo json_encode(['error' => 'No response from OpenAI.']);
    exit;
}

$chatData = json_decode($chatResponse, true);
$aiJson = $chatData['choices'][0]['message']['content'] ?? null;

// -----------------------------
// 4️⃣ Merge Results & Return
// -----------------------------
if ($aiJson) {
    $aiReport = json_decode($aiJson, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo json_encode($aiReport, JSON_PRETTY_PRINT);
        exit;
    }
}

echo json_encode([
    'plant_name' => $plant_name,
    'botanical_name' => $botanical_name,
    'uses' => 'Not available',
    'health_status' => $health_status,
    'disease_name' => $disease,
    'solution' => 'Not available'
], JSON_PRETTY_PRINT);
?>
