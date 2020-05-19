<?php

namespace App\Models;

use Str;

class Storybook extends BaseModel
{
    protected $fillable = [
        'text'
    ];

    public function translation()
    {
        return $this->hasOne(Translation::class);
    }

    public function shortText()
    {
        return Str::limit($this->text, 250, '...');
    }
}
