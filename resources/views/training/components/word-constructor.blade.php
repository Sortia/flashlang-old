<div class="col-lg-7">
    <div class="card mt-5">
        <div class="card-body">
            <div class="p5 mb-5 mt-3 text-center">
                <h2 class="pt-4">{{$flashcard->getShowText()}}</h2>
            </div>

            <div class="row justify-content-center mb-4">
                @for($i = 0; $i < iconv_strlen($flashcard->getHiddenText()); $i++)
                    <div class="card m-2 card-letter">
                        <button class="btn card-body p-2 px-4 bg-light m-0 letter-empty letter label-letter"></button>
                    </div>
                @endfor
            </div>

            <div class="row justify-content-center mb-4">
                @foreach($flashcard->getHiddenLetters() as $letter)
                    <div class="card shadow card-letter m-2 ">
                        <button id="id-{{rand(0, 100000)}}" class="card-body btn p-2 px-4 bg-teal m-0 btn-letter letter">{{$letter}}</button>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer mt-5">
            <div class="float-left rate" data-flashcard-id="{{$flashcard->id}}" data-rate-value="{{$flashcard->status_id}}"></div>
            <div class="float-right"><button id="next-word" class="float-right btn btn-primary">@lang('Next') -></button></div>
        </div>
    </div>
</div>
