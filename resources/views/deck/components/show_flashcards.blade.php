<div class="row flashcard-list">
    @foreach($deck->flashcards as $flashcard)
        @include('deck.components.flashcard')
    @endforeach
</div>

