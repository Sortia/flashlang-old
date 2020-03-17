<div class="col-lg-4" id="flashcard-{{$flashcard->id}}">
    <div class="card">
        <div class="card-body p-0">

            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <p>{{$flashcard->front_text}}</p>
                    </div>
                    <div class="flip-card-back">
                        <p>{{$flashcard->back_text}}</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer py-1 px-3">
            <div class="float-left rate" data-flashcard-id="{{$flashcard->id}}" data-rate-value="{{$flashcard->status->value}}"></div>
            <span class="float-right pt-2">
                <a href="#" data-flashcard-id="{{$flashcard->id}}" class="fas fa-trash delete-flashcard"></a>
            </span>
        </div>
    </div>
</div>
