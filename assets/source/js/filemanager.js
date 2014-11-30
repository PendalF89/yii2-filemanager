$(document).ready(function() {
    var ajaxRequest = null;

    $('[href="#mediafile"]').on("click", function(e) {
        e.preventDefault();

        if (ajaxRequest) {
            ajaxRequest.abort();
            ajaxRequest = null;
        }

        $(".item a").removeClass("active");
        $(this).addClass("active");
        var id = $(this).attr("data-key");

        ajaxRequest = $.ajax({
            type: "GET",
            url: "/admin/filemanager/file/info",
            data: "id=" + id,
            beforeSend: function() {
                $("#fileinfo").html('<div class="loading"><span class="glyphicon glyphicon-refresh spin"></span></div>');
            },
            success: function(html) {
                $("#fileinfo").html(html);
            }
        });
    });
});