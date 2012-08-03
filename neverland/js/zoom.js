$(document).ready(function(){
	
	// 图片的 instagram 特效
	// 去掉继承的链接箭头
	$(window).load(function(){
		$(".entry-content img:not(.wp-smiley)").each(function(){
			var image_width = $(this).width();
			var image_height = $(this).height();
		// 默认缩放图片
		if( image_width > 400) {
			$(this).width(400);
			$(this).height(image_height*(400/image_width));
			//鼠标划过回归原来大小
			/* $(this).hover(function(){
				$(this).width(image_width);
				$(this).height(image_height);
			},function(){
				$(this).width(300);
				$(this).height(image_height*(300/image_width));
			}); */
		}

		// 缩放后的图片如果父元素没有链接就给它加上到 src 的链接
		var href = $(this).attr("src");
		if ($(this).parent("a").length <= 0) {
			$(this).wrap('<a href="'+href+'"> </a>');
		}
		$(this).parent().css({"background":"none","border":"none","margin":"0","padding":"0"});
		$(this).css("padding","10px 10px 25px 10px");
		});
	});

	// 放大镜
	
	$(".entry-content img:not(.wp-smiley)").mousemove(function(e){
		//Initial Magnifier
		$(this).parent("a").append('<div class="mag"></div>');
		$(".mag").css({"width":"150px","height":"150px","position":"absolute","border-radius":"100%"});
		$(".mag").css("box-shadow","0 0 0 7px rgba(255,255,255,.85),0 0 7px 7px rgba(0,0,0,.25),inset 0 0 40px 2px rgba(0,0,0,.25)");
		$(".mag").css("background","url("+$(this).parent().attr("href")+") no-repeat");

		var ratiotop = (e.pageY - $(this).position().top)/$(this).height()*100;
		var ratioleft = (e.pageX - $(this).position().left)/$(this).width()*100;
			
		var bgp = ratioleft + "%" + ratiotop + "%";
		var px = e.pageX - $(".mag").width()/2;
		var py = e.pageY - $(".mag").height()/2;
		
		$(".mag").css({"background-position":bgp,"top":py,"left":px});
		/*
		if(ratiotop >= 0 && ratiotop <= 100 && ratioleft >= 0 && ratioleft <= 100){
			$(".mag").fadeIn(100);
		} else {
			$(".mag").fadeOut(100);
			$(this).parent().child(".mag").remove();
		}*/
	});
});
