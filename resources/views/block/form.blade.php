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
                        <form action="{{route('block.store')}}" method="post">
                            @csrf
                            <div class="col-sm-12 my-1 mb-3">
                                <label class="sr-only" for="id">Id</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Id</div>
                                    </div>
                                    <input readonly value="{{old('id') ?? $block->id ?? ''}}" name="id" type="text"
                                           class="form-control" id="id" placeholder="Id">
                                </div>
                            </div>
                            <div class="col-sm-12 my-1 mb-3">
                                <label class="sr-only" for="name">Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Name</div>
                                    </div>
                                    <input autocomplete="off" value="{{old('name') ?? $block->name ?? ''}}" name="name" type="text"
                                           class="form-control" id="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-sm-12 my-1 mb-3">
                                <label class="sr-only" for="status">Status</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Status</div>
                                    </div>
                                    <select class="custom-select" id="status" name="status_id">
                                        @foreach($statuses as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <a href="{{url()->previous()}}" class="btn btn-secondary float-left">Back</a>
                                <button class="btn btn-success float-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                @isset($block)
                    @include('block.components.create_flashcard')
                    @include('block.components.show_flashcards')
                @endisset

            </div>
        </div>
    </div>

@endsection
