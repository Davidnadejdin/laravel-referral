<?php

namespace Davidnadejdin\LaravelReferral\Http\Middleware;

use Closure;
use Davidnadejdin\LaravelReferral\Models\Referral as ReferralModel;
use Illuminate\Support\Facades\Request;

class Referral
{
    public function handle($request, Closure $next)
    {
        $code = $request->query(config('referral.key'));

        switch (config('referral.driver')) {
            case 'cookie':
                if ($request->hasCookie(config('referral.key'))) {
                    $code = $_COOKIE[config('referral.key')];
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
                if ($request->hasCookie(config('referral.key'))) {
                    return $next($request);
                } else if ($referral) {
                    return redirect($request->fullUrl())->withCookie(cookie()->forever(config('referral.key'), $code));
                }
                break;
        }

        return $next($request);
    }
}
