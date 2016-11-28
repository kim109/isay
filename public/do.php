<?php

ob_start();
header("Content-Type: application/json; charset=utf-8");
try {
    $Result = new stdClass();
    $JSON = new stdClass();

    if (empty($_POST['guid'])) {
        throw new Exception('guid is empty');
    }
    $JSON->id = $_POST['guid'];
    $JSON->hotplace = false;
    $JSON->gender = $_POST['gender'];
    $JSON->age = $_POST['age'];
    $JSON->comment = $_POST['comment'];
    $JSON->location = [];
    $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$_SERVER['REMOTE_ADDR']));
    // $query = @unserialize(file_get_contents('http://ip-api.com/php/221.158.58.148'));

    if ($query['status'] == 'success') {
        $JSON->location['country'] = $query['country'];
        $JSON->location['state'] = $query['city'];
    } else {
        throw new Exception('위치가 정확하지 않아 참가할 수 없습니다.');
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/join');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($JSON));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $return = curl_exec($ch);
    
    if ($return == false) {
        throw new Exception(curl_error($ch));
    }

    $return = json_decode($return);
    if ($return->result != 'success') {
        throw new Exception('서버에 등록을 하지 못하였습니다.');
    }

    $Result->Result = 'Success';
} catch (Exception $e) {
    $Result->Result = 'Fail';
    $Result->Message = $e->getMessage();
}

ob_end_clean();
echo json_encode($Result);
