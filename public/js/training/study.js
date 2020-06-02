$(() => {
    $('.change-view-type').on('click', function () {
        set_settings($(this).data('settings-id'), $(this).data('settings-value-id'));
    });
});
