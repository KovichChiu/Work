<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $u_acc = $request->acc;
        $u_pswd = hash('sha512', $request->pswd);

        $user = new User;
        $user = $user->checkLogin($u_acc, $u_pswd);

        $content = "登入失敗，請重新登入";
        $href = "/login";

        if ($user !== null) {
            Session::put('u_id', $user->u_id);
            Session::put('u_acc', $u_acc);
            Session::put('u_name', $user->u_name);
            $content = "登入成功";
            $href = "/";
        }
        return view('alerts/Message', ['content' => $content, 'href' => $href]);
    }

    public function signup(Request $request)
    {
        $u_name = $request->input("name");
        $u_acc = $request->input("acc");
        $u_pswd = $request->input("pswd");

        $content = "註冊失敗，請重新註冊";
        $href = "/signup";

        $user = new User;
        if (!$user->checkAccExists($u_acc)) {
            $u_id = sha1($u_name . $u_acc . $u_pswd . time());
            $user->addAccount($u_id, $u_name, $u_acc, $u_pswd);
            Session::put('u_id', $user->u_id);
            Session::put('u_acc', $u_acc);
            Session::put('u_name', $user->u_name);
            $content = "註冊成功，已成功登入";
            $href = "/";
        }
        return view('alerts/Message', ['content' => $content, 'href' => $href]);
    }

    public function logout()
    {
        Session::flush();
        return view('alerts/Message', ['content' => '成功登出', 'href' => "/"]);
    }
}
