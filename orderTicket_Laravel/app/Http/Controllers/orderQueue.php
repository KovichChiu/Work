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
        $u_id = Session::get('u_id');
        $redis = app('redis.connection');
        $ticket = (new Ticket)->getTicket($tid);

        //設定 redis 相關 {列隊名稱、總票數}
        $r_Listkey = $ticket->t_name;    //redis list名(列隊1)
        $r_Remkey = "ticket" . $tid;       //redis remaining名

        //取得總票數，並設定(先檢查存在與否)
        $t_allPics = $ticket->t_pics;
        if (!$redis->get($r_Remkey)) {
            $redis->set($r_Remkey, $t_allPics);
        }

        //加入列隊(若"列隊長度"大於等於"總票數"則不列隊)
        if ($redis->lLen($r_Listkey) < $t_allPics) {
            $redis->rPush($r_Listkey, $u_id);

            //失敗計數器
            $cntFail = 0;

            //加入後開始製作訂單(無限迴圈)
            while (true) {
                //首先判斷排頭是否為自己
                $tmpUID = substr($redis->lIndex($r_Listkey, 0), 0, 10);
                $UID = substr($u_id, 0, 10);
                if ($tmpUID == $UID) {
                    //製作訂單時間
                    $time = time();

                    //訂單號
                    $orderingNO = $this->makeOrderingNO($time, $u_id);

                    //新增到DB，且失敗次數<5
                    if ((new Order)->addOrder($orderingNO, $time, $u_id, $tid, 1) && $cntFail < 5) {
                        //新增成功則-1剩餘票數並取出uid
                        $t_Remainings = $redis->get($r_Remkey) - 1;
                        $t_Remainings = ($t_Remainings == 0) ? (-1) : ($t_Remainings);
                        $redis->set($r_Remkey, $t_Remainings);
                        $redis->lPop($r_Listkey);
                        $redis->close();
                        $content = "恭喜搶票成功喔！";
                        break;
                    } else {
                        $cntFail++;
                    }
                }
                //若沒有 break 則 sleep 0.5s
                sleep(0.2);
            }
        }
        return view('alerts/Message', ['content' => $content, 'href' => '/orderList']);
    }

    protected function makeOrderingNO($time, $u_id)
    {
        $stamp = $time . $u_id;
        return hash("sha256", $stamp);
    }
}
