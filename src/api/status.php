<?php
require_once __DIR__ . '/../private/func/switchbot.php';

if(!isset($_GET['id'])) {
    $res = array(
        'message' => 'not found id'
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

$credential = sbCredential(getenv('SB_API_TOKEN'), getenv('SB_API_SECRET'));
$deviceId = $_GET['id'];
$status = sbDeviceStatus($credential, $deviceId);
header('Content-Type: application/json; charset=utf8');
echo json_encode($status, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
