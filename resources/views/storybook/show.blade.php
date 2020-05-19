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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="text">@lang('Text')</label>
                                    <textarea id="text" class="form-control" readonly rows="10 " name="text">{{$storybook->text ?? ''}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="text">@lang('Translation')</label>
                                    <textarea id="text" class="form-control" readonly rows="10" name="text">{{$storybook->translation->text ?? ''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
