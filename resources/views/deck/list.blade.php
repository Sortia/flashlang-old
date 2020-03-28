@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header pb-2 h5">
                        <span>@lang('Decks')</span>
                        <span><a href="{{route('deck.create')}}" class="btn btn-sm btn-success float-right">@lang('Create')</a></span>
                    </div>

                    <div class="card-body pb-1">
                        <table class="table">
                            <tr>
                                <th class="w-25">@lang('Name')</th>
                                <th class="w-75">@lang('Description')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                            @foreach($decks as $deck)
                                <tr>
                                    <td>{{$deck->name}}</td>
                                    <td>{{$deck->description}}</td>
                                    <td>
                                        <span>
                                            <a href="{{route('deck.edit', ['deck' => $deck->id])}}" class="fa fa-edit mr-3  "></a>
                                        </span>
                                        <form class="d-inline" method="post" action="{{route('deck.destroy', ['deck' => $deck->id])}}">
                                            @method('delete')
                                            @csrf
                                            <a href="#" class="fas fa-trash delete-deck"></a>
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

@section('js')
    <script>
        $('.delete-deck').on('click', function () {
            $(this).parents('form').submit();
        });
    </script>
@endsection
