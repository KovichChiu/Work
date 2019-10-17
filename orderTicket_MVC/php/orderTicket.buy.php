<?php
include __DIR__ . '/orderTicket.php';
session_start();

if(isset($_POST['u_id']) && isset($_POST['u_acc']) && isset($_POST['u_name']) && isset($_POST['t_id'])){
    //呼叫Redis
    $redis = new Redis();
    $redis->connect("localhost", 6379);

    //接資料
    $u_id = $_POST['u_id'];
    $u_acc = $_POST['u_acc'];
    $u_name = isset($_POST['u_name']);
    $t_id = isset($_POST['t_id']);

    $_SESSION['u_id'] = $u_id;
    $_SESSION['u_acc'] = $u_acc;
    $_SESSION['u_name'] = $u_name;
    $_SESSION['t_id'] = $t_id;

    //如果session中已經有撈過的票券資料直接用，沒有則new
    $ticketArrname = "ticket" . $t_id;
    $ticket = (isset($_SESSION[$ticketArrname]) ? ($_SESSION[$ticketArrname]) : (new orderTicket($t_id)));
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

    //如果列隊還沒滿則加入列隊，並推向下一步等待填寫單子
    if ($redis->lLen($t_id) < $ticketPics) {
        $redis->rPush($ticketName, $u_id);
        echo $t_id;
    } else {
        echo 'noTicket';
    }

    //關閉redis連線
    $redis->close();
}else{
    echo 'noPOST';
}
