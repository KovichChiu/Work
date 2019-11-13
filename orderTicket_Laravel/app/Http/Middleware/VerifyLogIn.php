<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ExceptionCodeProcess;
use App\User;
use Closure;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class VerifyLogIn
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $uid = Session::get('uid');
            $user = (new User)->checkAccExists($uid);
            if (empty($user) || !isset($user) || is_null($user)) {
                throw new Exception('尚未登入.', 11101);
            }

            //判斷GUID是否符合格式 ex{7c815eac-6e24-4677-b5e3-8bf0e2304115}
            if(!preg_match('/^{?[a-z,0-9]{8}-[a-z,0-9]{4}-[a-z,0-9]{4}-[a-z,0-9]{4}-[a-z,0-9]{12}}?$/', $uid)){
                throw new Exception('請重新登入.', 11104);
            }
        } catch (Exception $e) {
            $process = new ExceptionCodeProcess($e);
            $content = $process->getMessage();
            $href = $process->getHref();
            return new Response(view('alerts/Message', ['content' => $content, 'href' => $href]));
        }
        return $next($request);
    }
}

