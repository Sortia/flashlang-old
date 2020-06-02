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

    $(".deck-rate").rate({
        step_size: 1,
        max_value: 10
    });

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
    }).on('change', '.deck-rate', function (event, data) {
        $.ajax({
            url: `/deck/${$(this).data('deck-id')}/update-status`,
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

    window.set_settings = (settings_id, settings_value_id) => {
        $.ajax({
            url: `/settings/flashStore`,
            method: "post",
            data: {
                settings_id: settings_id,
                settings_value_id: settings_value_id
            },
            dataType: "json",
            success: () => location.reload()
        });
    }
});
