var pairsFound = 0;
var firstElemId;
var currentClicks = 0;


$(document).ready(function () {
    $("td").on("click", function () {
        currentClicks += 1;
        $(this).find("img").show();
        if (currentClicks % 2 == 1) {
            firstElemId = $(this);
        } else {
            $("#counter").text(currentClicks / 2);
            var secondElemId = $(this);
            if (firstElemId.find("img").attr('src') !== secondElemId.find("img").attr('src')) {
                setTimeout(function () {
                    firstElemId.find("img").hide();
                    secondElemId.find("img").hide();
                }, 2000);
            } else 
                pairsFound += 1;
            
        }

        if (pairsFound === 8) {
            setTimeout(function () {
                text = 'Felicitari, ai castigat jocul din ' + currentClicks / 2 + ' incercari';
                alert(text);
            }, 100);

        }
    });
});


// $(document).ready(function(){
//     $("td").on("click", function(){
//         currentClicks += 1;
//         $(this).find("p").show();
//         if (currentClicks % 2 == 1) {
//             firstElemId = $(this);
//         }
//         else {
//             $("#counter").text(currentClicks/2);
//             var secondElemId = $(this);
//             if (firstElemId.text() !== secondElemId.text()) {
//                 setTimeout(function () {
//                     firstElemId.find("p").hide();
//                     secondElemId.find("p").hide();
//             }, 2000);
//             }
//             else pairsFound += 1;
//         }

//         if (pairsFound === 8) {
//             setTimeout(function (){
//                 text = 'Felicitari, ai castigat jocul din ' + currentClicks / 2 + ' incercari';
//                 alert(text);
//             },100);

//         }
//     });
// });
