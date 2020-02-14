$(document).ready(function(){
    //menu top
    $("#menu_top .menu_l1").children("li").hover(function(){
        $(this).addClass("mhover");
    },function(){
        $(this).removeClass("mhover");
    })
    //hover 
    $("ul.nav li a").hover(function(){
        $(this).animate({"padding-left":10},100);
    },function(){
        $(this).animate({"padding-left":0},100);
    });
    //pslider
    $pslider = $("#pslider_main");
    if($pslider.length)$pslider.jCarouselLite({
        auto : 3000,
        speed : 500,
        visible: 4,
        btnNext: "#btnext",
        btnPrev: "#btpre"
    });
});