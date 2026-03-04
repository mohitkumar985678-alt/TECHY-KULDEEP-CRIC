<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_GET['get'])) {
    http_response_code(400);
    exit("Missing get parameter");
}

$path = $_GET['get'];

$targetUrl =
    "https://ev-fast-mpd.starzplayarabia.com/" . $path;




$ch = curl_init($targetUrl);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 10,

    CURLOPT_PROXY => "161.123.152.56:6301",
    CURLOPT_PROXYUSERPWD => "wfatxrls:9yn2hvo6e68p",
    CURLOPT_HTTPPROXYTUNNEL => true,

    CURLOPT_HTTPHEADER => [
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36",
        "Accept: */*",
        "Referer: https://ev-fast-mpd.starzplayarabia.com/",
        "Origin: https://ev-fast-mpd.starzplayarabia.com",
        "Host: ev-fast-mpd.starzplayarabia.com"
                   
    ],

    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);

$data = curl_exec($ch);

if ($data === false) {
    http_response_code(502);
    echo "cURL error:\n";
    echo curl_error($ch);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

if ($httpCode !== 200) {
    http_response_code($httpCode);
    exit("Upstream returned HTTP $httpCode");
}

if ($contentType) {
    header("Content-Type: $contentType");
}

echo $data;



