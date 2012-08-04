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
    // 初始化
    $(".entry-content img:not(.wp-smiley)").each(function() {
        
    // 添加 DOM 元素
    $(this).parent().append('<div class="mag"></div>');
    var orig_url = $(this).parent().attr("href");
    $(this).next(".mag").css({"width":"150px","height":"150px","position":"absolute","border-radius":"100%"});
    $(this).next(".mag").css("box-shadow","0 0 0 7px rgba(255,255,255,.85),0 0 7px 7px rgba(0,0,0,.25),inset 0 0 40px 2px rgba(0,0,0,.25)");
    $(this).next(".mag").css("background","url("+ orig_url +") no-repeat");
    $(this).next(".mag").css("display","none");
    // 初始位置，详情见 http://blog.huidesign.com/wp-content/images/explaination.jpg
/*    var init_top = $(this).offset().top - $(this).parent().offset().top - $(this).next(".mag").height()/2;
    alert($(this).parent().offset().top);
    var init_left = $(this).offset().left - $(this).parent().offset().left - $(this).next(".mag").width()/2;
    $(this).next(".mag").css({"top":init_top,"left":init_left});
    //debug
    /* $(this).offset().top = 81.2
       $(this).parent().offset().top = 317
    

    // 获取原始图像寬高
        
    var orig_image = new Image();
    orig_image.src = $(this).parent().attr("href");
    var width_rate = (orig_image.width - $(this).next(".mag").width())/$(this).width();
    var height_rate = (orig_image.height - $(this).next(".mag").height())/$(this).height();
        
    // debug
    /* orig_image.width == 500;
       orig_image.height = 313;
       $(this).next(".mag").width() = 150;
       $(this).next(".mag").height() = 150;
       $(this).height() = 250;
       $(this).width() = 400;
       width_rate = 0.875;
       height_rate = 0.652;
    
    
    $(this).parent().mousemove(function(e){

        var compare_left = e.pageX - $(this).offset().left;
        var compare_top = e.pageY - $(this).offset().top;

        var position_left = e.pageX - $(this).parent().offset().left - $(this).next(".mag").width()/2;
        var position_top = e.pageY - $(this).parent().offset().top - $(this).next(".mag").height()/2;
        
        var bg_left = compare_left * width_rate;
        var bg_top = compare_top * height_rate;
        
        var imgW = $(this).width() + 25;
        var imgH = $(this).height() + 25;
        
        if (compare_left > 0 & compare_left < imgW & compare_top > 0 & compare_top < imgH) {
            $(this).next(".mag").fadeIn(100).css({"left":position_left,"top":position_top,"background-position":"-" + bg_left + "px -" + bg_top + "px"});
        } else {
            $(this).next(".mag").fadeOut(100);
        }
    });
*/
    });
​
});
