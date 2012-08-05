$(document).ready(function() {
  // Global variables: screen size;
  var window_width = $(window).width();
  var window_height = $(window).height();
  
  $(".entry-content img:not(.wp-smiley)").each(function(){
    
      if ($(this).parent("a").length >= 0) {
	  // save href
	  $(this).data("hrefsave",$(this).parent().attr("href"));
	  // replace herf to prevent mis hit
	  $(this).parent().removeAttr("href");
      }
      
      // now we click
      $(this).click(function() {
	
	  // create mask
	  $(".content").append('<div class="mask"></div>');
	  $(".mask").css({"position":"fixed","top":"0","left":"0","display":"block"});
	  $(".mask").css({"width":window_width,"height":window_height});
	  $(".mask").css({"background-color":"rgba(0,0,0,.5)","z-index":"100"});
	  
	  // create frame
	  $(".mask").append('<div class="photoframe"></div>');
	  
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

	  // calculate margin-top
	  var frame_top = (window_height - real_height - 10)/2;
	  var frame_left = (window_width - real_width - 10)/2;
	  // photoframe css;
	  $(".photoframe").css("width",real_width);
	  $(".photoframe").css("margin-top",frame_top).css("margin-left",frame_left);
	  $(".photoframe").css("display","block").css("position","relative");
	  $(".photoframe").css({"background-color":"#FAFAFA","padding":"5px"});
	  
	  // shutdown button
	  $(".photoframe").append('<div class="shutdown_button"></div>');
	  $(".shutdown_button").css({"display":"none","width":"22px","height":"22px"});
	  $(".shutdown_button").css({"position":"absolute","top":"-11px","left":"-11px"});
	  
	  $(".photoframe").hover(function(){
	      $(".shutdown_button").css("display","block");
	  },function(){
	      $(".shutdown_button").css("display","none");
	  }); // end hover
	  
	  $(".shutdown_button").click(function(){
	      $(".mask").remove();
	  });
	  
      }); // end click
  }); // end each
}); // end dom ready
