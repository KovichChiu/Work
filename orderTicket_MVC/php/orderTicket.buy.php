<?php
include __DIR__ . '/orderTicket.php';

if (isset($_POST['u_id']) && isset($_POST['u_acc']) && isset($_POST['u_name']) && isset($_POST['t_id'])) {
    //接資料
    $u_id = $_POST['u_id'];
    $u_acc = $_POST['u_acc'];
    $u_name = $_POST['u_name'];
    $t_id = $_POST['t_id'];

    //call redis
    $redis = new Redis();
    $redis->connect("localhost", 6379);

    //製作ticket
    $ticket = new orderTicket($t_id);

    $r_Listkey = $ticket->getName();    //redis list名(列隊1)
    $r_Listnum = "Listnum" . $t_id;       //redis list名(列隊2)
    $r_Remkey = "ticket" . $t_id;       //redis remaining名

    //設定票數(如果已經存在則不設)
    $t_allPics = $ticket->getPics();
    if (!$redis->get($r_Remkey) && $redis->get($r_Remkey) != "-1") {
        $redis->set($r_Remkey, $t_allPics);
    }

    //加入列隊(若"列隊長度"大於等於"總票數"則不列隊)
    if ($redis->lLen($r_Listnum) < $t_allPics) {

        //加入列隊1、列隊2(1是排隊、2是號碼牌)
        $redis->rPush($r_Listkey, $u_id);
        $redis->rPush($r_Listnum, $u_id);

        //若加入後超過長度則拔除
        if ($redis->lLen($r_Listnum) > $t_allPics) {
            $redis->rPop($r_Listnum);
            echo "noTicket";
        } else {
            echo $redis->lLen($r_Listnum);
        }

        while (true) {
            //從列隊第一個撈值比對(取前10位)
            $tmpUID = substr($redis->lIndex($r_Listkey, 0), 0, 10);
            $UID = substr($u_id, 0, 10);
            if ($tmpUID != $UID) {
                sleep(2);
                continue;
            } else {
                //製作訂單時間
                $time = time();

                //訂單號
                $orderingNO = makeOrderingNO($time, $u_id);

                //新增到DB
                $sql = "INSERT INTO `order` (`o_no`, `o_time`, `o_uid`, `o_tid`, `o_tpics`) VALUES ('{$orderingNO}', {$time}, '{$u_id}', {$t_id},1)";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    continue;
                } else {
                    //新增成功則-1剩餘票數並取出uid
                    $t_Remainings = $redis->get($r_Remkey) - 1;
                    if ($t_Remainings == 0) {
                        $t_Remainings--;
                    }
                    $redis->set($r_Remkey, $t_Remainings);
                    $redis->lPop($r_Listkey);
                    $redis->close();
                    echo "success";
                    exit;
                }
            }
        }
    } else {
        echo "noTicket";
    }
} else {
    echo 'noPOST';
}

function makeOrderingNO($time, $u_id)
{
    $stamp = $time . $u_id;
    return hash("sha256", $stamp);
}
