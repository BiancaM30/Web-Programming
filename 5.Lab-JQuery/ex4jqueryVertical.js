$(document).ready(function () {
    $('th').click(function () {
        var table = $(this).parents('table');
        var selectedColumnIndex = $(this).index();
        if ($(this).hasClass("asc")) {
            var rows = table.find('tr:gt(0)').toArray().sort(comparerASC(selectedColumnIndex));
            $(this).removeClass("asc").addClass("desc");
        } else {
            var rows = table.find('tr:gt(0)').toArray().sort(comparerDESC(selectedColumnIndex))
            $(this).removeClass("desc").addClass("asc");
        }

        for (var i = 0; i < rows.length; i++) {
            table.append(rows[i]);

        }

    });
});


function comparerASC(index) {
    return function (a, b) {
        var valA = $(a).children('td').eq(index).text();
        var valB = $(b).children('td').eq(index).text()
        if ($.isNumeric(valA) && $.isNumeric(valB)) 
            return valA - valB;
         else 
            return valA.toString().localeCompare(valB);
        

    }
}

function comparerDESC(index) {
    return function (a, b) {
        var valA = $(a).children('td').eq(index).text();
        var valB = $(b).children('td').eq(index).text()
        if ($.isNumeric(valA) && $.isNumeric(valB)) 
            return valB - valA;
         else 
            return valB.toString().localeCompare(valA);
        

    }
}
