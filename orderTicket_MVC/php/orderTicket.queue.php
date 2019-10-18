<?php
include __DIR__ . '/orderTicket.php';
session_start();

//呼叫redis
$redis = new Redis();
$redis->connect("localhost", 6379);

$ticketID = $_GET['t_id'];
$ticketArrname = "ticket" . $ticketID;
$ticket = $_SESSION[$ticketArrname];
$ticketName = $ticket->getName();
$lastticket = $ticketArrname;

while (true) {
    //判斷還有沒有票
    if (!$redis->get($lastticket) > 0) {
        echo '<script>alert("已經沒有票了，謝謝您的搶購");</script>';
        echo '<script>document.location.href="../orderTicket.List.html";</script>';
        exit;
    }

    //查看第一個是不是自己
    $uid = "";

    //redis不能太長 所以取前9位hash值比對
    $sessionUID = substr($_SESSION['u_id'], 0, 9);
    $redisUID = substr($redis->lIndex($ticketName, 0), 0, 9);
    if ($sessionUID == $redisUID) {
        $uid = $redis->lPop($ticketName);
    } else {
        sleep(2);
        continue;
    }

    //製作訂單時間
    $time = time();

    //訂單號
    $orderingNO = makeOrderingNO($time);

    //新增到DB
    $sql = "INSERT INTO `order` (`o_no`, `o_time`, `o_uid`, `o_tid`, `o_tpics`) VALUES ('{$orderingNO}', {$time}, '{$_SESSION['u_id']}', {$_GET['t_id']},1)";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        //如果失敗則再丟回列隊重來
        $redis->rPush($ticketName, $uid);
    } else {
        //成功搶票，停止queue，剩餘基本資料到其他地方填寫
        $lastTicket = intval($redis->get($lastticket)) - 1;
        $redis->set($lastticket, $lastTicket);
        $redis->close();
        echo '<script>alert("已經完成搶票，請至個人已購訂單編輯資料");</script>';
        echo '<script>document.location.href="../index.html";</script>';
        exit;
    }
}

//製作訂單編號
function makeOrderingNO($time)
{
    $stamp = $time . $_SESSION['u_id'];
    return hash("sha256", $stamp);
}