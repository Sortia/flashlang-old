$(() => {
    let back_text = '';
    let offset = 0;
    let total = 0;

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
                $('#training-block').empty().append(response.layout);

                total = response.deck.flashcards.length;
                back_text = response.flashcard.back_text;
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
        .on('click', '.word', function (event) {
        event.preventDefault();

        if ($(this).text() === back_text) {
            request();
        } else {
            $(this).addClass('btn-wrong');
        }
    });

    function request() {
        if (++offset === total)
            get_finish();
        else
            get_word(offset);
    }
});
