<?php

namespace Davidnadejdin\LaravelReferral\Http\Middleware;

use Closure;
use Davidnadejdin\LaravelReferral\Models\Referral as ReferralModel;

class Referral
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
        switch (config('referral.driver')) {
            case 'cookie':
                if ($request->hasCookie('referral')) {
                    return $next($request);
                }
                if (($ref = $request->query('ref')) && ReferralModel::query()
                        ->where('code', '=', $ref)->exists()) {
                    return redirect($request->fullUrl())->withCookie(cookie()->forever('referral', $ref));
                }
                break;
        }

        return $next($request);
    }
}
