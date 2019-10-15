<?php
include 'functions.php';

//呼叫Redis
$redis = new Redis();
$redis->connect("localhost", 6379);

echo '正在為您加入列隊中，請稍後。';

if (isset($_GET['t_id'])) {
    $ticketid = $_GET['t_id'];

    //如果session中已經有撈過的票券資料直接用，沒有則new
    $ticketArrname = "ticket" . $ticketid;
    $ticket = (isset($_SESSION[$ticketArrname]) ? ($_SESSION[$ticketArrname]) : (new orderTicket($ticketid)));
    $_SESSION[$ticketArrname] = $ticket;

    //取得票券總數量
    $ticketPics = $ticket->getPics();

    //設定票卷總數
    $lastticket = "ticket" . $ticket->getID();
    if(!$redis->get($lastticket)){
        $redis->set($lastticket, $ticketPics);
    }

    //取得票券名稱
    $ticketName = $ticket->getName();

    //取得user id
    $u_id = $_SESSION['u_id'];

    //如果列隊還沒滿則加入列隊，並推向下一步等待填寫單子
    if ($redis->lLen($ticketid) < $ticketPics) {
        $redis->rPush($ticketName, $u_id);
        echo '<script>alert("搶票成功");</script>';
        echo '<script>document.location.href="orderTicket.queue.php?t_id=' . $ticketid . '";</script>';
    } else {
        echo '<script>alert("搶票結束");</script>';
        echo '<script>document.location.href="orderTicket.list.php";</script>';
    }

    //關閉連線
    $redis->close();

}
