<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Side extends Model
{
    protected $fillable = [
        'text',
        'img_path',
        'flashcard_id',
        'side_type_id',
    ];

    public function flashcard()
    {
        return $this->belongsTo(Flashcard::class);
    }

    public function type()
    {
        return $this->belongsTo(SideType::class);
    }
}
