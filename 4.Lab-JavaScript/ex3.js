var pairsFound = 0;
var firstElemId;
var currentClicks = 0;

function numberGame(id) {
    currentClicks += 1;
    document.getElementById(id).style = "display: block";
    if (currentClicks % 2 == 1) {
        firstElemId = id;
    }
    else {
        document.getElementById("counter").innerHTML = currentClicks / 2;
        var secondElemId = id;
        if (document.getElementById(firstElemId).innerText !== document.getElementById(secondElemId).innerText) {
            setTimeout(function () {
                document.getElementById(firstElemId).style = "display: none";
                document.getElementById(secondElemId).style = "display: none";
            }, 2000);
        }
        else pairsFound += 1;
    }

    if (pairsFound === 8) {
        setTimeout(function (){
        text = 'Felicitari, ai castigat jocul din ' + currentClicks / 2 + ' incercari';
        alert(text);
        },100);

    }
}


function imageGame(id) {
    currentClicks += 1;
    document.getElementById(id).style = "width: 80px, height: 80px; display: block"; 
    if (currentClicks % 2 == 1) {
        firstElemId = id;
    }
    else {
        document.getElementById("counter").innerHTML = currentClicks / 2;
        var secondElemId = id;
        if (document.getElementById(firstElemId).src !== document.getElementById(secondElemId).src) {
            setTimeout(function () {
                document.getElementById(firstElemId).style = "width:80px; height: 80px; display: none";
                document.getElementById(secondElemId).style = "width:80px; height: 80px; display: none";
            }, 2000);
        }
        else pairsFound += 1;
    }

    if (pairsFound === 8) {
        setTimeout(function () {
            text = 'Felicitari, ai castigat jocul din ' + currentClicks / 2 + ' incercari';
            alert(text);
        }, 100);

    }
}
