<div class="col-lg-7">
    <div class="card mt-5">
        <div class="card-body">
            <div class="p5 mb-5 mt-3 text-center">
                <h2 class="pt-4">{{$flashcard->front_text}}</h2>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="row">
                    @foreach($words as $word)
                        <div class="col-lg-4">
                            <button class="btn btn-block m-1 p-3 card-body word">{{$word}}</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer mt-4">
            <button id="next-word" class="float-right btn btn-primary">Next -></button>
        </div>
    </div>
</div>