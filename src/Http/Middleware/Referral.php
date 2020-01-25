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
        $code = $request->query('ref');

        switch (config('referral.driver')) {
            case 'cookie':
                if ($request->hasCookie('referral')) {
                    $code = $_COOKIE['referral'];
                }
                break;
        }

        $referral = ReferralModel::query()->where('code', '=', $code)->first();

        if ($referral) {
            $referral->clicks()->updateOrCreate([
                'ip' => $request->ip(),
            ]);
        }

        switch (config('referral.driver')) {
            case 'cookie':
                if ($request->hasCookie('referral')) {
                    return $next($request);
                } else if ($referral) {
                    return redirect($request->fullUrl())->withCookie(cookie()->forever('referral', $code));
                }
                break;
        }

        return $next($request);
    }
}
