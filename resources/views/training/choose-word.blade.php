@extends('layouts.app')

@section('js')
    <script src="{{asset('js/choose-word.js')}}" defer></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div id="training-block" class="row justify-content-center"></div>
    </div>

    <style>
        .btn-wrong {
            background-color: #f4a796 !important;
            color: white !important;
        }

        .word {
            background-color: #f8f9fa;
        }
    </style>
@endsection
