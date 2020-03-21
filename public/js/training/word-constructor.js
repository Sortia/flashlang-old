$(() => {

    let front_text = '';
    let back_text = '';

    get_word();

    function get_word() {
        $.ajax({
            url: location.href + "/get-constructor-word",
            method: "post",
            dataType: "json",
            success: (response) => {
                $('#training-block').empty().append(response.layout);
                front_text = response.flashcard.show_text || '';
                back_text = response.flashcard.hidden_text || '';
                initStatus();
            },
        });
    }

    $('body')
        .on('click', '#next-word', () => get_word())
        .on('click', '.btn-letter', function () {
        let letter = $(this);
        let empty_letter = $('.letter-empty:first');

        empty_letter.text(letter.text()).removeClass('letter-empty').addClass('bg-teal letter-filled');
        letter.attr('disabled', true);

        if (!$('.letter-empty').length) {
            if (word_equal_back_text()) {
                get_word();
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
