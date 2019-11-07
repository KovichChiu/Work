<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $u_acc = $request->input("acc");
        $u_pswd = hash('sha512', $request->input("pswd"));

        $user = User::where('u_acc', '=', $u_acc)->first();
        if ($user === null || $user->u_pswd != $u_pswd) {
            return "<script>alert('帳號密碼輸入錯誤，請重新輸入！');location.href = '" . url('/login') . "';</script>";
        } else {
            Session::put('u_id', $user->u_id);
            Session::put('u_acc', $user->u_acc);
            Session::put('u_name', $user->u_name);
            return "<script>alert('登入成功！');location.href = '" . url('/') . "';</script>";
        }
    }

    public function signup(Request $request)
    {
        $u_name = $request->input("name");
        $u_acc = $request->input("acc");
        $u_pswd = $request->input("pswd");

        if (User::where('u_acc', '=', $u_acc)->exists()) {
            return "<script>alert('帳號被註冊了喔！');location.href = '" . url('/signup') . "';</script>";
        } else {
            $u_id = sha1($u_name . $u_acc . $u_pswd . time());
            $signuser = new User;
            $signuser->u_id = $u_id;
            $signuser->u_name = $u_name;
            $signuser->u_acc = $u_acc;
            $signuser->u_pswd = hash('sha512', $u_pswd);
            $signuser->save();
            return "<script>alert('註冊成功！');location.href = '" . url('/login') . "';</script>";
        }
    }

    public function logout()
    {
        Session::flush();
        return "<script>alert('登出！');location.href = '" . url('/') . "';</script>";
    }
}
