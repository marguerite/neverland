$(document).ready(function() {
    $(".comment-body p a").each(function() {
      // test image
      if ($(this).attr('href').indexOf('.png') > -1 || $(this).attr('href').indexOf('.jpg') > -1 || $(this).attr('href').indexOf('.gif') > -1) {
	$(this).css({"border":"none","background":"none","margin":"0"});
	var media_img_src = $(this).attr('href');
	$(this).after('<img src=\"'+media_img_src+'"/>');
	$(this).next('img').css({"max-width":"100%","height":"auto"});
	$(this).next('img').css({"background-color":"#FAFAFA","border":"1px solid #BCBCBC"});
	$(this).next('img').css("box-shadow","0 1px 4px rgba(0,0,0,.2)");
	$(this).next('img').css("padding","10px 10px 25px");
	$(this).remove();
      }
      // test youtube
        if ($(this).attr('href').indexOf('youtube.com/watch?v=') > -1 ) {
	$(this).css({"border":"none","background":"none","margin":"0"});
	var media_youtube_url = $(this).attr('href');
	var media_youtube_id = media_youtube_url.substring(media_youtube_url.indexOf("?v=") +3);
	var media_youtube_ratio = 560/315;
	$(this).after('<iframe width=\"'+$(this).parent().width()+'\" height=\"'+$(this).parent().width()/media_youtube_ratio+'\" src=\"http://www.youtube.com/embed/'+media_youtube_id+'\" frameborder=\"0\" allowfullscreen></iframe>');
	$(this).remove();
      }
      // test youku
      if ($(this).attr('href').indexOf('v.youku.com/v_show/id_') > -1 ) {
	$(this).css({"border":"none","background":"none","margin":"0"});
	var media_youku_url = $(this).attr('href');
	var media_youku_id_mid = media_youku_url.substring(media_youku_url.indexOf("id_") +3);
	var media_youku_id = media_youku_id_mid.substring(0,media_youku_id_mid.length - 5);
	var media_youku_ratio = 480/400;
	$(this).after('<embed src=\"http://player.youku.com/player.php/sid/'+media_youku_id+'/v.swf\" allowFullScreen=\"true\" quality=\"high\" width=\"'+$(this).parent().width()+'\" height=\"'+$(this).parent().width()/media_youku_ratio+'\" align=\"middle\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\"></embed>');
	$(this).remove();
      }
      //http://v.youku.com/v_show/id_XMzQyNDIwMjA4.html
      //<embed src="http://player.youku.com/player.php/sid/XMzQyNDIwMjA4/v.swf" allowFullScreen="true" quality="high" width="480" height="400" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
    });
});
