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
        <div class="card-footer">
            <small class="text-muted">Last updated 3 mins ago</small>
            <span class="float-right">
                <a href="/" data-flashcard-id="{{$flashcard->id}}" class="fas fa-trash delete-flashcard"></a>
            </span>
        </div>
    </div>
</div>
