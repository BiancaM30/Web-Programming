function sortTableVertical(column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tableV");
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].cells[column];
            y = rows[i + 1].cells[column];
            if (!isNaN(Number(x.innerText)) && !isNaN(Number(y.innerText))) {
                if (Number(x.innerText) > Number(y.innerText)) {
                    shouldSwitch = true;
                    break;
                }
            }
            else if (x.innerHTML > y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

function sortTableHorizontal(line) {
    var table, rows, switching, i, shouldSwitch;
    table = document.getElementById("tableH");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows[line].cells.length - 1); i++) {
            shouldSwitch = false;
            var x = rows[line].cells[i];
            var y = rows[line].cells[i + 1];
            if (!isNaN(Number(x.innerText)) && !isNaN(Number(y.innerText))) {
                if (Number(x.innerText) > Number(y.innerText)) {
                    shouldSwitch = true;
                    break;
                }
            }
            else if (x.innerHTML > y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            for (var l = 0; l < (rows.length); l++) {
                var aux = rows[l].cells[i].innerText;
                rows[l].cells[i].innerText = rows[l].cells[i + 1].innerText;
                rows[l].cells[i + 1].innerText = aux;
            }
            switching = true;
        }
    }
}

