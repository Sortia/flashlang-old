<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Exceptions\TelegramAuthException;
use App\Exceptions\TelegramValidationException;
use App\Models\Flashcard;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Commands\Command;

class SetStatusCommand extends Command
{
    use Authenticable;

    /**
     * @var string Command Name
     */
    protected $name = "set_status";

    /**
     * @var string Command Argument Pattern
     */
    protected $pattern = '{flashcardText} {value}';

    /**
     * @var string Command Description
     */
    protected $description = "Set flashcard status. Example: /set_status flashcardText 5";

    /**
     * Command handler
     *
     * @inheritDoc
     * @throws TelegramValidationException
     * @throws TelegramAuthException
     */
    public function handle()
    {
        $this->authUser();

        $arguments = $this->getArguments();

        $this->validate($arguments);

        Flashcard::with('status')->my()
            ->where('front_text', $arguments['flashcardText'])
            ->orWhere('back_text', $arguments['flashcardText'])
            ->update(['status_id' => $arguments['value']]);

        $this->replyWithMessage(['text' => 'Successful']);
    }

    /**
     * Validation
     *
     * @throws TelegramValidationException
     */
    public function validate(array $arguments)
    {
        $validator = Validator::make($arguments, [
            'flashcardText' => 'required',
            'value' => 'required|numeric|min:0|max:5',
        ]);

        if ($validator->fails()) {
            throw new TelegramValidationException('Invalid args');
        }
    }
}
