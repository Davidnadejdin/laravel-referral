<?php

namespace Davidnadejdin\LaravelReferral\Models;

use Davidnadejdin\LaravelReferral\Models\Referral\Click;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Referral extends Model
{
    /** @var array  */
    protected $fillable = [
        'code',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Contracts\Auth\Authenticatable
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'referral_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referredUsers()
    {
        return $this->hasMany(config('auth.providers.users.model'), 'referral_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clicks()
    {
        return $this->hasMany(Click::class, 'referral_id');
    }

    /**
     * @return boolean
     */
    public function regenerateReferralCode()
    {
        return $this->update([
            'code' => self::generateReferralCode(),
        ]) ;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $referral
     * @return mixed
     */
    public static function scopeReferralCodeExists(Builder $query, $referral)
    {
        return $query->whereCode($referral)->exists();
    }

    /**
     * @return string
     */
    protected static function generateReferralCode()
    {
        do {
            $referral = Str::random(config('referral.code_length'));
        } while (static::referralCodeExists($referral));

        return Str::random(5);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->code = self::generateReferralCode();
        });
    }
}
