@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5">
                        <span>@lang('Storybook')</span>
                        <span><a href="{{route('storybook.create')}}" class="btn btn-sm btn-success float-right">@lang('Create')</a></span>

                    </div>
                    <div class="list-group">
                        @foreach($storybooks as $storybook)
                            <a href="{{route('storybook.show', ['storybook' => $storybook])}}" class="list-group-item list-group-item-action">
                                <div class="row">
                                    <div class="col-lg-12">{{$storybook->shortText()}}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
