@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Vocabulary</h3>
                    </div>
                    <div class="list-group">
                        @foreach($flashcards as $flashcard)
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="row">
                                    <div class="col-lg-5">{{$flashcard->front_text}}</div>
                                    <div class="col-lg-5">{{$flashcard->back_text}}</div>
                                    <div class="col-lg-2">
                                    <div class="rate" data-flashcard-id="{{$flashcard->id}}" data-rate-value="{{$flashcard->statusPivot->status->value}}"></div>
                                </div></div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rate {
            margin: -5px 0;
        }
    </style>
@endsection
