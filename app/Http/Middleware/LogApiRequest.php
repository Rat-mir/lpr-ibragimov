<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = round(
            (microtime(true) - $start) * 1000,
            2
        );

        DB::table('api_logs')->insert([
            'method' => $request->method(),
            'path' => $request->path(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => $duration,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response->headers->set(
            'X-Student',
            config('lab.slug')
        );

        return $response;
    }
}