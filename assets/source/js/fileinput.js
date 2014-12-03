$(document).ready(function() {

    function getFormData(form) {
        var formArray = form.serializeArray(),
            modelMap = {
                'Mediafile[alt]': 'alt',
                'Mediafile[description]': 'description',
                url: 'url'
            },
            data = [];

        for (var i=0; formArray.length > i; i++) {
            if (modelMap[formArray[i].name]) {
                data[modelMap[formArray[i].name]] = formArray[i].value;
            }
        }

        return data;
    }

    function frameHandler(e) {
        var modal = $(this).parents('[role="filemanager-modal"]'),
            imageContainer = $(modal.attr("data-image-container")),
            input = $("#" + modal.attr("data-input-id"));

        $(this).contents().find(".dashboard").on("click", "#insert-btn", function(e) {
            e.preventDefault();

            var data = getFormData($(this).parents("#control-form"));

            input.trigger("fileInsert", [data]);

            if (imageContainer) {
                imageContainer.html('<img src="' + data.url + '" alt="' + data.alt + '">');
            }

            input.val(data['url']);
            modal.modal("hide");
        });
    }

    $('[role="filemanager-launch"]').on("click", function(e) {
        e.preventDefault();

        var modal = $('[data-btn-id="' + $(this).attr("id") + '"]'),
            iframe = $('<iframe src="' + modal.attr("data-frame-src")
                + '" id="' + modal.attr("data-frame-id") + '" frameborder="0" role="filemanager-frame"></iframe>');

        iframe.on("load", frameHandler);
        modal.find(".modal-body").html(iframe);
        modal.modal("show");
    });
});