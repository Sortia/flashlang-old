<?php

namespace App;

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

    protected $with = [
        'statusPivot'
    ];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function statusPivot()
    {
        return $this->hasOne(FlashcardUsers::class)->current();
    }

    public function users()
    {
        return $this->hasMany(FlashcardUsers::class);
    }

    public function getHiddenLetters()
    {
        return collect(mb_str_split($this->getHiddenText()))->shuffle();
    }

    public function getShowText()
    {
        return $this->{get_settings('study_show_side', 'back_text')};
    }

    public function getHiddenText()
    {
        return $this->{get_hidden_side_name()};
    }

    public static function getAll()
    {
        return self::with('statusPivot.status')->whereIn('deck_id', DeckUser::userDecks())->get();
    }
}
