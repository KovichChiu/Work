<?php
//跨domain請求需要header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');

//怕超時30s
set_time_limit(0);

$id = $_POST['id'];
$host = "127.0.0.1";
$port = 2046;

//開啟redis
$redis = new Redis();
$redis->connect("localhost", 6379);
$redisName = "view".$id;

// 建立一個Socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create socket\n");

// 連線
$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n");

// 資料傳送 向伺服器傳送訊息
socket_write($socket, $id) or die("Write failed\n");

//反覆找值
while ($buff = socket_read($socket, 1024, PHP_BINARY_READ)) {
    printf("%s 人已經購買，%d 人正在關注。\n", $buff, $redis->get($redisName));
}
//找完要-1
$old = $redis->get($redisName) - 1;
$redis->set($redisName, $old);
$redis->close();

socket_close($socket);

