<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $uacc = $request->acc;
        $upswd = hash('sha512', $request->pswd);

        $user = new User;
        $user = $user->checkLogin($uacc, $upswd);

        $content = "登入失敗，請重新登入";
        $href = "/login";

        if ($user !== null) {
            Session::put('uid', $user->uid);
            Session::put('uacc', $uacc);
            Session::put('uname', $user->uname);
            $content = "登入成功";
            $href = "/";
        }
        return view('alerts/Message', ['content' => $content, 'href' => $href]);
    }

    public function signup(Request $request)
    {
        $uname = $request->input("name");
        $uacc = $request->input("acc");
        $upswd = $request->input("pswd");

        $content = "註冊失敗，請重新註冊";
        $href = "/signup";

        $user = new User;
        if (!$user->checkAccExists($uacc)) {
            $user->addAccount($uname, $uacc, $upswd);
            Session::put('uid', $user->uid);
            Session::put('uacc', $uacc);
            Session::put('uname', $user->uname);
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
