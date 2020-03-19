$(() => {
    $('.deck').on('click', function () {
        $(this).addClass('deck-active');
        $('#training-block').css('opacity', 1);
    });

    $(".deck").animatedModal({
        animationDuration: "0.4s",
        opacityIn: "1",
    });

    $(".card-training").on('click', function() {
        location.href = `/training/${$('.deck-active').data('id')}/${$(this).data('type-training')}`;
    });
});
