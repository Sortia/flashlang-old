<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Exceptions\TelegramAuthException;
use App\Exceptions\TelegramValidationException;
use App\Models\Deck;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Commands\Command;

class CreateFlashcardCommand extends Command
{
    use Authenticable;

    /**
     * @var string Command Name
     */
    protected $name = "create_flashcard";

    /**
     * @var string Command Description
     */
    protected $description = "Create flashcard. Example: /create_flashcard front_text back_text";

    /**
     * @var string Command Argument Pattern
     */
    protected $pattern = '{front_text} {back_text}';

    /**
     * Command handler
     *
     * @throws TelegramValidationException
     * @throws TelegramAuthException
     */
    public function handle()
    {
        $this->authUser();

        $arguments = $this->getArguments();

        $this->validate($arguments);

        Deck::getTelegramDeck()->flashcards()->create($arguments);
    }

    /**
     * Validation
     *
     * @throws TelegramValidationException
     */
    private function validate(array $arguments)
    {
        $validator = Validator::make($arguments, [
            'front_text' => 'required',
            'back_text' => 'required',
        ]);

        if ($validator->fails()) {
            throw new TelegramValidationException('Invalid args');
        }
    }
}
