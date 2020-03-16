$(() => {
    let back_text = '';
    let offset = 0;

    get_word(offset);

    function get_word(offset) {
        $.ajax({
            url: location.href + "/get-choose-word",
            method: "post",
            data: {
                offset: offset
            },
            dataType: "json",
            success: (response) => {
                if (response.flashcard) {
                    $('#training-block').empty().append(response.layout);
                    back_text = response.flashcard.back_text;
                } else {
                    $('#training-block').prepend(response.layout).css('pointer-events', 'none');
                }
            },
        });
    }

    $('body')
        .on('click', '#next-word', () => get_word(++offset))
        .on('click', '.word', function (event) {
        event.preventDefault();

        if ($(this).text() === back_text) {
            get_word(++offset);
        } else {
            $(this).addClass('btn-wrong');
        }
    });

});
