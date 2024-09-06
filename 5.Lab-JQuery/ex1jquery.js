$(document).ready(function () {
    $("option").on("dblclick", function () {
        if ($(this).parent().is("#notFavoriteList")) {
            $(this).detach().appendTo("#favoriteList");
        } else {
            $(this).detach().appendTo("#notFavoriteList");
        }
    });
});
