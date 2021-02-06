<?php

namespace Davidnadejdin\LaravelReferral\Traits;

use Davidnadejdin\LaravelReferral\Models\Referral;
use Illuminate\Support\Facades\Request;

trait HasReferral
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function referral()
    {
        return $this->hasOne(config('referral.model'), 'referral_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referredBy()
    {
        return $this->belongsTo(config('referral.model'), 'referral_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function generateReferral()
    {
        if ($this->referral()->exists()) {
            $this->referral()->delete();
        }

        return $this->referral()->create();
    }

    protected static function bootHasReferral()
    {
        static::created(function ($model) {
            /** @var \Davidnadejdin\LaravelReferral\Referral\HasReferral $model */
            if (config('referral.auto_create')) {
                $model->referral()->create();
            }

            $code = null;

            switch (config('referral.driver')) {
                case 'cookie':
                    if (isset($_COOKIE[config('referral.key')])) {
                        $code = $_COOKIE[config('referral.key')];
                    }
                    break;
                case 'query':
                    if (Request::query(config('referral.key'))) {
                        $code = Request::query(config('referral.key'));
                    }
                    break;
            }

            if (Referral::query()->where('code', '=', $code)->exists()) {
                $referral = Referral::query()->where('code', '=', $code)->first();

                $model->referredBy()->associate($referral);
                $model->save();
            }
        });
    }
}
