$(document).ready(function() {
    var modalElem = $("#filemanager-modal"),
        btnElem = $("#" + modalElem.attr("data-btn-id")),
        inputElem = $("#" + modalElem.attr("data-input-id")),
        iframe = '<iframe src="' + modalElem.attr("data-frame-src") + '" id="filemanager-frame" frameborder="0"></iframe>';

    function getFormData(form) {
        var formArray = form.serializeArray(),
            data = [];

        for (var i=0; formArray.length > i; i++) {
            data[formArray[i].name] = formArray[i].value;
        }

        return data;
    }

    function frameHandler(e) {
        $(this).contents().find(".dashboard").on("click", "#insert-btn", insertHandler);
    }

    function insertHandler(e) {
        e.preventDefault();

        var data = getFormData($(this).parents("form"));
        inputElem.trigger("fileInsert", [data]);
        inputElem.val(data['image']);
        modalElem.modal("hide");
    }

    btnElem.on("click", function(e) {
        e.preventDefault();

        modalElem.find(".modal-body").html(iframe);
        $("#filemanager-frame").on("load", frameHandler);
        $("#filemanager-modal").modal("show");
    });
});