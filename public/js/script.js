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

    window.set_settings = (key, value) => {
        $.ajax({
            url: `/settings/update`,
            method: "post",
            data: {
                key: key,
                value: value
            },
            dataType: "json",
            success: () => location.reload()
        });
    }
});
