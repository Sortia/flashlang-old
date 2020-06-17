@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5">@lang('Settings')</div>
                    <div class="card-body">
                        <div class="row">

                        <div class="col-lg-2 mt-2"><b>Connect telegram:</b></div>
                        <div class="col-lg-10">
                            <script async src="https://telegram.org/js/telegram-widget.js?9" data-telegram-login="flashlang_bot" data-size="large" data-auth-url="https://048b6259ad8f.ngrok.io/telegram/connect" data-request-access="write"></script>
                        </div>
                        </div>
                        <hr>
                        <form method="post" action="{{route('settings.store')}}">
                            @csrf
                            @foreach($settings as $setting)
                                <div class="form-group">
                                    <label for="{{$setting->name}}">@lang($setting->description)</label>
                                    <select class="form-control" id="{{$setting->name}}" name="settings[{{$setting->id}}]">
                                        @foreach($setting->values as $value)
                                            <option {{$value->value === settings($setting->name) ? 'selected' : ''}} value="{{$value->id}}">@lang($value->description)</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                            <button class="btn btn-success float-right btn-sm">@lang('Save')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
