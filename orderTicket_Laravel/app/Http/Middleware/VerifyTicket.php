<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ExceptionCodeProcess;
use App\Ticket;
use Closure;
use Exception;
use Illuminate\Http\Response;

class VerifyTicket
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
        $tid = $request;
        try {
            $flag = preg_match("/[\d{1,3}]/", $tid);
            if (!$flag) {
                throw new Exception("Wrong Input", 11102);
            }

            $ticket = new Ticket();
            if (!$ticket->existsTicket($tid)) {
                throw new Exception("Cannot Find Ticket", 11103);
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
