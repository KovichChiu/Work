<?php

require __DIR__ . '/vendor/autoload.php';
require_once('staticData.php');

//設定 client 端的 id, secret
$client = new Google_Client;
$client->setClientId("533338172742-askqpuplgn5oq3gb7eevd7i3dmfsm47h.apps.googleusercontent.com");
$client->setClientSecret("_C1NG5exsrlXrwX9O6RokvPZ");

$service = new Google_Service_Books($client);
$optParams = array('filter' => 'free-ebooks');

$code = 200;
$msg = "OK";
$data = array();

try{
    $data = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
} catch (RuntionException $r) {
    $code = 404; //抓不到資料
    $msg = $r->getMessage();
} catch (Exception $e) {
    $code = 403; //整體程式的問題
    $msg = $e->getMessage();
}
$results = staticData::jsFormat($code, $msg, $data);

$results = json_decode($results, false);

echo "<script>alert('code:{$results->code}\n msg:{$results->msg}');</script>";

if($results->code == 200){
    foreach ($results->data->items as $value) {
        echo "<img border='1' src='{$value->volumeInfo->imageLinks->thumbnail}' alt=''><br>";
        echo "書名：{$value->volumeInfo->title}<br>";
        for ($i = 0; $i < sizeof($value->volumeInfo->authors); $i++) {
            echo "作者" . ($i + 1);
            echo "：{$value->volumeInfo->authors[$i]}<br>";
        }
        echo "<br>";
    }
}