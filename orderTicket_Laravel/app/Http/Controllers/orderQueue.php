<?php

namespace App\Http\Controllers;

use App\Order;
use App\Ticket;
use Illuminate\Support\Facades\Session;

class orderQueue extends Controller
{
    public function __invoke($id)
    {
        $tid = $id;
        if (isset($tid) && $this->isLogin()) {
            //接資料
            $u_id = Session::get('u_id');

            $redis = app('redis.connection');
            $ticket = Ticket::where("t_id", $tid)->first();

            $r_Listkey = $ticket->t_name;    //redis list名(列隊1)
            $r_Listnum = "Listnum" . $tid;       //redis list名(列隊2)
            $r_Remkey = "ticket" . $tid;       //redis remaining名

            //設定票數(如果已經存在則不設)
            $t_allPics = $ticket->t_pics;
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
                    return "<script>alert('票券已售罄！');location.href = '" . url('/orderList') . "';</script>";
                } else {
                    echo $redis->lLen($r_Listnum);
                }

                $while_Loop = true;
                while ($while_Loop) {
                    //從列隊第一個撈值比對(取前10位)
                    $tmpUID = substr($redis->lIndex($r_Listkey, 0), 0, 10);
                    $UID = substr($u_id, 0, 10);
                    if ($tmpUID != $UID) {
                        sleep(0.5);
                        continue;
                    } else {
                        //製作訂單時間
                        $time = time();

                        //訂單號
                        $orderingNO = $this->makeOrderingNO($time, $u_id);

                        //新增到DB
                        $order = new Order;
                        $order->o_no = $orderingNO;
                        $order->o_time = $time;
                        $order->o_uid = $u_id;
                        $order->o_tid = $tid;
                        $order->o_tpics = 1;

                        if (!$order->save()) {
                            sleep(0.5);
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
                            $while_Loop = false;
                            return "<script>alert('恭喜搶票成功喔！');location.href = '" . url('/orderList') . "';</script>";
                        }
                    }
                }
            } else {
                return "<script>alert('票券已售罄！');location.href = '" . url('/orderList') . "';</script>";
            }

        } else {
            return abort(403, "STAFF ONLY, Do Not Do ANYTHING ILLEGAL!!");
        }
    }

    protected function isLogin()
    {
        $flag = false;
        if (Session::has('u_name')) {
            $flag = true;
        }
        return $flag;
    }

    protected function makeOrderingNO($time, $u_id)
    {
        $stamp = $time . $u_id;
        return hash("sha256", $stamp);
    }
}
