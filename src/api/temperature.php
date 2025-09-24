<?php
require_once __DIR__ . '/../private/func/switchbot.php';
require_once __DIR__ . '/../private/func/db.php';

if(getenv('USE_SB_TEMPERATURE') !== 'true') {
    $res = array(
        'message' => 'not enabled temperature'
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

try {
    $temperature = getDBValue('temperature');
    $temperatureValue = $temperature["data_content"];

    $updateInterval = 60 * 10; // 10 minutes
    $latestUpdate = new DateTime($temperature["latest_update"], new DateTimeZone("UTC"));
    $now = new DateTime("now", new DateTimeZone("UTC"));
    $diff = $now->getTimestamp() - $latestUpdate->getTimestamp();

    if($temperature["data_content"] == null || $diff >= $updateInterval) {
        $sbTemperatureId = getenv('SB_TEMPERATURE_ID');
        $credential = sbCredential(getenv('SB_API_TOKEN'), getenv('SB_API_SECRET'));
        $info = sbDeviceStatus($credential, $sbTemperatureId);
        if($info['message'] !== "success") {
            $res = array(
                'message' => 'not found temperature device'
            );
            header('Content-Type: application/json; charset=utf8');
            echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit();
        }
        $newTemperature = $info['body']['temperature'];
        $newHumidity = $info['body']['humidity'];

        setDBValue('temperature', $newTemperature);
        setDBValue('humidity', $newHumidity);

        $latestUpdate = new DateTime(getDBValue('temperature')["latest_update"], new DateTimeZone("UTC"));
        $latestUpdate = $latestUpdate->format(DateTime::ATOM);
        $res = array(
            'temperature' => (float) $newTemperature,
            'humidity' => (float) $newHumidity,
            'latestUpdate' => $latestUpdate,
            'isUpdated' => true
        );
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }else{
        $humidity = getDBValue('humidity');
        $humidityValue = $humidity["data_content"];
        $latestUpdate = new DateTime($temperature["latest_update"], new DateTimeZone("UTC"));
        $latestUpdate = $latestUpdate->format(DateTime::ATOM);
        
        $res = array(
            'temperature' => (float) $temperatureValue,
            'humidity' => (float) $humidityValue,
            'latestUpdate' => $latestUpdate,
            'isUpdated' => false
        );
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }
} catch (PDOException $e) {
    $res = array(
        'message' => 'database connection failed',
        'error' => $e->getMessage()
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}
