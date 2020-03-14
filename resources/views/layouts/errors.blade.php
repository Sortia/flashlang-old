<div class="container">

    @if($errors->count())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ( $errors->all() as $error )
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<style>
    .alert-danger {
        color: #761b18 !important;
        background-color: #f9d6d5 !important;
        border-color: #f5c6cb;
    }
</style>
