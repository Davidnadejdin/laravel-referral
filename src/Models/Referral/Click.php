<?php

namespace Davidnadejdin\LaravelReferral\Models\Referral;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    /** @var string  */
    protected $table = 'referral_clicks';

    /** @var array  */
    protected $fillable = [
        'ip',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referral()
    {
        return $this->belongsTo(config('referral.model'));
    }
}
