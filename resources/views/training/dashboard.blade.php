@extends('layouts.app')

@section('content')
    <div class="list-group">
        <a href="#" class="list-group-item disabled list-group-item-action">
            <span class="navbar-brand text-primary"><b>{{\App\Deck::totalProgress()}}% Total progress</b></span>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{\App\Deck::totalProgress()}}%"
                     aria-valuenow="{{\App\Deck::totalProgress()}}" aria-valuemin="0"
                     aria-valuemax="100"></div>
            </div>
        </a>

        @foreach($decks as $deck)
            <a href="{{route('training.study', ['deck' => $deck->id])}}" class="list-group-item list-group-item-action">
                <span class="navbar-brand">
                    <b class="text-primary">{{$deck->progress()}}% {{$deck->name}}</b>
                    <b class="deck-name-caption pl-3">{{$deck->studied()}} of {{$deck->flashcards->count()}} cards studied</b>
                </span>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{$deck->progress()}}%"
                         aria-valuenow="{{$deck->progress()}}" aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
            </a>
        @endforeach

    </div>

    <style>

        .list-group-item {
            border-bottom: 2px solid rgba(0, 0, 0, .125);
        }

        .deck-name-caption {
            font-size: 12px;
            color: rgba(0, 0, 0, .333);
        }

    </style>

@endsection
