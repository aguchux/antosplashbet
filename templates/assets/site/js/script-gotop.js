//<!GoTOP
(function () {
    $("body").append("<img id='goTopButton' style='display: none; z-index: 5; cursor: pointer;' title='goTop'/>");
    var img = "./images/gotop.png",
    locatioin = 9/10, // button's position in the screen
    right = 10, // position right
    opacity = 0.3, // transprent
    speed = 500, // scrolling speed
    $button = $("#goTopButton"),
    $body = $(document),
    $win = $(window);
    $button.attr("src", img);
    $button.on({
    mouseover: function() {$button.css("opacity", 1);},
    mouseout: function() {$button.css("opacity", opacity);},
    click: function() {$("html, body").animate({scrollTop: 0}, speed);}
    });
    window.goTopMove = function () {
    var scrollH = $body.scrollTop(),
    winH = $win.height(),
    css = {"top": winH * locatioin + "px", "position": "fixed", "right": right, "opacity": opacity};
    if(scrollH > 20) {
    $button.css(css);
    $button.fadeIn("slow");
    } else {
    $button.fadeOut("slow");
    }
    };
    $win.on({
    scroll: function() {goTopMove();},
    resize: function() {goTopMove();}
    });
    } )();
    //]]>
