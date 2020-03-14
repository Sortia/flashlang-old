$(() => {
    $('.select2-basic-single').select2({
        dropdownAutoWidth : true,
        width: '100%',
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
