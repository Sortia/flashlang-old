$(() => {
    $('#create_flashcard').on('click', () => {
        $.ajax({
            url: "/flashcard",
            method: "post",
            data: {
                deck_id: $('#id').val(),
                front_text: $('#front_text').val(),
                back_text: $('#back_text').val(),
            },
            dataType: "json",
            success: (response) => {
                $('.flashcard-list').append(response);
                $('#front_text, #back_text').val('');
            },
        });
    });

    $('.delete-flashcard').on('click', function (event) {
        event.preventDefault();

        let flashcard_id = $(this).data('flashcard-id');

        $.ajax({
            url: `/flashcard/${flashcard_id}`,
            method: "delete",
            dataType: "json",
            success: () => $(`#flashcard-${flashcard_id}`).remove()
        });
    });
});
