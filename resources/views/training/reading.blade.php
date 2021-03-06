@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/reading-training.css')}}">
@endsection

@section('js')
    <script src="{{asset('js/training/study.js')}}" defer></script>
    <script src="{{asset('js/training/flashcard.js')}}" defer></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div id="training-block" class="carousel-inner"></div>
                    <a class="carousel-control carousel-control-prev d-none" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a id="next-word" class="carousel-control carousel-control-next d-none" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">@lang('Next')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
