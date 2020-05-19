@extends('layouts.app')

@section('js')
    <script src="{{asset('js/storybook.js')}}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5">@lang('Storybook')</div>
                    <div class="m-3">
                        <div class="col-lg-12">
                            <form action="{{route('storybook.store')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="text">@lang('Text')</label>
                                    <textarea id="text" class="form-control" name="text"></textarea>
                                </div>
                                <button class="btn btn-primary float-right mt-2">@lang('Create')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
