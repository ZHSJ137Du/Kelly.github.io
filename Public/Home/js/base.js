// $act=$('#header .navbar .container .navbar-left li');
// $act.hover(function () {
//     $(this).addClass('active').siblings().removeClass('active');
// });
$cur=$('#content .container .row .col-md-4');
// console.log($cur.eq(1));
$cur.eq(1).children('.wrap').css('opacity','0').siblings().css('opacity','1');
$cur.on('mouseenter',function () {
    $(this).addClass('cur').siblings().removeClass('cur');
    $(this).children('.wrap').stop().animate({opacity:0}).siblings().stop().animate({opacity:1});
});
$cur.on('mouseleave',function () {
    $(this).children('.wrap').stop().animate({opacity: 1}).siblings().stop().animate({opacity: 0});
});
// },setTimeout(function () {
//     $cur.eq(1).children('.wrap').css('opacity','0').siblings().css('opacity','1');
// },2000));


// $link=$('.media .media-link ').children();
// // console.log($link);-183+"px"
// $link.hover(function () {
//     console.log($link.eq($(this).index()).backgroundPosition().spilt(" ")[0]);
// });

$(window).scroll(function () {
    // console.log($(window).scrollTop());
    if($(window).scrollTop()>=200) {
        $("#header .navbar .container").stop().animate({
            height:"50px",
            top:"0px",
            "font-size": "14px"});
        $("#header .navbar .container .navbar-brand ").stop().animate({
            "font-size": "12px",
            "padding":"10px 2px",
            "border-radius":"7px",
            "top":"2px",
            "line-height":"14px",
            "height": "47px"})
    }else{
        $("#header .navbar .container").stop().animate({height:"76px",top:"10px","font-size": "16px"});
        $("#header .navbar .container .navbar-brand ").stop().animate({
            "font-size": "16px",
            "border-radius": "15px",
            "height": "60px",
            "top": "-2px",
            "padding": "10px",
            "line-height":"20px"
        })
    }
});




    $('.owl-carousel').owlCarousel({
        item:7,
        loop:true,
        mouseDrag:true,
        touchDrag:true,
        autoWidth:true,
        nav:true,
        navText:["",""],
        margin:50,
        dots:false,
        slideBy:6,
        autoplay:true,
        autoplayHoverPause:true,
        autoplayTimeout:5000
    });


    $('#content .container .row .col-lg-12 .input-defined').animate({width:'50%'});

    $circle=$('.chat .container .row .col-md-3');
    $circle.hover(function () {
        // console.log($circle.eq($(this).index()));
        $circle.eq($(this).index()).children('.circle').css({'transform': 'rotate(360deg)','transition':'all .5s ease-in-out'})
    },function () {
        $circle.eq($(this).index()).children('.circle').css({'transform': 'rotate(-360deg)','transition':'all .5s ease-in-out'})
    });

var wow = new WOW({
    boxClass: 'wow',
    animateClass: 'animated',
    offset: 150,
    mobile: true,
    live: true
});
wow.init();