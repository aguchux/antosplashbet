$(".seemore").click(function(){
    $(this).fadeOut();
    $(this).siblings(".detail").addClass("show");
});

$(window).scroll(function(){
    if ($("body").scrollTop() >= 200){
        $(".side_nav").addClass("fixtop");
    }else{
        $(".side_nav").removeClass("fixtop");
    }
});