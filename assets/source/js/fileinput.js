$(document).ready(function() {
    var btnId = $("#filemanager-modal").attr("data-btn-id"),
        frameSrc = $("#filemanager-modal").attr("data-frame-src");

    $("#" + btnId).on("click", function(e) {
        e.preventDefault();
        var iframe = '<iframe src="' + frameSrc + '" id="filemanager-frame" frameborder="0"></iframe>';
        $("#filemanager-modal .modal-body").html(iframe);
        $("#filemanager-modal").modal("show");
    });
});