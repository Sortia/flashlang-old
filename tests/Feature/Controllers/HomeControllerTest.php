<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function authUserViewTest()
    {
        auth()->login(User::first(), true);

        $response = $this->get('/home');

        $response->assertViewIs('home');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function guestUserViewTest()
    {
        $response = $this->get('/home');

        $response->assertRedirect('login');
        $response->assertStatus(302);
    }
}
