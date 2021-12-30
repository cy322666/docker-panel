<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class TimeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $datetime_now    = Carbon::createFromTimeString(date('H:i:s'))->timestamp;
        $datetime_start  = Carbon::createFromTimeString(date('09:00:00'))->timestamp;
        $datetime_finish = Carbon::createFromTimeString(date('21:00:00'))->timestamp;

        if ($datetime_now >= $datetime_start && $datetime_now <= $datetime_finish) {

            return $next($request);

        } else exit;
    }
}
