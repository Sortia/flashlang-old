$(() => {

    let front_text = '';
    let back_text = '';
    let offset = 0;

    get_word(offset);

    function get_word(offset) {
        $.ajax({
            url: location.href + "/get-word",
            method: "post",
            data: {
                offset: offset
            },
            dataType: "json",
            success: (response) => {
                if (response.flashcard) {
                    $('#training-block').empty().append(response.layout);

                    front_text = response.flashcard.front_text || '';
                    back_text = response.flashcard.back_text || '';
                } else {
                    $('#training-block').prepend(response.layout).css('pointer-events', 'none');
                }
            },
        });
    }

    $('body')
        .on('click', '#next-word', () => get_word(++offset))
        .on('click', '.btn-letter', function () {
        let letter = $(this);
        let empty_letter = $('.letter-empty:first');

        empty_letter.text(letter.text()).removeClass('letter-empty').addClass('bg-teal letter-filled');
        letter.attr('disabled', true);

        if (!$('.letter-empty').length) {
            if (word_equal_back_text()) {
                get_word(++offset)
            } else {
                $('.letter-filled').addClass('letter-empty').removeClass('bg-teal letter-filled').text('');
                $('.btn-letter').attr('disabled', false);
            }
        }
    });

    function word_equal_back_text() {
        let word = '';

        $('.label-letter').each(function () {
            word += $(this).text();
        });

        return word === back_text;
    }
});
