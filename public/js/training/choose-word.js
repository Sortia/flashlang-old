$(() => {
    let back_text = '';

    get_word();

    function get_word() {
        $.ajax({
            url: location.href + "/get-choose-word",
            method: "post",
            dataType: "json",
            success: (response) => {
                $('#training-block').empty().append(response.layout);
                back_text = response.flashcard.back_text;
                initStatus();
            },
        });
    }

    $('body')
        .on('click', '#next-word', () => get_word())
        .on('click', '.word', function (event) {
        event.preventDefault();

        if ($(this).text() === back_text) {
            get_word();
        } else {
            $(this).addClass('btn-wrong');
        }
    });
});
