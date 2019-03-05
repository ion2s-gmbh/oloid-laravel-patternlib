<?php

namespace Oloid\Http\Middleware;

use Closure;
use Oloid\Services\PatternStatusService;

class EnablePatternStatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var PatternStatusService $patternStatusService */
        $patternStatusService = app()->make(PatternStatusService::class);
        $patternStatusService->enable();

        return $next($request);
    }
}
