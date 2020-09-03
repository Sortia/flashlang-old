<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Deck;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\ArrayComparer;
use Tests\TestCase;

class DeckControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    use ArrayComparer;

    /**
     * @test
     */
    public function authUserViewTest()
    {
        auth()->login(User::first(), true);

        $response = $this->get('/deck');

        $response->assertViewIs('deck.list');
        $response->assertViewHas('decks');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function guestUserViewTest()
    {
        $response = $this->get('/deck');

        $response->assertRedirect('login')->assertStatus(302);
    }

    /**
     * @test
     */
    public function authUserCreateViewTest()
    {
        auth()->login(User::first(), true);

        $response = $this->get('/deck/create');

        $response->assertViewIs('deck.form');
        $response->assertViewHas(['deck', 'statuses']);
        $response->assertStatus(200);
    }

    public function guestUserCreateViewTest()
    {
        $response = $this->get('/deck/create');

        $response->assertRedirect('login')->assertStatus(302);
    }

    /**
     * @test
     */
    public function authUserEditViewTest()
    {
        auth()->login(User::first(), true);

        $deck = Deck::create(factory(Deck::class)->make()->toArray());

        $response = $this->get("/deck/{$deck->id}/edit");

        $response->assertViewIs('deck.form');
        $response->assertViewHas(['deck', 'statuses']);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function guestUserEditViewTest()
    {
        $response = $this->get('/deck/edit');

        $response->assertRedirect('login')->assertStatus(302);
    }

    /**
     * @test
     */
    public function authUserStoreTest()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $deckData = [
            'name' => $this->faker->text(15),
            'description' => $this->faker->text(30),
        ];

        $response = $this->post('/deck', $deckData);

        $this->assertTrue(
            Deck::on()
                ->where('name', $deckData['name'])
                ->where('description', $deckData['description'])
                ->exists()
        );

        $response->assertRedirect('deck')->assertStatus(302);
    }

    /**
     * @test
     */
    public function authUserDeleteTest()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $deck = Deck::create(factory(Deck::class)->make()->toArray());

        $response = $this->delete("/deck/{$deck->id}");

        $this->assertNull(Deck::find($deck->id));

        $response->assertRedirect('deck')->assertStatus(302);
    }

    /**
     * @test
     */
    public function guestDeleteTest()
    {
        $deck = Deck::create(factory(Deck::class)->make()->toArray());

        $response = $this->delete("/deck/{$deck->id}");

        $response->assertStatus(419);
    }

    /**
     * @test
     */
    public function authUserUpdateStatusTest()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $deck = Deck::create(factory(Deck::class)->make()->toArray());
        $deck->update(['access' => 'public']);

        $deck->refresh();

        $this->assertTrue($deck->number_ratings === 0);

        $rating = $this->faker->numberBetween(0, 10);

        $response = $this->post("/deck/{$deck->id}/update-status", ['value' => $rating]);

        $deck->refresh();

        $this->assertTrue($deck->number_ratings === 1);
        $this->assertTrue($deck->rating == $rating);

        $this->assertTrue(Rate::on()
            ->where('user_id', user()->id)
            ->where('deck_id', $deck->id)
            ->where('value', $rating)
            ->exists()
        );

        $rating2 = $this->faker->numberBetween(0, 10);
        $response->assertStatus(200);

        $response = $this->post("/deck/{$deck->id}/update-status", ['value' => $rating2]);

        $deck->refresh();

        $this->assertTrue($deck->number_ratings === 2);
        $this->assertTrue($deck->rating == (($rating + $rating2) / 2));

        $this->assertTrue(Rate::on()
            ->where('user_id', user()->id)
            ->where('deck_id', $deck->id)
            ->where('value', $rating2)
            ->exists()
        );

        $response->assertStatus(200);
    }
}
