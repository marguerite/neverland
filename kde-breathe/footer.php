<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

	<div id="footer">
                <div id="colophon">
			<div id="site-info">
				<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
           designed by marguerite. Better experience in firefox and webkit.
			</div><!-- #site-info -->

			<div id="site-generator">
				<?php do_action( 'twentyten_credits' ); ?>
				<a class="wordpress" href="<?php echo esc_url( __('http://wordpress.org/', 'twentyten') ); ?>"
						title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'twentyten'); ?>" rel="generator">
					<?php printf('WordPress', 'twentyten'); ?>
				</a>
				<a class="cc" href="">
					& 创作共享 CC 协议
				</a>
				<a class="gimp" href="http://gimp.org">
					& GIMP (I'm not using Photoshop).
				</a>
			</div><!-- #site-generator -->

		</div><!-- #colophon -->
	</div><!-- #footer -->

<script type="text/javascript">
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
		// 标签云的正圆
		$(".tagcloud a").hover(function(){
			var width = $(this).width();
			var height = $(this).height();
			var lineheight = $(this).css("width");
			var parentheight = $(this).parent().height();
			$(this).data("heightsave",height);
			   $(this).width(width);
				$(this).height(width);
				$(this).css({"display":"inline-block","background-color":"#5baddc","color":"white"});
				$(this).css({"border-radius":width*1.2/2,"line-height":lineheight});
				$(this).css({"padding":width*0.1});
				// 它父元素下面的元素就不会跳来跳去了
				$(this).parent().height(parentheight);
				// 通过让它的父元素相对，它自己和兄弟元素都绝对，来让兄弟元素不跳
				$(this).parent().css("position","relative");
				// 处理她自己的位置，让它原地缩放
				var top = $(this).position().top - (width*1.2 - height)/2;
				var left = $(this).position().left - width*0.1;
				$(this).css({"position":"absolute","z-index":"999","top":top,"left":left});
				// 在它的下方放一个和它同样寬高的元素来占位，让兄弟元素不跑到它下面
				$(this).after('<a class="brick"></a>');
				$(this).parent().children(".brick").css({"width":width,"height":height,"display":"inline-block"});
			},function(){
				$(this).height($(this).data("heightsave"));
				$(this).css({"display":"","background-color":"","color":"","line-height":"","border-radius":"","padding":""});
				$(this).parent().height();
				// 删除占位元素
				$(this).parent().children(".brick").remove();
				$(this).css({"position":"","z-index":"","top":"","left":""});
				$(this).parent.css("position","");
				}
		);
		// 图片的 instagram 特效
			// 去掉继承的链接箭头
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
				$(this).parent().css({"background":"none","border":"none","margin":"0","padding":"0"});
				$(this).css({"padding":image_width*0.02,"padding-bottom":image_width*0.1});
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
		});
</script>
<!-- syntax highlight -->
<script type="text/javascript" src="http://localhost/wordpress/wp-content/themes/kde-breathe/js/jquery.snippet.js"></script>
<script type="text/javascript" src="http://localhost/wordpress/wp-content/themes/kde-breathe/js/sh_changelog.js"></script>
<script type="text/javascript" src="http://localhost/wordpress/wp-content/themes/kde-breathe/js/sh_desktop.js"></script>
<script type="text/javascript" src="http://localhost/wordpress/wp-content/themes/kde-breathe/js/sh_log.js"></script>
<script type="text/javascript" src="http://localhost/wordpress/wp-content/themes/kde-breathe/js/sh_makefile.js"></script>
<script type="text/javascript" src="http://localhost/wordpress/wp-content/themes/kde-breathe/js/sh_spec.js"></script>
<script>
	$(document).ready(function(){
			$("pre.spec").snippet("spec",{style:"acid"});
			$("pre.c").snippet("c",{style:"acid"});
			$("pre.cpp").snippet("cpp",{style:"acid"});
			$("pre.makefile").snippet("makefile",{style:"acid"});
			$("pre.dekstop").snippet("desktop",{style:"acid"});
			$("pre.changelog").snippet("changelog",{style:"acid"});
			$("pre.log").snippet("log",{style:"acid"});
			});
</script>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
