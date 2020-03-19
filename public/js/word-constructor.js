$(() => {

    let front_text = '';
    let back_text = '';
    let offset = 0;
    let total = 0;

    get_word(offset);

    function get_word(offset) {
        $.ajax({
            url: location.href + "/get-constructor-word",
            method: "post",
            data: {
                offset: offset
            },
            dataType: "json",
            success: (response) => {
                $('#training-block').empty().append(response.layout);
                total = response.deck.flashcards.length;
                front_text = response.flashcard.front_text || '';
                back_text = response.flashcard.back_text || '';
                initStatus();
            },
        });
    }

    function get_finish()
    {
        $.ajax({
            url: location.href + "/get-finish",
            method: "post",
            dataType: "json",
            success: (response) =>  $('#training-block').empty().append(response.layout)
        });
    }

    $('body')
        .on('click', '#next-word', () => request())
        .on('click', '.btn-letter', function () {
        let letter = $(this);
        let empty_letter = $('.letter-empty:first');

        empty_letter.text(letter.text()).removeClass('letter-empty').addClass('bg-teal letter-filled');
        letter.attr('disabled', true);

        if (!$('.letter-empty').length) {
            if (word_equal_back_text()) {
                request();
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

    function request() {
        if (++offset === total)
            get_finish();
        else
            get_word(offset);
    }
});
