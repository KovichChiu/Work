<?php
include 'config.php';

//確保在連線客戶端時不會超時
set_time_limit(0);
//設定IP和埠號
$address = "127.0.0.1";
$port = 2046; //除錯的時候，可以多換埠來測試程式！
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("socket_create() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n");

//阻塞模式
socket_set_block($sock) or die("socket_set_block() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n");

//繫結到socket埠
$result = socket_bind($sock, $address, $port) or die("socket_bind() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n");

//開始監聽
$result = socket_listen($sock, 4) or die("socket_listen() 失敗的原因是:" . socket_strerror(socket_last_error()) . "/n");
echo "OK\nBinding the socket on $address:$port ... ";
echo "OK\nNow ready to accept connections.\nListening on the socket ... \n";
do {
//它接收連線請求並呼叫一個子連線Socket來處理客戶端和伺服器間的資訊
    $msgsock = socket_accept($sock) or die("socket_accept() failed: reason: " . socket_strerror(socket_last_error()) . "/n");

//打開redis
    $redis = new Redis();
    $redis->connect("localhost", 6379);

//讀取客戶端資料
//socket_read函式會一直讀取客戶端資料,直到遇見\n,\t或者\0字元.PHP指令碼把這寫字元看做是輸入的結束符.
    $buf = socket_read($msgsock, 8192);
    $buf = (int)$buf;
//資料傳送 向客戶端寫入返回結果
    $redisName = "view".$buf;
    $old = $redis->get($redisName) + 1;
    $redis->set($redisName, $old);

    $sql = "SELECT count(`o_tid`) AS `id` FROM `order` WHERE `o_tid` =".$buf;
    $sql_re = mysqli_query($conn, $sql);
    $msg = $sql_re->fetch_assoc()['id'];

    socket_write($msgsock, $msg, strlen($msg)) or die("socket_write() failed: reason: " . socket_strerror(socket_last_error()) ."/n");
//一旦輸出被返回到客戶端,父/子socket都應通過socket_close($msgsock)函式來終止
    socket_close($msgsock);
    $redis->close();
} while (true);
socket_close($sock);