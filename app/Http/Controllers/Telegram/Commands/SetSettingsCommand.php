<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Exceptions\TelegramValidationException;
use App\Http\Controllers\SettingsController;
use App\Models\Settings;
use App\Models\SettingsValues;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Commands\Command;

class SetSettingsCommand extends Command
{
    use ShouldAuth;

    /**
     * @var string Command Name
     */
    protected $name = "set_settings";

    protected $pattern = '{setting} {value}';

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

        $settingId = Settings::where('name', $arguments['setting'])->value('id');
        $settingValueId = SettingsValues::where('settings_id', $settingId)->where('value', $arguments['value'])->value('id');

        SettingsController::setSetting($settingId, $settingValueId);

        return $this->replyWithMessage(['text' => 'Successful!']);
    }

    /**
     * @throws TelegramValidationException
     */
    public function validate(array $arguments)
    {
        $validator = Validator::make($arguments, [
            'setting' => 'required|exists:settings,name',
            'value' => 'required|exists:settings_values,value',
        ]);

        if ($validator->fails()) {
            throw new TelegramValidationException('Invalid args');
        }
    }
}








