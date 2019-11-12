<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ExceptionCodeProcess;
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
            $uid = Session::get('u_id');
            if (empty($uid) || !isset($uid) || is_null($uid)) {
                throw new Exception('You DidNot Login.', 11101);
            }
        } catch (Exception $e) {
            $exceptioncodeprocess = new ExceptionCodeProcess($e);
            $content = $exceptioncodeprocess->getMessage();
            $href = $exceptioncodeprocess->getHref();
            return new Response(view('alerts/Message', ['content' => $content, 'href' => $href]));
        }
        return $next($request);
    }
}
