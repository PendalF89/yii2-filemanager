$(document).ready(function() {
    var modalElem = $("#filemanager-modal"),
        btnElem = $("#" + modalElem.attr("data-btn-id")),
        inputElem = $("#" + modalElem.attr("data-input-id")),
        iframe = '<iframe src="' + modalElem.attr("data-frame-src") + '" id="filemanager-frame" frameborder="0"></iframe>';


    function getFormArray(form) {
        var formArray = form.serializeArray(),
            data = [];

        for (var i=0; formArray.length > i; i++) {
            data[formArray[i].name] = formArray[i].value;
        }

        return data;
    }

    function insertHandler(e) {
        var iframe = $(this).contents();

        iframe.find(".dashboard").on("click", "#insert-btn", function(e) {
            e.preventDefault();

            var data = getFormArray($(this).parents("form"));
            inputElem.val(data['image']);

            modalElem.modal("hide");
        });
    }

    btnElem.on("click", function(e) {
        e.preventDefault();

        modalElem.find(".modal-body").html(iframe);
        $("#filemanager-frame").on("load", insertHandler);
        $("#filemanager-modal").modal("show");
    });

    console.log( inputElem.val() );
});