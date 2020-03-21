<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flashcard extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'deck_id',
        'status_id',
        'front_text',
        'back_text',
    ];

    /**
     * @return BelongsTo
     */
    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class);
    }

    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function getHiddenLetters()
    {
        return collect(mb_str_split($this->getHiddenText()))->shuffle();
    }

    public function getShowText()
    {
        return $this->{settings('study_show_side')};
    }

    public function getHiddenText()
    {
        return $this->{getHiddenSideName()};
    }
}
