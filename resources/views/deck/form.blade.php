@extends('layouts.app')

@section('js')
    <script src="{{asset('js/create_flashcard.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/leafing-effect.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">Block</div>

                    <div class="card-body">
                        <form action="{{route('deck.store')}}" method="post">
                            @csrf

                            <input readonly value="{{old('id') ?? $deck->id ?? ''}}" name="id" type="hidden"
                                   class="form-control" id="id" placeholder="Id">
                            <div class="col-sm-12 my-1 mb-3">
                                <label class="sr-only" for="name">Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Name</div>
                                    </div>
                                    <input autocomplete="off" value="{{old('name') ?? $deck->name ?? ''}}" name="name" type="text"
                                           class="form-control" id="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-success float-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                @isset($deck)
                    @include('deck.components.create_flashcard')
                    @include('deck.components.show_flashcards')
                @endisset

            </div>
        </div>
    </div>

@endsection
