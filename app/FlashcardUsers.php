<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashcardUsers extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'flashcard_id',
        'user_id',
        'status_id',
    ];

    /**
     * Статус карточки
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Пользователь у которого есть карточка
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Карточка
     */
    public function flashcard(): BelongsTo
    {
        return $this->belongsTo(Flashcard::class);
    }
}
