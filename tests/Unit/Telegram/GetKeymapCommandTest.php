<?php

namespace Tests\Unit\Telegram;

use App\Http\Controllers\Telegram\Commands\GetKeymapCommand;
use Tests\TestCase;

class GetKeymapCommandTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @test
     * @return void
     */
    public function getMarkupWithTranslateAndTrainingButtons()
    {
        $keymapCommand = new GetKeymapCommand();

        $keymap = $keymapCommand->getKeymap();

        $this->assertEquals(json_encode($keymap), json_encode([
            'keyboard' => [['Translate', 'Training']],
            'resize_keyboard' => true,
        ]));

        $this->assertNotEquals(json_encode($keymap), json_encode([
            'keyboard' => [[]],
            'resize_keyboard' => true,
        ]));
    }
}
