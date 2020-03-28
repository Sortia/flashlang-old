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
                    <div class="card-header">
                        <span class="float-left">Deck</span>
                        @isset($deck->id)
                            <span class="float-right deck-rate" data-rate-value="{{$deck->rate->value ?? 0}}" data-deck-id="{{$deck->id}}"></span>
                        @endisset
                    </div>

                    <div class="card-body">
                        <form action="{{route('deck.store')}}" method="post">
                            @csrf
                            <fieldset @cannot('edit', $deck) disabled @endcannot>

                                <input readonly value="{{old('id') ?? $deck->id ?? ''}}" name="id" type="hidden"
                                       class="form-control" id="id" placeholder="Id">
                                <div class="col-sm-12 my-1 mb-3">
                                    <label class="sr-only" for="name">Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Name</div>
                                        </div>
                                        <input autocomplete="off" value="{{old('name') ?? $deck->name ?? ''}}"
                                               name="name" type="text"
                                               class="form-control" id="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-12 my-1 mb-3">
                                    <label class="sr-only font-weight-bold" for="description">Description</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Description</div>
                                        </div>
                                        <input autocomplete="off"
                                               value="{{old('description') ?? $deck->description ?? ''}}"
                                               name="description" type="text"
                                               class="form-control" id="description" placeholder="Description">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="custom-control custom-control-inline font-weight-bold">
                                        <span>Access type: </span>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input {{checkbox($deck, 'access', 'public')}} type="radio"
                                               value="public" id="access" name="access" class="custom-control-input">
                                        <label class="custom-control-label" for="access">Public</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input {{checkbox($deck, 'access', 'private')}} type="radio"
                                               value="private" id="access2" name="access" class="custom-control-input">
                                        <label class="custom-control-label" for="access2">Private</label>
                                    </div>
                                </div>
                            </fieldset>

                            @can('edit', $deck)
                                <div class="col-lg-12">
                                    <button class="btn btn-success float-right">Save</button>
                                </div>
                            @endcan
                        </form>
                    </div>
                </div>

                @can('edit', $deck)
                    @include('deck.components.create_flashcard')
                @endcan
                @include('deck.components.show_flashcards')

            </div>
        </div>
    </div>

@endsection
