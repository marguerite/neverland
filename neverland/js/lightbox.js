$(document).ready(function() {
  // Global variables: screen size;
  var window_width = $(window).width();
  var window_height = $(window).height();
  
  $(".entry-content img:not(.wp-smiley)").each(function(){
    
      if ($(this).parent("a").length >= 0) {
	  // save href
	  //$(this).data("hrefsave",$(this).parent().attr("href"));
	  // replace herf to prevent mis hit
	  $(this).parent().removeAttr("href");
      }
      
      $(this).css("cursor","pointer");
      
      // now we click
      $(this).click(function() {
	
	  // create mask
	  $(".content").append('<div class="mask"></div>');
	  $(".mask").css({"position":"fixed","top":"0","left":"0","display":"block"});
	  $(".mask").css({"width":window_width,"height":window_height});
	  $(".mask").css({"background-color":"rgba(0,0,0,.5)","z-index":"100"});
	  
	  // create frame
	  $(".mask").append('<div class="photoframe"></div>');
	  $(".mask").append('<div class="ghost"></div>');
	  
	  // photo resize
	  var real_photo = new Image();
	  real_photo.src = $(this).attr("src");
	  var real_ratio = window_width*0.9/real_photo.width;
	  if ( real_ratio > 1 ) {
	      var real_width = real_photo.width;
	      var real_height = real_photo.height;
	  } else {
	      var real_width = real_photo.width*real_ratio;
	      var real_height = real_photo.height*real_ratio;
	  }
	  $(".photoframe").append('<img width="'+ real_width+'" height="'+real_height+'"'+"src="+ $(this).attr("src") +"/>");
	  
	  // see if we need photo description, better use <a/> title, fallback is img alt
	  // detect <a/> title
	  if( $(this).parent().attr("title") === false || $(this).parent().attr("title") === 'undefined' || $(this).parent().attr("title") === "") {
		var title = false;
	  } else {
		var title = true;
	  }
	  // detect img alt
	  if( $(this).attr("alt") === false || $(this).attr("alt") === "") {
		var alt = false;
	  } else {
		var alt = true;
	  }
	  // if has only one attribute, then use it; if has both, use title; else do nothing.
	  if ( title === true & alt === true) {    
	      $(".photoframe").append('<span class="desc">'+ $(this).parent().attr("title")+"</span>");
	      $(".desc").css("margin","5px auto");
	      var desc_height = $(".desc").height();
	  } else if (title === true & alt === false) {
	      $(".photoframe").append('<span class="desc">'+ $(this).parent().attr("title")+"</span>");
	      $(".desc").css("margin","5px auto");
	      var desc_height = $(".desc").height();
	  } else if (title === false & alt === true) {
	      $(".photoframe").append('<span class="desc">'+ $(this).attr("alt")+"</span>");
	      $(".desc").css("margin","5px auto");
	      var desc_height = $(".desc").height();
	  } else {
	      var desc_height = 0;
	  }
	  
	  
	  // calculate margin-top
	  var frame_top = (window_height - real_height - 10 - desc_height)/2;
	  var frame_left = (window_width - real_width - 10)/2;
	  // photoframe css;
	  $(".photoframe").css("width",real_width);
	  $(".photoframe").css("margin-top",frame_top).css("margin-left",frame_left);
	  $(".photoframe").css("display","block").css("position","relative");
	  $(".photoframe").css({"background-color":"#FAFAFA","padding":"5px"});
	  
	  // shutdown button
	  $(".photoframe").append('<a class="close"></a>');
	  $(".close").css({"display":"none","width":"22px","height":"22px"});
	  $(".close").css({"position":"absolute","top":"-11px","right":"-11px"});
	  $(".close").css({"background-size":"22px 22px"});
	  
	  $(".photoframe").mousemove(function(e){
	      // 不然太烦人了
	      var region_top = (e.pageY - $(window).scrollTop() - frame_top)/real_height;
	      var region_left = (e.pageX - frame_left)/real_width;
	      if ( region_top < 0.2 & region_left > 0.8 ){
		    $(".close").css("display","block");
	      } else {
		    $(".close").css("display","none");
	      }
	  }); // end mousemove
	  
	  $(".close").click(function(){
	      $(".mask").remove();
	  });
	  
	  // eastern egg
	  
	  var num_high = 100, num_low = 0;
	  var adjustedhigh = num_high - num_low + 1;
	  var num_random = Math.floor(Math.random()*adjustedhigh) + num_low;
	  
	  $(".ghost").css({"position":"absolute","top":"10px","left":frame_left});
	  $(".ghost").css({"display":"none","width":"128px","height":"128px"});
	  
	  $(".photoframe img").load(function(){
	     if (num_random < 10) {		    
		    $(".ghost").fadeIn(1000);
		    $(".ghost").animate({left:frame_left + real_width - 128},3000);
		    $(".photoframe img").fadeOut(5000);
		    $(".ghost").animate({top:frame_top + real_height - 128},3000);
		    $(".photoframe img").fadeIn(5000);
		    $(".ghost").animate({left:frame_left},3000);
		    $(".photoframe img").fadeOut(5000);
		    $(".ghost").animate({top:"10px"},3000);
		    $(".photoframe img").fadeIn(5000);
		    $(".ghost").fadeOut(1000);
	     }// end eastern egg
	  });
	  
      }); // end click
  }); // end each
}); // end dom ready
