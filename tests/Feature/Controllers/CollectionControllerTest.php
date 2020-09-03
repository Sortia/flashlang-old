<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CollectionControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function viewAuthUserTest()
    {
        auth()->login(User::first(), true);

        $response = $this->get('/collections');
        $response->assertViewIs('collections');
        $response->assertViewHas('collections');
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

    /**
     * @test
     */
    public function addTest()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $deck = Deck::create(factory(Deck::class)->make()->toArray());

        $response = $this->post("collection/{$deck->id}/add");

        $this->assertDatabaseHas('decks', [
            'user_id' => user()->id,
            'name' => $deck->name,
            'description' => $deck->description,
        ]);

        $response->assertStatus(200);
    }
}
