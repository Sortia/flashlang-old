@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@lang('Dashboard')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @lang('You are logged in!')
                        <script async src="https://telegram.org/js/telegram-widget.js?9" data-telegram-login="flashlang_bot" data-size="large" data-auth-url="https://8e9421363ae2.ngrok.io/telegram/auth" data-request-access="write"></script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
