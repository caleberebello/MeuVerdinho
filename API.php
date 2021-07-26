<?php
  
$GLOBALS['url'] = 'https://my-green-backend.herokuapp.com/index.php';
$GLOBALS['local'] = 'http://localhost:8000';
$data = [
    'collection'  => 'RequiredAPI'
];
   
$curl = curl_init($url);
  
function callAPI($method, $url, $data) {
    $curl = curl_init();
      
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "GET":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
    }
     
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        // 'APIKEY: RegisteredAPIkey',
        'Content-Type: application/json',
    ));
     
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $result = curl_exec($curl);
    // $result['http_code'] = $httpcode;
      
    if(!$result) {
        echo("Connection failure!");
    }
    curl_close($curl);
    return $result;
}
?>