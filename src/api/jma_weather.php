<?php
require_once __DIR__ . '/../private/func/weather.php';

$areaCode = getenv('JMA_AREA_CODE');

if($areaCode === false || $areaCode === '') {
    $res = array(
        'message' => 'not set JMA_AREA_CODE'
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

$url = 'https://www.jma.go.jp/bosai/forecast/data/forecast/' . $areaCode . '.json';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);
if($data === null) {
    $res = array(
        'message' => 'failed to fetch weather data'
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}
$weatherCode = $data[0]['timeSeries'][0]['areas'][0]['weatherCodes'][0];

$weatherText = code2weather($weatherCode);

$res = array(
    'publishingOffice' => $data[0]['publishingOffice'],
    'areaCode' => $areaCode,
    'weather_text' => $weatherText,
    'weather_code' => $data[0]['timeSeries'][0]['areas'][0]['weatherCodes'][0],
    'weather_image' => weatherImg($weatherCode)
);
header('Content-Type: application/json; charset=utf8');
echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit();
