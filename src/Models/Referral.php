<?php

namespace Davidnadejdin\LaravelReferral\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    /** @var array  */
    protected $fillable = [
        'code',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Contracts\Auth\Authenticatable
     */
    public function referral()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referredUsers()
    {
        return $this->hasMany(config('auth.providers.users.model'), 'referral_id');
    }
}
