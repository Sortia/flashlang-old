<div class="row flashcard-list">
    @foreach($flashcards as $flashcard)
        <div class="col-lg-4" id="flashcard-{{$flashcard->id}}">
            <div class="card">
                <div class="card-body p-0">

                    <div class="flip-card">
                        <div class="flip-card-inner align-self-center mt-5">
                            <div class="flip-card-front">
                                <p>{{$flashcard->getShowText()}}</p>
                            </div>
                            <div class="flip-card-back">
                                <p>{{$flashcard->getHiddenText()}}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer py-1 px-3">
                    <div class="float-left rate" data-flashcard-id="{{$flashcard->id}}" data-rate-value="{{$flashcard->status->value}}"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>
