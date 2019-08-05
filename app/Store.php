<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Store extends Model
{
    protected $guarded = [];

	protected $casts = [
		'email_verified_at' => 'datetime',
		'phone' => 'object',
	];

    public function picture(): MorphOne
    {
        return $this->morphOne(Picture::class,'imageable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
