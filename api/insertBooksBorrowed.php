<?php

header ('Access-Control-Allow-Origin:*');
header ('Content-Type: application/json');
header ('Access-Control-Allow-Methods: POST, OPTIONS');
header ('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include ('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == 'OPTIONS'){
    http_response_code(200);
    exit();
}

if($requestMethod == 'POST'){

    $inputData = json_decode(file_get_contents("php://input"), true);
    if(empty($inputData)){

        $insertBooksBorrowed = insertBooksBorrowed($_POST);

    } else {

        $insertBooksBorrowed = insertBooksBorrowed($inputData);

    }

    echo $insertBooksBorrowed;
    exit();

} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod. ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>