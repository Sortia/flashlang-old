$(() => {
    $('.deck').on('click', function () {
        $(this).addClass('deck-active');
    });

    $(".deck").animatedModal({
        animationDuration: "0.4s",
        opacityIn: "0.92"
    });

    $(".card-training").on('click', function() {
        location.href = `/training/${$('.deck-active').data('id')}/${$(this).data('type-training')}`;
    });
});
