<?php

namespace App\Http\Controllers;

use App\Order;
use App\Ticket;
use Illuminate\Support\Facades\Session;

class orderQueue extends Controller
{
    public function __invoke($tid)
    {
        //狀態回傳訊息
        $content = "搶票失敗";

        //接資料
        $uacc = Session::get('uacc');
        $redis = app('redis.connection');
        $ticket = (new Ticket)->getTicket($tid);

        //設定 redis 相關 {列隊名稱、總票數}
        $r_Listkey = $ticket->tname;    //redis list name
        $r_Remkey = "ticket" . $tid;       //redis remaining name

        //取得總票數，並設定(先檢查存在與否)
        $t_allPics = $ticket->tpics;
        if (!$redis->get($r_Remkey)) {
            $redis->set($r_Remkey, $t_allPics);
        }

        //加入列隊(若"列隊長度"大於等於"總票數"則不列隊)
        if ($redis->lLen($r_Listkey) < $t_allPics) {
            $redis->rPush($r_Listkey, $uacc);

            //失敗計數器
            $cntFail = 0;

            //加入後開始製作訂單(無限迴圈)
            while (true ) {
                //首先判斷排頭是否為自己
                $tmpAcc = $redis->lIndex($r_Listkey, 0);
                if ($tmpAcc == $uacc && ++$cntFail <=5) {

                    //計數器+1 start:1 stop:6
                    $cntFail++;

                    //新增到DB，且失敗次數<=5
                    if ((new Order)->addOrder($tid)) {
                        //新增成功則-1剩餘票數並取出uid
                        $tRemaining = $redis->get($r_Remkey) - 1;
                        $tRemaining = ($tRemaining == 0) ? (-1) : ($tRemaining);
                        $redis->set($r_Remkey, $tRemaining);
                        $redis->lPop($r_Listkey);
                        $redis->close();
                        $content = "恭喜搶票成功喔！";
                        break;
                    }
                } elseif ($cntFail > 5) {
                    break;
                }
                //若沒有 break 則 sleep 0.2s
                sleep(0.2);
            }
        }
        return view('alerts/Message', ['content' => $content, 'href' => '/orderList']);
    }
}
