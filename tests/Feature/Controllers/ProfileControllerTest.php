<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    /**
     *
     */
    public function testAuthUserView()
    {
        auth()->login(User::first(), true);

        $response = $this->get('/profile');

        $response->assertOk();
        $response->assertViewIs('profile');
        $response->assertViewHas('user');
    }

    /**
     *
     */
    public function testGuestView()
    {
        $response = $this->get('/profile');

        $response->assertRedirect('login');
    }

    /**
     *
     */
    public function testAuthUserStore()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $avatar = UploadedFile::fake()->image('public/images/test.jpg');

        $response = $this->post('/profile', [
            'avatar' => $avatar
        ]);

        $response->assertRedirect('profile');
        $this->assertEquals(json_encode($avatar), json_encode(Storage::get(User::first()->avatar_path)));

        Storage::delete(User::first()->avatar_path);
    }
}
