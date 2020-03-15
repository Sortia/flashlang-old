<div class="card shadow">
    <div class="card-header">Create flashcard</div>

    <div class="card-body">
        <form action="/">
            <div class="col-sm-12 my-1 mb-3">
                <label class="sr-only" for="front_text">Front</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Front</div>
                    </div>
                    <input autocomplete="off" name="front" type="text" class="form-control" id="front_text"
                           placeholder="Front">
                </div>
            </div>

            <div class="col-sm-12 my-1 mb-3">
                <label class="sr-only" for="back_text">Back</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Back</div>
                    </div>
                    <input autocomplete="off" name="back" type="text" class="form-control" id="back_text"
                           placeholder="Back">
                </div>
            </div>
            <div class="col-lg-12">
                <button id="create_flashcard" class="btn btn-success float-right">Save</button>
            </div>
        </form>
    </div>
</div>
