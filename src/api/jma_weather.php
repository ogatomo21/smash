<?php

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

$weatherImageBaseURL = "https://www.jma.go.jp/bosai/forecast/img/";
$res = array(
    'publishingOffice' => $data[0]['publishingOffice'],
    'areaCode' => $areaCode,
    'weather_text' => $data[0]['timeSeries'][0]['areas'][0]['weathers'][0],
    'weather_code' => $data[0]['timeSeries'][0]['areas'][0]['weatherCodes'][0],
    'weather_image' => $weatherImageBaseURL . $data[0]['timeSeries'][0]['areas'][0]['weatherCodes'][0] . '.svg',
);
header('Content-Type: application/json; charset=utf8');
echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit();
