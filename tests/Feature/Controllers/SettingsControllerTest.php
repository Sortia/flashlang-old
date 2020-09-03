<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     *
     */
    public function testAuthUserView()
    {
        auth()->login(User::first(), true);

        $response = $this->get('/settings');

        $response->assertOk();
        $response->assertViewIs('settings');
        $response->assertViewHas('settings');
    }

    /**
     *
     */
    public function testGuestView()
    {
        $response = $this->get('/settings');

        $response->assertRedirect('login');
    }

    /**
     *
     */
    public function testStore()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $settings = [
            '1' => 2,
            '2' => 4,
            '3' => 6,
        ];

        $response = $this->post('settings', compact('settings'));

        $settingsValueId = UserSettings
            ::where('user_id', user()->id)
            ->where('settings_id', 1)
            ->value('settings_value_id');

        $this->assertTrue($settingsValueId === $settings['1']);

        $settingsValueId = UserSettings
            ::where('user_id', user()->id)
            ->where('settings_id', 2)
            ->value('settings_value_id');

        $this->assertTrue($settingsValueId === $settings['2']);

        $settingsValueId = UserSettings
            ::where('user_id', user()->id)
            ->where('settings_id', 3)
            ->value('settings_value_id');

        $this->assertTrue($settingsValueId === $settings['3']);

        $response->assertRedirect('settings');
    }

    public function testFlashStore()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $response = $this->post('settings/flashStore', [
            'settings_id' => 1,
            'settings_value_id' => 2,
        ]);

        $response->assertOk();

        $settingsValueId = UserSettings
            ::where('user_id', user()->id)
            ->where('settings_id', 1)
            ->value('settings_value_id');

        $this->assertTrue($settingsValueId === 2);
    }

}
