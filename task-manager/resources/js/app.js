require('./bootstrap');

$("#my-alert-wrap").animate
    ({
        opacity: 1
    }, 1000).delay(7000).animate({
        opacity: "hide",
    }, 4000);

