<?php

function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function sbCredential($token, $secret) {
    return array(
        'token' => $token,
        'secret' => $secret
    );
}

function sbAuth($credential) {
    $nonce = guidv4();
    $t = time() * 1000;
    $data = mb_convert_encoding($credential['token'] . $t . $nonce, 'UTF-8');
    $sign = hash_hmac('sha256', $data, $credential['secret'], true);
    $sign = strtoupper(base64_encode($sign));

    $headers = array(
        "Content-Type:application/json",
        "Authorization:" . $credential['token'],
        "sign:" . $sign,
        "nonce:" . $nonce,
        "t:" . $t
    );
    return $headers;
}

function sbDevices($credential) {
    $url = 'https://api.switch-bot.com/v1.1/devices';
    
    $headers = sbAuth($credential);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function sbDeviceStatus($credential, $deviceId) {
    $url = 'https://api.switch-bot.com/v1.1/devices/' . $deviceId . '/status';
    
    $headers = sbAuth($credential);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function sbDeviceCommand($credential, $deviceId, $command, $parameter = 'default', $commandType = 'command') {
    $url = 'https://api.switch-bot.com/v1.1/devices/' . $deviceId . '/commands';
    
    $headers = sbAuth($credential);
    $data = array(
        'command' => $command,
        'parameter' => $parameter,
        'commandType' => $commandType
    );
    $data_string = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, array('Content-Type: application/json')));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
