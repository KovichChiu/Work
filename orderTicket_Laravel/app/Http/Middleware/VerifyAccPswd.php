<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccPswd
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
        $request->acc = $this->insteadMark($request->acc);
        $request->pswd = $this->insteadMark($request->pswd);
        return $next($request);
    }

    /**
     * SQL injection過濾
     */
    protected function insteadMark($input)
    {
        $key = [
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
            " ",
        ];
        $output = $input;
        //轉換成ASCII Code
        foreach ($key as $value) {
            $output = str_replace($value, ord($value), $output);
        }
        return $output;
    }
}
