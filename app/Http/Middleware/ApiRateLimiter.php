<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimiter
{

    protected $perMinute = 60;

    protected $perDay = 1000;

    public function handle(Request $request, Closure $next)
    {

        $identifier = $request->user() ? 'user_' . $request->user()->id : 'ip_' . $request->ip();


        $minuteKey = 'api_rate_minute_' . $identifier;
        $minuteCount = Cache::get($minuteKey, 0);
        if ($minuteCount >= $this->perMinute) {
            return response()->json([
                'error' => 'API rate limit exceeded. Try again later.'
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }
        Cache::put($minuteKey, $minuteCount + 1, now()->addMinute());

        $dayKey = 'api_rate_day_' . $identifier;
        $dayCount = Cache::get($dayKey, 0);
        if ($dayCount >= $this->perDay) {
            return response()->json([
                'error' => 'API rate limit exceeded. Try again later.'
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }
        Cache::put($dayKey, $dayCount + 1, now()->endOfDay());

        return $next($request);
    }
}
