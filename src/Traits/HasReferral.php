<?php

namespace Davidnadejdin\LaravelReferral\Referral;

use Davidnadejdin\LaravelReferral\Models\Referral;

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

    protected static function bootHasReferral(): void
    {
        static::created(function ($model) {
            /** @var \Davidnadejdin\LaravelReferral\Referral\HasReferral $model */
            if (config('referral.auto_create')) {
                $model->referral()->create();
            }

            if (isset($_COOKIE['referral']) and Referral::query()->where('code', '=', $_COOKIE['referral'])->exists()) {
                $referral = Referral::query()->where('code', '=', $_COOKIE['referral'])->first();

                $model->referredBy()->associate($referral);
                $model->save();
            }
        });
    }
}
