<?php
require_once __DIR__ . '/../private/func/switchbot.php';

if(!isset($_GET["device"])){
    $res = array(
        'message' => 'not found device'
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

if(!isset($_GET["action"])){
    $res = array(
        'message' => 'not found action'
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

$deviceName = $_GET["device"];
$action = $_GET["action"];
$credential = sbCredential(getenv('SB_API_TOKEN'), getenv('SB_API_SECRET'));

if($deviceName == "light"){
    if(getenv('USE_SB_LIGHT') !== 'true') {
        notEnabled('light');
    }else{
        $lightId = getenv('SB_LIGHT_ID');
    }
    if($action !== "turnOn" && $action !== "turnOff"){
        invalidAction();
    }
    if($action == "turnOn"){
        $command = "turnOn";
        $action = sbDeviceCommand($credential, $lightId, $command);
        echo json_encode($action, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }else{
        $command = "turnOff";
        $action = sbDeviceCommand($credential, $lightId, $command);
        echo json_encode($action, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }
}elseif($deviceName == "ac"){
    if(getenv('USE_SB_AC') !== 'true') {
        notEnabled('ac');
    }else{
        $twiceRun = false;
        $acId = getenv('SB_AC_ID');
        if(getenv('SB_AC_OFF_TWICE_RUN') === 'true'){
            $twiceRun = true;
        }
    }
    if($action !== "cool" && $action !== "heat" && $action !== "turnOff"){
        invalidAction();
    }
    if($action == "cool"){
        $command = "setAll";
        $parameter = "28,2,1,on";
        $action = sbDeviceCommand($credential, $acId, $command, $parameter);
        echo json_encode($action, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }elseif($action == "heat"){
        $command = "setAll";
        $parameter = "20,5,1,on";
        $action = sbDeviceCommand($credential, $acId, $command, $parameter);
        echo json_encode($action, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }else{
        $command = "turnOff";
        $action = sbDeviceCommand($credential, $acId, $command);
        if($twiceRun){
            sleep(1);
            $action = sbDeviceCommand($credential, $acId, $command);
        }
        echo json_encode($action, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }
}elseif($deviceName == "lock"){
    if(getenv('USE_SB_LOCK') !== 'true') {
        notEnabled('lock');
    }else{
        $lockId = getenv('SB_LOCK_ID');
    }
    if($action !== "lock" && $action !== "unlock"){
        invalidAction();
    }
    if($action == "lock"){
        $command = "lock";
        $action = sbDeviceCommand($credential, $lockId, $command);
        echo json_encode($action, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }else{
        $command = "unlock";
        $action = sbDeviceCommand($credential, $lockId, $command);
        echo json_encode($action, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }
}else{
    $res = array(
        'message' => 'invalid device'
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

function notEnabled($device){
    $res = array(
        'message' => 'not enabled ' . $device
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

function invalidAction(){
    $res = array(
        'message' => 'invalid action'
    );
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}
