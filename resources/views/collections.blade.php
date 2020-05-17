@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5">@lang('Collections')</div>

                    <div class="card-body">
                        <div class="list-group">
                            @foreach($collections as $collection)
                                <a href="{{route('deck.edit', ['deck' => $collection->id])}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-lg-3 font-weight-bold">{{$collection->name}}</div>
                                        <div class="col-lg-6">{{$collection->description}}</div>
                                        <div class="col-lg-2 font-weight-bold"><span class="float-right">{{$collection->rating}}/10 <i class="fa fa-star" style="color: orange"></i></span></div>
                                        <div class="col-lg-1 font-weight-bold"><i data-id="{{$collection->id}}" class="add-deck fa fa-plus float-right mt-1"></i></div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script defer>
        $(() => {
            $('.add-deck').on('click', function (event) {
                event.preventDefault();

                $.ajax({
                    method: 'post',
                    url: `collection/${$(this).data('id')}/add`,
                    dataType: "json",
                })
            });
        });
    </script>
@endsection
