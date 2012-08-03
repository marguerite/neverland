$(document).ready(function(){
	
	// 日历的鼠标悬浮
	$("#wp-calendar tbody td").hover(function(){
		$(this).not(".pad").css("background-color","#5baddc");
		$(this).not(".pad").css("color","white");
		$(this).children("a").css("color","white");
		},
		function() {
				$(this).css("background-color","#f5f5f5");
				$(this).css("color","");
				$(this).children("a").css("color","");
			}
		);

	// 图片的 instagram 特效
	// 去掉继承的链接箭头
	$(window).load(function(){
		$(".entry-content img").each(function(){
			var image_width = $(this).width();
			var image_height = $(this).height();
		// 默认缩放图片
		if( image_width > 300) {
			$(this).width(300);
			$(this).height(image_height*(300/image_width));
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
	
	// 相册
	// 删除分列用的 <br>
	$(".gallery br").remove();
	// 最后加上一个 br 来去浮动
	$(".gallery").append("<br/>");
	$(".gallery br").css("clear","both");
	// 随机数字的左右倾斜
	$(".gallery img").each(function(){
		var deg_high = 15, deg_low = -15;
		var adjustedhigh = deg_high - deg_low + 1;
		var deg_random = Math.floor(Math.random()*adjustedhigh) + deg_low;
		$(this).css("-webkit-transform",'rotate('+deg_random+'deg)');
		$(this).css("-moz-transform",'rotate('+deg_random+'deg)');
	});
	
	// 柱状图的高度计算
	var max_width = 0;
	$('.bar-chart td.cat_bar').each(function (i, n) {
	if (max_width < $(n).width()) {
	max_width = $(n).width();
	}
	});
	var max_number = max_width/5;
	var width_average = ($(".bar-chart").width() - $(".bar-chart td.cat_name").width())/max_number;
	$(".bar-chart td.cat_bar").each(function(){
		var width_mutiple = $(this).width()/5;
		$(this).width(width_mutiple*width_average);
	});
	
	// 匹配「KDE提交摘要*」，把它的 p 换成外面包上 ul li
	$(".post").each(function(){
		if ( $(this).children(".entry-title").children("a").text().match('KDE.*\\(\\d{4}\\/\\d{1,2}\\/\\d{1,2}\\)') != null ) {
			var content = $(this).children(".entry-content");
            		var html = content.html();
            		html = html.replace(/<p>/g,"<ul><li>").replace(/<\/p>/g,"</li></ul>").replace(/<br>/g,"</li><li>");
            		content.html(html);
		}
		if ( $(this).children(".entry-title").text().match('KDE.*\\(\\d{4}\\/\\d{1,2}\\/\\d{1,2}\\)') != null ) {
			var content = $(this).children(".entry-content");
            		var html = content.html();
            		html = html.replace(/<p>/g,"<ul><li>").replace(/<\/p>/g,"</li></ul>").replace(/<br>/g,"</li><li>");
            		content.html(html);
		}
	});
	
	// 标签云的正圆
	$("a[class^=tag-link]").each(function(i, obj){

		var clone;
		var position;
		clone = $(obj).clone();

		/*
		//得到clone的宽度并增加一些呼吸空间
		var cloneWidth = $(obj).width() + 20;
		var cloneHeight = $(obj).height() + 20;
		*/
		
		/* 算法说明
			首先圆有宽度 10% 的 padding，这样两边一共是 20%，圆的实际宽度是 cloneWidth*1.2;
			elements 的 position 都是取最左上角一点的。于是要让圆看起来位置没变化：
			它的宽度就应该往左移动 cloneWidth*0.1;
			高度有点复杂，它应该向上移动 (现在的圆高度/2 - 原来的高度/2 );
			现在的圆高度由于有 padding，是 cloneHeight*1.2;
			原来的高度是 cloneHeight;
			但是原来的 element 是个长方形，现在的 element 是个圆，直径等于 cloneWidth*1.2;
			因为有 css("height", cloneWidth)，刚克隆来的原来的高度被抹掉了，于是我们需要一个变量来记住它:
			$(clone).data("heightsave",cloneHeight);
			以上，圆的 position 调整变为：
			top = position.top - (cloneWidth*1.2 - $(clone).data("heightsave"))/2;
			left = position.left - cloneWidth*0.1;
		*/
		
		var cloneWidth = $(obj).width();
		var cloneHeight = $(obj).height();
		$(clone).data("heightsave",cloneHeight);
		
		$(clone).addClass("clonedItem");
		position = $(obj).position();

		$(obj).bind("mouseover", function(e){

			$(".tagcloud a").css("z-index","1");

			$(clone).css("height", cloneWidth).css("width", cloneWidth).css("z-index", 1000).css("line-height", cloneWidth + 'px');
			$(clone).css({"background-color":"#0068c6","color":"white"});
			
			//clone 的 padding+radius
			$(clone).css("padding", cloneWidth*0.1).css("border-radius", cloneWidth*1.2 / 2 + 'px').css("-webkit-border-radius", cloneWidth*1.2 / 2 + 'px').css("-khtml-border-radius", cloneWidth*1.2 / 2 + 'px').css("-moz-border-radius", cloneWidth*1.2 / 2 + 'px');
			
			//clone 的 position
			$(clone).css("top", position.top - (cloneWidth*1.2 - $(clone).data("heightsave"))/2);
			$(clone).css("left", position.left - cloneWidth*0.1);
			
			$(clone).appendTo($(this).parents(".tagcloud")).css("position", "absolute");
			

			$(clone).bind("mouseout", function(e){
				$(".clonedItem").remove(); //防止鼠标过快移动无法清除一些背景
				$(clone).remove();
				// 清除 z-index
				$(".tagcloud a").css("z-index","");
			});

		}); 

	}); // end each
	
	// 删除 translate 插件那条奇丑无比的线
	$(".translate_hr").remove();
	
	// 加载语法高亮
	$("pre.spec").snippet("spec",{style:"acid"});
	$("pre.c").snippet("c",{style:"acid"});
	$("pre.cpp").snippet("cpp",{style:"acid"});
	$("pre.makefile").snippet("makefile",{style:"acid"});
	$("pre.dekstop").snippet("desktop",{style:"acid"});
	$("pre.changelog").snippet("changelog",{style:"acid"});
	$("pre.log").snippet("log",{style:"acid"});
});