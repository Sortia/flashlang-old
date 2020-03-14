<div class="row flashcard-list">
    @foreach($block->flashcards as $flashcard)
        @include('block.components.flashcard')
    @endforeach
</div>

