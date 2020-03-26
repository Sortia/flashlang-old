@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <img class="w-100" src="{{asset($user->avatar_path)}}" alt="" title="">
                            </div>
                            <div class="col-lg-6">
                                <div class="col-sm-12 my-1 mb-3">
                                    <label class="sr-only" for="name">Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Name</div>
                                        </div>
                                        <input value="{{$user->name ?? ''}}" class="form-control" id="name" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12 my-1 mb-3">
                                    <label class="sr-only" for="email">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Email</div>
                                        </div>
                                        <input value="{{$user->email ?? ''}}" class="form-control" id="email" disabled>
                                    </div>
                                </div>
                                <form action="{{route('profile.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <div class="col-sm-12 my-1 mb-3">
                                    <div class="custom-file">
                                        <input name="avatar" type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 my-1 mb-3">
                                    <button class="btn float-right btn-success">Save</button>
                                </div>
                                </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
