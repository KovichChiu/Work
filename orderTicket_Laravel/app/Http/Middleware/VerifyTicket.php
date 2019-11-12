<?php

namespace App\Http\Middleware;

use Closure;
use App\Ticket;
use Exception;

class VerifyTicket
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
        $tid = $request;
        try {
            $flag = preg_match("/[\d{1,3}]/", $tid);
            if(!$flag){
                throw new Exception("Wrong Input", 403);
            }

            $ticket = new Ticket();
            if(!$ticket->existsTicket($tid)){
                throw new Exception("Can't Find Ticket", 404);
            }
        }catch(Exception $e){
            return abort($e->getCode(), $e->getMessage());
        }
        return $next($request);
    }
}
