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
	var max_number = 0;
	$('.bar-chart td.cat_bar').each(function (i, n) {
		var number = parseInt($(this)[0].innerHTML);
		if (number > max_number) {
			max_number = number;
		}
		$(this).css("min-width", "10px");
	});
	if (max_number <= 0)
		max_number = 1;
	$(".bar-chart td.cat_bar").each(function(){
		var number = parseInt($(this)[0].innerHTML);
		if (number <= 0)
			number = 1;
		$(this).css("width", (number / max_number * 100) + "%");
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
	$("pre.sh").snippet("sh",{style:"acid"});
});
