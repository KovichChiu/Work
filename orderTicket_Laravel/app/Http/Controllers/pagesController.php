<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class pagesController extends Controller
{

    public function home()
    {
        $obj = $this->getTable('ticket');
        return View::make('home', ['data' => $obj]);
    }

    private function getTable($table)
    {
        $data = DB::table($table)->get();
        $obj = json_decode($data, true);
        return $obj;
    }

    public function buyPages()
    {
        if ($this->isLogin()) {
            $obj = $this->getTable('ticket');
            return View::make('buyPages', ['data' => $obj]);
        } else {
            return "<script>alert('使用系統前請先登入！');location.href = '" . url('/') . "';</script>";
        }
    }

    private function isLogin()
    {
        $flag = false;
        if (Session::has('u_name')) {
            $flag = true;
        }
        return $flag;
    }

    public function buyQueue(Request $request)
    {
        $tid = $request->input('tid');
        if (isset($tid) && $this->isLogin()) {
            //接資料
            $u_id = Session::get('u_id');
            $u_acc = Session::get('u_acc');
            $u_name = Session::get('u_name');

            $redis = app('redis.connection');
            $ticket = DB::select('SELECT * FROM `ticket` WHERE `t_id` = :t_id', ['t_id' => $tid]);

            $r_Listkey = $ticket[0]->t_name;    //redis list名(列隊1)
            $r_Listnum = "Listnum" . $tid;       //redis list名(列隊2)
            $r_Remkey = "ticket" . $tid;       //redis remaining名

            //設定票數(如果已經存在則不設)
            $t_allPics = $ticket[0]->t_pics;
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
                    return "<script>alert('票券已售罄！');location.href = '" . url('/buyPages') . "';</script>";
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
                        if (!DB::insert("INSERT INTO `order` (`o_no`, `o_time`, `o_uid`, `o_tid`, `o_tpics`) VALUES (?, ?, ?, ?, ?)",
                            [$orderingNO, $time, $u_id, $tid, 1])) {
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
                            return "<script>alert('恭喜搶票成功喔！');location.href = '" . url('/buyPages') . "';</script>";
                        }
                    }
                }
            } else {
                return "<script>alert('票券已售罄！');location.href = '" . url('/buyPages') . "';</script>";
            }

        } else {
            return abort(403, "STAFF ONLY, Do Not Do ANYTHING ILLEGAL!!");
        }
    }

    private function makeOrderingNO($time, $u_id)
    {
        $stamp = $time . $u_id;
        return hash("sha256", $stamp);
    }

    public function ckVali()
    {
        if ($this->isLogin()) {
            $uid = Session::get('u_id');
            $flag = true;
            //main code
            if ($flag) {
                if (DB::update("Update `u_account` SET `u_vali` = '1' WHERE `u_id` = ?", [$uid])) {
                    return "<script>alert('成功認證！');location.href = '" . url('/') . "';</script>";
                } else {
                    return "<script>alert('認證失敗，請洽系統管理員！');location.href = '" . url('/') . "';</script>";
                }
            }
        }
    }

    public function order()
    {
        $uid = Session::get("u_id");
        $result = DB::select("SELECT `u`.`u_name` as `name`,`o`.`o_no` as `no`,`o`.`o_time` as `time`,`t`.`t_name` as `ticketName`,`o`.`o_tpics` as `pics` FROM `order` as `o` INNER JOIN `u_account` as `u` ON `o`.`o_uid` = `u`.`u_id` INNER JOIN `ticket` as `t` ON `o`.`o_tid` = `t`.`t_id` WHERE `o`.`o_uid` = :o_uid ORDER BY `time` DESC",
            ['o_uid' => $uid]);
        $obj = json_encode($result);
        return View::make('order', ['data' => $obj]);
    }

}
