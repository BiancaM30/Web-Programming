$(document).ready(function () {
    var slideIndex = 1;
    var slides = $(".mySlides li");

    var interval = setInterval(function () {
        $('.mySlides li').eq(slideIndex - 1).hide();
        if (slideIndex < 4) 
            slideIndex += 1;
         else 
            slideIndex = 1;
        
        $('.mySlides li').eq(slideIndex - 1).show();

    }, 3000);

    $(".prev").on("click", function () {
        $('.mySlides li').eq(slideIndex - 1).hide();
        slideIndex = slideIndex - 1;
        if (slideIndex < 1) 
            slideIndex = slides.length;
        
        $('.mySlides li').eq(slideIndex - 1).show();
    });

    $(".next").on("click", function () {
        $('.mySlides li').eq(slideIndex - 1).hide();
        slideIndex = slideIndex + 1;
        if (slideIndex > slides.length) 
            slideIndex = 1;
        
        $('.mySlides li').eq(slideIndex - 1).show();
    });
});
