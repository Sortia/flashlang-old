@extends('layouts.app')

@section('js')
    <script src="{{asset('plugins/animated-modal/animatedModal.min.js')}}"></script>
    <script src="{{asset('js/training/training-dashboard.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/animated-modal/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/animated-modal/normalize.min.css')}}">
@endsection

@section('content')
    <div class="list-group">
        <a href="#" class="list-group-item disabled list-group-item-action">
            <span class="navbar-brand text-primary"><b>{{\App\Models\Deck::totalProgress()}}% @lang('Total progress')</b></span>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{\App\Models\Deck::totalProgress()}}%"
                     aria-valuenow="{{\App\Models\Deck::totalProgress()}}" aria-valuemin="0"
                     aria-valuemax="100"></div>
            </div>
        </a>

        @foreach($decks as $deck)
            <a href="#animatedModal" data-id="{{$deck->id}}" class="list-group-item list-group-item-action deck">
                <span class="navbar-brand">
                    <b class="text-primary">{{$deck->progress()}}% {{$deck->name}}</b>
                    <b class="deck-name-caption pl-3">{{sprintf(__('%s of %s cards studied'), $deck->studied(), $deck->flashcards->count())}}</b>
                </span>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{$deck->progress()}}%"
                         aria-valuenow="{{$deck->progress()}}" aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
            </a>
        @endforeach

    </div>

    <!--Call your modal-->
{{--    <a id="demo01" href="#animatedModal">DEMO01</a>--}}

    <!--DEMO01-->
    <div id="animatedModal">
        <!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
        <div id="closebt-container" class="close-animatedModal">
            <div class="text-center p-5">
                <a href="#"><img class="img" src="{{asset('/img/svg/closebtn.svg')}}" alt=""></a>
            </div>
        </div>
        <div class="content">
            <div class="container col-sm-8 col-md-8 col-lg-8 col-lg-offset-2">
                <div class="card-deck">
                    <a href="#" class="card card-training" data-type-training="flashcards">
                        <div class="card-body">
                            <h3>@lang('Flashcards')</h3>
                            <p class="card-text">@lang('text.flashcards_description')</p>
                        </div>
                    </a>
                    <a href="#" class="card card-training" data-type-training="word-constructor">
                        <div class="card-body">
                            <h3>@lang('Word constructor')</h3>
                            <p class="card-text">@lang('text.word_constructor_description')</p>
                        </div>
                    </a>
                    <a href="#" class="card card-training" data-type-training="choose-word">
                        <div class="card-body">
                            <h3>@lang('Choose word')</h3>
                            <p class="card-text">@lang('text.choose_word_description')</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>





    <style>

        #animatedModal {
            opacity: 0;
        }

        .img:hover {
            transition: 0.3s;
            transform: rotate(90deg);
        }

        .img {
            transition: 0.3s;
            transform: rotate(-90deg);
        }

        a.card p {
            color: #343434;
        }

        .list-group {
            margin-top: -25px;
        }

        .deck-name-caption {
            font-size: 12px;
            color: rgba(0, 0, 0, .333);
        }

    </style>

@endsection
