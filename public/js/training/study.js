$(() => {
    $('.change-view-type').on('click', function () {
        set_settings('study_flashcards_type_view', $(this).data('type'));
    });
});
