<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flashcard extends BaseModel
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'deck_id',
        'status_id',
        'front_text',
        'back_text',
    ];

    /**
     * Колоду, к которой принадлежит карточка
     */
    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Получить массив букв слова с обратной стороны карточки
     */
    public function getHiddenLetters(): \Illuminate\Support\Collection
    {
        return collect(mb_str_split($this->getHiddenText()))->shuffle();
    }

    /**
     * Получить текст лицевой стороны карточки
     */
    public function getShowText(): ?string
    {
        return $this->{settings('study_show_side', 'back_text')};
    }

    /**
     * Получить текст обратной стороны карточки
     */
    public function getHiddenText(): ?string
    {
        return $this->{get_hidden_side_name()};
    }

    public static function scopeMy(Builder $query, User $user = null): Builder
    {
        return $query->whereHas('deck', function (Builder $q) use ($user) {
            $q->where('user_id', 2);
        });
    }
}
