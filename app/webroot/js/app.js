$(document).ready(function () {
    $(".modal-ajax").on("show.bs.modal", function (e) {
        $(this).find(".modal-content").html("");
        ajaxLoadingStart();
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("href"),function(){
            ajaxLoadingSuccess();
        });
    });
});