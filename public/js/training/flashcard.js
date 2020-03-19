$(() => {

    get_word();
    get_word();

    setTimeout(() => {
        $('.carousel').carousel();
        $('.carousel-item:eq(0)').addClass('active');
        $('.carousel-control').removeClass('d-none');
    }, 300);

    function get_word() {
        $.ajax({
            url: location.href + "/get-flashcard-word",
            method: "post",
            dataType: "json",
            success: (response) => {
                $('#training-block').append(response.layout);
                initStatus();
            },
        });
    }

    $('body').on('click', '#next-word', () => get_word());

});
