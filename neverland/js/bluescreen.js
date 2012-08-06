$(document).ready(function(){
    	  var num_high = 100, num_low = 0;
	  var adjustedhigh = num_high - num_low + 1;
	  var num_random = Math.floor(Math.random()*adjustedhigh) + num_low;
	  num_random = 9;
	  if (num_random < 10) {
		 $(".content").append('<div class="bluescreen"></div>');
		 $(".bluescreen").css({"width":$(window).width(),"height":$(window).height()});
		 $(".bluescreen").css({"position":"fixed","background-color":"#0068c6","z-index":"100"});
		 $(".bluescreen").css({"top":"0","left":"0","padding":"50px 100px"});
		 $(".bluescreen").append('<h1 style="font-size:25pt;color:#c09;">Random is the prettiest skyline of life~~</h1>');
		 $(".bluescreen").append("<p>Oops! Luck panic!!!</p>");
		 $(".bluescreen").append("<p>Whatever I've blued your browser.</p>");
		 $(".bluescreen").append("<p>But here's my message: insufficient roll point！</p>");
		 $(".bluescreen").append("<p>Your roll is "+ num_random +" point.</p>");
		 $(".bluescreen").append("<p><del>I feel I have some '智商上的优越感' over you.</del></p>");
		 $(".bluescreen").append("<p>So reload this page to power on maybe.</p>");
		 $(".bluescreen p").css({"font-size":"22pt","color":"white"});
	  }
}); 
