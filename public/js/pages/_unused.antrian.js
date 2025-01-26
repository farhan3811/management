$(function () {

    
    $('.js-modal-buttons .btn').on('click', function () {
        var color = $(this).data('color');
        $('#mdModal .modal-content').removeAttr('class').addClass('modal-content modal-col-' + color);
        $('#mdModal').modal('show');
    });


    /* ---------------------------- OTHERS ----------------------------- */
    $("#largeModal").on("hidden.bs.modal", function () {
        $('.modal-body').empty();
    });
    /* !--------------------------- OTHERS ----------------------------! */
});

