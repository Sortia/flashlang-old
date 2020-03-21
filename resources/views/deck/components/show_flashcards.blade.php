<div class="row flashcard-list">
    @foreach($deck->flashcards as $flashcard)
        <div class="col-lg-4" id="flashcard-{{$flashcard->id}}">
            <div class="card">
                <div class="card-body py-5">
                    <div class="row justify-content-center">
                        <div>{{$flashcard->getShowText()}}</div>
                    </div>
                    <div class="row justify-content-center">
                        <div>{{$flashcard->getHiddenText()}}</div>
                    </div>
                </div>
                <div class="card-footer py-1 px-3">
                    <div class="float-left rate" data-flashcard-id="{{$flashcard->id}}" data-rate-value="{{$flashcard->status->value}}"></div>
                    <span class="float-right pt-2"><a href="#" data-flashcard-id="{{$flashcard->id}}" class="fas fa-trash delete-flashcard"></a></span>
                </div>
            </div>
        </div>
    @endforeach
</div>

