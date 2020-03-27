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


    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function statusPivot()
    {
        return $this->hasOne(FlashcardUsers::class)->where('user_id', user()->id);
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
        return $this->{settings('study_show_side')};
    }

    public function getHiddenText()
    {
        return $this->{getHiddenSideName()};
    }

    public static function getAll()
    {
        return Flashcard::with('statusPivot.status')->whereIn('deck_id', DeckUser::userDecks())->get();
    }
}
