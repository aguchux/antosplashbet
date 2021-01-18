$(document).ready(function(){
	navInit();
	headerInit();
	footerInit();
	$(document).scrollScope();

	$("a").click(function(e){
		if ($(this).attr("href") == "#"){
			e.preventDefault();
		}
	});

	$(window).scroll(function() {
		closeAllPanel();
	});
});

function nav_multi(tar_ori){
	var tar = $("nav ."+tar_ori);
	$("nav .link_"+tar_ori).addClass("active");
	tar.addClass("show");

	$(".collapse").mouseleave(function(){
		$(this).removeClass("show");
		$("nav > .wrapper > a > .link").removeClass("active");
	});
}

function closeAllPanel(){
	$(".account .icon-multi_w").removeClass("reverse");
	$(".userpanel").removeClass("show");
	$(".collapse").removeClass("show");
	$("nav > .wrapper > a > .link").removeClass("active");
}
function headerInit() {
	$("header .account").mouseover(function(){
		closeAllPanel();
		$(".userpanel").addClass("show");
		$(this).find(".icon-multi_w").addClass("reverse");
	});
	$(".userpanel").mouseleave(function(){
		$(".userpanel").removeClass("show");
		$("header .account").find(".icon-multi_w").removeClass("reverse");
	});
}

function navInit(){
	$(".collapse .footer").click(function(){
		closeAllPanel();
	});


	$("nav .link_lobby").mouseover(function(){
		closeAllPanel();
		nav_multi("lobby");
	});
	$("nav .link_promo").mouseover(function(){
		closeAllPanel();
		nav_multi("promo");
	});
}

function footerInit(){
	$("footer .language").click(function(){
		var tar = $("footer .languageList");
		if (tar.css("display") == "none"){
			$("footer .languageList").show(300);	
		}else{
			$("footer .languageList").hide(300);
		}
	});
}

function openPopup(tar){
	$(".popup").addClass("show");
	tar.addClass("show");
	$(".btn_close").click(function(){
		closePopup();
	});
}

function closePopup(){
	$(".btn_close").off("click");
	$(".popup").removeClass("show");
	$(".popup > div").removeClass("show");
}

function systemError(message){
	$(".systemError").addClass("show");
	$(".systemError .message").text(message);
	$(".systemError").click(function(){
		$(this).off("click");
		$(this).removeClass("show");
	});
}

function rangeSliderInit(){
	/*----------------------- rangeslider start -----------------------*/
	$('input[type="range"]').rangeslider({
		polyfill: false,
	});
	$(document).on('input', 'input[type="range"]', function(e) {
		var tar = $(e.target);
        tar.parent().parent().next().find("input").val(tar.val());
        
        var max = tar.attr("max");
        var min = tar.attr("min");
        var minPercentage = 7.25;
        var discount = (100 / minPercentage).toFixed(2);
        var percentage = ((100/(max-min)).toFixed(2)*(tar.val()-min)).toFixed(2);
        percentage = (percentage / discount).toFixed(2);
        if (percentage > minPercentage) percentage = "7.25";
        percentage = (minPercentage - percentage).toFixed(2);
        tar.parent().prev().find(".percentage").text(percentage+"%");
    });
    $(document).on('input', 'input[type="range"][master]', function(e) {
    	var tar = $(e.target);
    	tar.parent().parent().next().find("input").val(tar.val());

    	var max = tar.attr("max");
    	var min = tar.attr("min");
    	var minPercentage = 7.25;
    	var discount = (100 / minPercentage).toFixed(2);
    	var percentage = ((100/(max-min)).toFixed(2)*(tar.val()-min)).toFixed(2);
    	percentage = (percentage / discount).toFixed(2);
    	if (percentage > minPercentage) percentage = "7.25";
    	percentage = (minPercentage - percentage).toFixed(2);
    	tar.parent().prev().find(".percentage").text(percentage+"%");
        //影響所有bar
        tar.parent().parent().parent().parent().find("input[type=range]").not("input[master]").each(function(i){
        	$(this).val(tar.val()).change();
        	$(this).parent().prev().find(".percentage").text(percentage+"%");
        })
    });
    $(".slider_group .plus").click(function(){
    	var now = $(this).siblings("input").val();
    	now++;
    	$(this).siblings("input").val(now).change();
    })
    $(".slider_group .minus").click(function(){
    	var now = $(this).siblings("input").val();
    	now--;
    	$(this).siblings("input").val(now).change();
    })
    /*----------------------- rangeslider end -----------------------*/
}

function switcherInit(){
	/*----------------------- switcher start -----------------------*/
    $(".switch_group .left").click(function(){
    	$(this).addClass("active");
    	$(this).siblings(".right").removeClass("active");
    	$(this).siblings(".switcher").find(".handler").removeClass("right");
    });
    $(".switch_group .right").click(function(){
    	$(this).addClass("active");
    	$(this).siblings(".left").removeClass("active");
    	$(this).siblings(".switcher").find(".handler").addClass("right");
    });
    $(".switch_group .switcher").click(function(){
    	if ($(this).find(".handler").hasClass("right")){
    		$(this).find(".handler").removeClass("right");
    		$(this).siblings(".right").removeClass("active");
    		$(this).siblings(".left").addClass("active");
    	}else{
    		$(this).find(".handler").addClass("right");
    		$(this).siblings(".right").addClass("active");
    		$(this).siblings(".left").removeClass("active");
    	}
    });
    /*----------------------- switcher end -----------------------*/
}

function checkExist(tar){
	if (tar.length > 0) return true;
	else return false;
}