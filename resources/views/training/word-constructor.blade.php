@extends('layouts.app')

@section('js')
    <script src="{{asset('js/training/word-constructor.js')}}" defer></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/word-constructor.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div id="training-block" class="row justify-content-center">

        </div>
    </div>
@endsection
