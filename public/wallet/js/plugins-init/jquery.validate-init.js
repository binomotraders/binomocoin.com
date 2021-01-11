jQuery(".validateFrom").validate({
    rules: {
        noBNCToBuy: {
            required: true,
            digits: true,
            range: [1, 100],
        },
        noBNCToSend: {
            required: true,
            digits: true,
            range: [1, 100],
        },
    },
    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    highlight: function (e) {
        jQuery(e)
            .closest(".form-group")
            .removeClass("is-invalid")
            .addClass("is-invalid");
    },
    success: function (e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid"),
            jQuery(e).remove();
    },
});