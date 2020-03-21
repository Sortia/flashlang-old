$(() => {

    get_word();

    get_word(() => {
        $('.carousel').carousel();
        $('.carousel-item:eq(0)').addClass('active');
        $('.carousel-control').removeClass('d-none');
    });

    function get_word(initCarousel) {
        $.ajax({
            url: location.href + "/get-flashcard-word",
            method: "post",
            dataType: "json",
            success: (response) => {
                $('#training-block').append(response.layout);
                initStatus();

                if (initCarousel) initCarousel();
            },
        });
    }

    $('body').on('click', '#next-word', () => get_word(false));

});
