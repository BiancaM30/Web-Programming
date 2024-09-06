$(document).ready(function () {
    $("table th").click(function () {
        var switching = true;
        var nr_cols = $(this).parent().children().length;
        var nr_rows = $(this).parent().parent().children().length;
        while (switching) {
            switching = false;

            for (var col = 2; col <= nr_cols - 1; col++) {
                shouldSwitch = false;
                var x = $(this).parent().children("td:nth-child(" + col + ")").text();
                var y = $(this).parent().children("td:nth-child(" + (
                    col + 1
                ) + ")").text();

                if ($.isNumeric(x) && $.isNumeric(y)) {
                    if ((($(this).hasClass("asc")) && parseInt(x) > parseInt(y)) || (($(this).hasClass("desc")) && parseInt(x) < parseInt(y))) {
                        shouldSwitch = true;
                        break;
                    }
                } else if ((($(this).hasClass("asc")) && x > y) || (($(this).hasClass("desc")) && x < y)) {
                    shouldSwitch = true;
                    break;
                }
            }


            if (shouldSwitch) {
                for (var row = 1; row <= nr_rows; row++) {
                    var temp = $(this).parent().parent().children("tr:nth-child(" + row + ")").children("td:nth-child(" + col + ")").text();

                    $(this).parent().parent().children("tr:nth-child(" + row + ")").children("td:nth-child(" + col + ")").text($(this).parent().parent().children("tr:nth-child(" + row + ")").children("td:nth-child(" + (
                        col + 1
                    ) + ")").text());

                    $(this).parent().parent().children("tr:nth-child(" + row + ")").children("td:nth-child(" + (
                        col + 1
                    ) + ")").text(temp);
                }


                switching = true;
            }
        }

        if ($(this).hasClass("asc")) 
            $(this).removeClass("asc").addClass("desc");
         else 
            $(this).removeClass("desc").addClass("asc");
        
    });

});
