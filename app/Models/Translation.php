<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'text',
        'language',
    ];

    public function storybook()
    {
        return $this->belongsTo(Storybook::class);
    }
}
