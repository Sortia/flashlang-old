<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Models\Settings;
use Telegram\Bot\Commands\Command;

class GetSettingsCommand extends Command
{
    use ShouldAuth;

    /**
     * @var string Command Name
     */
    protected $name = "get_settings";

    /**
     * @var string Command Description
     */
    protected $description = "Show settings";

    public function __construct()
    {
        $this->authUser();
    }

    public function handle()
    {
        $text = "";
        $settings = Settings::all();

        foreach ($settings as $setting) {
            $text .= $setting->name . ': ' . PHP_EOL;
            foreach ($setting->values as $value) {
                $text .= '  -' . $value->value;
                $text .= ($value->value === settings($setting->name) ? ' *' : '') . PHP_EOL;
            }
        }

        $this->replyWithMessage(['text' => $text]);
    }
}
