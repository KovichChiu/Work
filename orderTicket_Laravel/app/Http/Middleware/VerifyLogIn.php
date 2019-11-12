<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Session;

class VerifyLogIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $uid = Session::get('u_id');
            if(empty($uid) || !isset($uid) || is_null($uid)){
                throw new Exception('Login First', 403);
            }
        } catch (Exception $e) {
            return abort($e->getCode(), $e->getMessage());
        }
        return $next($request);
    }
}
