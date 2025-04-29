<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'spotify_config.php';

if (!isset($_GET['query'])) {
    http_response_code(400);
    echo json_encode(["message" => "Query parameter is required."]);
    exit;
}

// Step 1: Get access token
$auth_url = "https://accounts.spotify.com/api/token";
$auth_headers = [
    "Authorization: Basic " . base64_encode(SPOTIFY_CLIENT_ID . ":" . SPOTIFY_CLIENT_SECRET),
    "Content-Type: application/x-www-form-urlencoded"
];

$auth_data = "grant_type=client_credentials";

$ch = curl_init($auth_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $auth_headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $auth_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$token_data = json_decode($response, true);
$access_token = $token_data['access_token'] ?? null;

if (!$access_token) {
    http_response_code(500);
    echo json_encode(["message" => "Failed to retrieve access token."]);
    exit;
}

// Step 2: Search tracks
$query = urlencode($_GET['query']);
$search_url = "https://api.spotify.com/v1/search?q=$query&type=track&limit=5";

$search_headers = [
    "Authorization: Bearer $access_token"
];

$ch = curl_init($search_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $search_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$search_response = curl_exec($ch);
curl_close($ch);

$tracks_data = json_decode($search_response, true);
$tracks = $tracks_data['tracks']['items'] ?? [];

$result = [];

foreach ($tracks as $track) {
    $result[] = [
        "track_name" => $track['name'],
        "artist" => $track['artists'][0]['name'],
        "album" => $track['album']['name'],
        "preview_url" => $track['preview_url'],
        "spotify_url" => $track['external_urls']['spotify']
    ];
}

http_response_code(200);
echo json_encode($result);
?>