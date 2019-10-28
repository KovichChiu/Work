<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class signController extends Controller
{
    public function login(Request $request)
    {
        $u_acc = $this->sqlInject($request->input("acc"));
        $u_pswd = $this->sqlInject($request->input("pswd"));
        if ($results = DB::select('SELECT * FROM `u_account` WHERE `u_acc` = :acc', ['acc' => $u_acc])) {
            if ($results[0]->u_pswd === hash('sha512', $u_pswd)) {
                Session::put('u_id', $results[0]->u_id);
                Session::put('u_acc', $results[0]->u_acc);
                Session::put('u_name', $results[0]->u_name);
                return "<script>alert('登入成功！');location.href = '" . url('/') . "';</script>";
            } else {
                return "<script>alert('密碼錯誤！');location.href = '" . url('/login') . "';</script>";
            }
        } else {
            return "<script>alert('帳戶輸入錯誤！');location.href = '" . url('/login') . "';</script>";
        }
    }

    private function sqlInject($input)
    {
        $key = array(
            "=",
            "`",
            "·",
            "~",
            "!",
            "！",
            "^",
            "*",
            "(",
            ")",
            "\/",
            ".",
            "<",
            ">",
            "\\",
            ":",
            "；",
            ";",
            "-",
            "_",
            "—",
            " "
        );
        $output = str_replace($key, "", $input);
        return $output;
    }

    public function signup(Request $request)
    {
        $u_name = $this->sqlInject($request->input("name"));
        $u_acc = $this->sqlInject($request->input("acc"));
        $u_pswd = $this->sqlInject($request->input("pswd"));

        if (!DB::select('SELECT * FROM `u_account` WHERE `u_acc` = :acc', ['acc' => $u_acc])) {
            $u_id = sha1($u_name . $u_acc . $u_pswd . time());
            $u_pswd = hash("sha512", $u_pswd);
            if ($results = DB::insert('INSERT INTO `u_account` (`u_id`, `u_name`, `u_acc`, `u_pswd`) VALUES (?, ?, ?, ?)',
                [$u_id, $u_name, $u_acc, $u_pswd])) {
                return "<script>alert('恭喜成功註冊！');location.href = '" . url('/login') . "';</script>";
            } else {
                return "<script>alert('註冊失敗，請聯繫系統管理員！');location.href = '" . url('/signup') . "';</script>";
            }
        } else {
            return "<script>alert('帳號已註冊！');location.href = '" . url('/signup') . "';</script>";
        }
    }

    public function logout()
    {
        Session::flush();
        return "<script>alert('登出成功！');location.href = '" . url('/') . "';</script>";
    }
}
