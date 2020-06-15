<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Exceptions\TelegramValidationException;
use App\Http\Requests\Telegram\SetStatusRequest;
use App\Models\Flashcard;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Commands\Command;

class SetStatusCommand extends Command
{
    use ShouldAuth;

    /**
     * @var string Command Name
     */
    protected $name = "set_status";

    protected $pattern = '{flashcardText} {value}';

    /**
     * @var string Command Description
     */
    protected $description = "Set user settings. Example: /set_settings locale en";

    public function __construct()
    {
        $this->authUser();
    }

    /**
     * @throws TelegramValidationException
     */
    public function handle()
    {
        $arguments = $this->getArguments();

        $this->validate($arguments);

        Flashcard::with('status')->my()
            ->where('front_text', $arguments['flashcardText'])
            ->orWhere('back_text', $arguments['flashcardText'])
            ->update(['status_id' => $arguments['value']]);

        $this->replyWithMessage(['text' => 'Successful']);
    }

    /**
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

