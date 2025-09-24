<?php
require_once __DIR__ . '/../private/func/switchbot.php';

$credential = sbCredential(getenv('SB_API_TOKEN'), getenv('SB_API_SECRET'));
$devices = sbDevices($credential);
header('Content-Type: application/json; charset=utf8');
echo json_encode($devices, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
