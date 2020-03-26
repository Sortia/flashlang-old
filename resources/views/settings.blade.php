@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3>Settings</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('settings.store')}}">
                            @csrf
                            @foreach($settings as $setting)
                                <div class="form-group">
                                    <label for="{{$setting->name}}">{{$setting->description}}</label>
                                    <select class="form-control" id="{{$setting->name}}" name="settings[{{$setting->name}}]">
                                        @foreach($setting->values as $value)
                                            <option {{$value->value === settings($setting->name) ? 'selected' : ''}} value="{{$value->id}}">{{$value->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                            <button class="btn btn-success float-right">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
