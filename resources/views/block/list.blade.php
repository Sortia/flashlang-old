@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <span>Blocks</span>
                        <span><a href="{{route('block.create')}}" class="btn btn-sm btn-success float-right">Create</a></span>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($blocks as $block)
                                <tr>
                                    <td>{{$block->id}}</td>
                                    <td>{{$block->name}}</td>
                                    <td>{{$block->status->name}}</td>
                                    <td>
                                        <a href="{{route('block.edit', ['block' => $block->id])}}" class="btn btn-primary btn-sm">Edit</a>
                                        <form class="d-inline" method="post" action="{{route('block.destroy', ['block' => $block->id])}}">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
