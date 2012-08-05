$(document).ready(function(){
	// 图片的 instagram 特效
	// 去掉继承的链接箭头
	$(window).load(function(){
		$(".entry-content img:not(.wp-smiley)").each(function(){
			var actual_image = new Image();
			actual_image.src = $(this).attr("src");
			var image_width = actual_image.width;
			var image_height = actual_image.height;
			var ideal_width = $(".content").width()*0.75;
		// 默认缩放图片
			if( $(this).width() > ideal_width) {
				$(this).width(ideal_width);
				$(this).height(image_height*(ideal_width/image_width));
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
			//var href = actual_image.src
			//if ($(this).parent("a").length <= 0) {
			//	$(this).wrap('<a href="'+href+'"> </a>');
			//}
			$(this).parent().css({"background":"none","border":"none","margin":"0","padding":"0"});
			$(this).css("padding","10px 10px 25px 10px");
		// 处理 nihui 那种自传图片的达人
			if (image_width < 24) {
				$(this).css({"backgroud":"none","border":"none","box-shadow":"none","padding":"none"});
			}
		});
	});
});
