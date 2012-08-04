$(document).ready(function(){    
    // 放大镜
    // 初始化
    $(".entry-content img:not(.wp-smiley)").each(function() {
      
    // 修复可恶的 skydrive
    if( $(this).parent().attr("href").match(/(https?\:\/\/\w+\.\w+\.livefilestore\.com\/[^ \/]*\/.*\.(jpg|png)\?)psid=1/g) ) {
        var newhref = $(this).parent().attr("href").replace("?psid=1","");
        $(this).parent().attr("href",newhref);
    }
        
    // 添加 DOM 元素
    $(this).parent().append('<div class="mag"></div>');
    var orig_url = $(this).parent().attr("href");
    $(this).next(".mag").css({"width":"150px","height":"150px","position":"absolute","border-radius":"100%"});
    $(this).next(".mag").css("box-shadow","0 0 0 7px rgba(255,255,255,.85),0 0 7px 7px rgba(0,0,0,.25),inset 0 0 40px 2px rgba(0,0,0,.25)");
    $(this).next(".mag").css("background","url("+ orig_url +") no-repeat");
    $(this).next(".mag").css("display","none");
    // 处理父元素的 a，不然高度不够
    $(this).parent().css("height",$(this).height()).css("display","block").css("position","relative");
    // 初始位置，详情见 http://blog.huidesign.com/wp-content/images/explaination.jpg
    var init_top = $(this).offset().top - $(this).parent().offset().top - $(this).next(".mag").height()/2;
    var init_left = $(this).offset().left - $(this).parent().offset().left - $(this).next(".mag").width()/2;
    $(this).next(".mag").css({"top":init_top,"left":init_left});

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
       height_rate = 0.652; */
        
    
    $(this).parent().mousemove(function(e){

        var compare_left = e.pageX - $(this).offset().left;
        var compare_top = e.pageY - $(this).offset().top;

        var position_left = e.pageX - $(this).parent().offset().left - $(this).next(".mag").width()/2;
        var position_top = e.pageY - $(this).parent().offset().top - $(this).next(".mag").height()/2;
      
        var bg_left = compare_left * width_rate;
        var bg_top = compare_top * height_rate;
  
        // 25 for better edge
        var imgW = $(this).width() + 25;
        var imgH = $(this).height() + 25;
      
        // notice $(this) has changed to .entry-content a element.
        if (compare_left > 0 & compare_left < imgW & compare_top > 0 & compare_top < imgH) {
            $(this).children(".mag").fadeIn().css({"left":position_left,"top":position_top,"background-position":"-" + bg_left + "px -" + bg_top + "px"});
        };
        if (compare_left < 0 || compare_left > imgW || compare_top <0 || compare_top > imgH) {
            $(this).children(".mag").fadeOut(100);
        };
    });
    }); 

}); // End DOM Ready