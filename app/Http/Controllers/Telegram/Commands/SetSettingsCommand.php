<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Http\Controllers\SettingsController;
use App\Models\Settings;
use App\Models\SettingsValues;
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

    public function handle()
    {
        $arguments = $this->getArguments();
        $settingId = Settings::where('name', $arguments['setting'])->value('id');
        $settingValueId = SettingsValues::where('settings_id', $settingId)->where('value', $arguments['value'])->value('id');

        if (is_null($settingId) || is_null($settingValueId)) {
            return $this->replyWithMessage(['text' => 'Invalid arguments']);
        }

        SettingsController::setSetting($settingId, $settingValueId);

        return $this->replyWithMessage(['text' => 'Successful!']);
    }
}








