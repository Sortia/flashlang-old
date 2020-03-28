@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <span>Decks</span>
                        <span><a href="{{route('deck.create')}}" class="btn btn-sm btn-success float-right">Create</a></span>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($decks as $deck)
                                <tr>
                                    <td>{{$deck->id}}</td>
                                    <td>{{$deck->name}}</td>
                                    <td>
                                        <a href="{{route('deck.edit', ['deck' => $deck->id])}}" class="btn btn-primary btn-sm">Edit</a>
                                        <form class="d-inline" method="post" action="{{route('deck.destroy', ['deck' => $deck->id])}}">
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
