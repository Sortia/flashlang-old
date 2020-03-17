$(() => {
    $('.select2-basic-single').select2({
        dropdownAutoWidth : true,
        width: '100%',
    });

    window.initStatus = function() {
        $(".rate").rate({
            step_size: 1,
        });
    };

    initStatus();

    $('body').on('change', '.rate', function (event, data) {
        $.ajax({
            url: `/flashcard/${$(this).data('flashcard-id')}/update-status`,
            method: "post",
            data: {
                value: data.to
            },
            dataType: "json",
        });
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
