<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Deck;
use App\Models\Flashcard;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FlashcardControllerTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function authUserStoreTest()
    {
        auth()->login(User::first(), true);

        $this->withoutMiddleware(VerifyCsrfToken::class);

        $flashcardData = [
            'front_text' => $this->faker->text(8),
            'back_text' => $this->faker->text(8),
            'deck_id' => factory(Deck::class)->create()->id
        ];

        $response = $this->post('/flashcard', $flashcardData);

        $response->assertSee($flashcardData['front_text']);
        $response->assertSee($flashcardData['back_text']);
        $response->assertOk();

        $this->assertDatabaseHas('flashcards', $flashcardData);
    }


    /**
     * @test
     */
    public function guestStoreTest()
    {
        $flashcardData = [
            'front_text' => $this->faker->text(8),
            'back_text' => $this->faker->text(8),
            'deck_id' => factory(Deck::class)->create()->id
        ];

        $response = $this->post("/flashcard", $flashcardData);

        $response->assertStatus(419);
    }

    /**
     * @test
     */
    public function authUserDeleteTest()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $flashcard = factory(Flashcard::class)->create();

        $response = $this->delete("/flashcard/{$flashcard->id}");

        $response->assertOk();

        $this->assertNull(Flashcard::find($flashcard->id));
    }

    /**
     * @test
     */
    public function guestDeleteTest()
    {
        $flashcard = factory(Flashcard::class)->create();

        $this->assertDatabaseHas('flashcards', $flashcard->toArray());
        $response = $this->delete("/flashcard/{$flashcard->id}");

        $response->assertStatus(419);
    }

    /**
     * @test
     */
    public function authUserUpdateStatusTest()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        auth()->login(User::first(), true);

        $flashcard = factory(Flashcard::class)->create();

        $statusId = $this->faker->numberBetween(0, 5);

        $response = $this->post("/flashcard/{$flashcard->id}/update-status", [
            'status_id' => $statusId,
        ]);

        $response->assertOk();

        $flashcard->refresh();

        $this->assertTrue($flashcard->status_id === $statusId);
    }
}
