<div class="card shadow">
    <div class="card-header">@lang('Create flashcard')</div>

    <div class="card-body">
        <form action="/">
            <div class="col-sm-12 my-1 mb-3">
                <label class="sr-only" for="front_text">@lang('Front')</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">@lang('Front')</div>
                    </div>
                    <input autocomplete="off" name="front" type="text" class="form-control" id="front_text"
                           placeholder="@lang('Front')">
                </div>
            </div>

            <div class="col-sm-12 my-1 mb-3">
                <label class="sr-only" for="back_text">@lang('Back')</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">@lang('Back')</div>
                    </div>
                    <input autocomplete="off" name="back" type="text" class="form-control" id="back_text"
                           placeholder="@lang('Back')">
                </div>
            </div>
            <div class="col-lg-12">
                <button id="create_flashcard" class="btn btn-success float-right">@lang('Save')</button>
            </div>
        </form>
    </div>
</div>
