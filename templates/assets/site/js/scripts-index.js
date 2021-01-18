var count_start = 153046789;
$(document).ready(function(){
	sliderInit();
	counterInit();
	marqueeInit();

	var tick = 0;
	var t = setInterval(function(){
		tick++;
		if (tick == 6){
			$("html,body").animate({
				scrollTop:600
			},1000);
			clearInterval(t);
			$(window).off("mousemove");
		}
	},1000);
/* 	$(window).mousemove(function(){
		tick = 0;
	});

	if ($(window).scrollTop() >= 400){
		od1.update(3);
		od2.update(121);
	}

	$(window).scroll(function() {
		clearInterval(t);
		$(window).off("mousemove");
		closeAllPanel();
		if ($(this).scrollTop() >= 400){
			od1.update(3);
			od2.update(121);
			$(window).off("scroll");
			$(window).scroll(function() {
				closeAllPanel();
			});
		}
	});

	gameCountdown("game1",10000);
	gameCountdown("game2",40000);
	gameCountdown("game3",30000); */
});

function sliderInit(){
	$('.banner').on("afterChange",function(slick, c, currentSlide){
		var now = currentSlide+1;
		$(".banner .slider").removeClass("active");
		$(".banner").find(".slider"+now).addClass("active");
	});
	$('.banner').slick({
		dots: true,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 5000
	});
}

function counterInit(){
	var el = document.querySelector('.slots .num');
	od = new Odometer({
		el: el,
		value: count_start,
  		format: 'd',
	});
	counterPlus(123);

	setInterval(function(){
		counterPlus(123);
	},8000);
}

function counterPlus(plus){
	od.update(count_start+plus);
	count_start += plus;
	$(".icon-slot_bar").addClass("active");
	setTimeout(function(){$(".icon-slot_bar").removeClass("active");},400);
} 

function marqueeInit(){
	var now = 0;
	var total = $(".marquee .word .list").size();
	marqueeAnimate(now);
	var t = setInterval(function(){
		now++;
		if (now == total) now = 0;
		marqueeAnimate(now);
	},12000);
}
function marqueeAnimate(n){
	var tar = $($(".marquee .word .list")[n]);
	tar.animate({
		"left" : 0
	},15000,function(){
		setTimeout(function(){
			tar.fadeOut(500,function(){
				tar.css({
					"left":"1100px",
					"display":"inline"
				});
			});
		},1800);
	});
}


function openBanking(evt, cityName) {
	var i, x, tablinks;
	x = document.getElementsByClassName("banking");
	for (i = 0; i < x.length; i++) {
	  x[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablink");
	for (i = 0; i < x.length; i++) {
	  tablinks[i].className = tablinks[i].className.replace(" banking-red", "");
	}
	document.getElementById(cityName).style.display = "block";
	evt.currentTarget.className += " banking-red";
  }