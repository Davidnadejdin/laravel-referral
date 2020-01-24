<?php

namespace Davidnadejdin\LaravelReferral\Referral;

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
        if ($this->referral) {
            $this->referral()->delete();
        }

        return $this->referral()->create();
    }

    protected static function bootHasReferral(): void
    {
        if (config('referral.auto_create')) {
            static::created(function ($model) {
                $model->referral()->create();
            });
        }
    }
}
