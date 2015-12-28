/*
* popStatus	提示
* status	1正确，2提示，3加载，4失败
* html	提示信息
* bremove	是否使用遮照,不为空时使用
*/
$.extend({
	popstatus:function(status,html,bremove){
		var windowWidth,
			windowHeight,
			popstatus,//请求超时时间			
			timeous,//超时时间
			whWindow,//浏览器宽高的获取
			popStatuRe,//位置矫正	
			wsremove,
			shake,
			outTime;
		//浏览器宽高的获取		
		whWindow = function(){
			windowWidth = $(window).width();
			windowHeight = $(window).height();
		}
		//调整位置
		popStatuRe	=	function() {
			$('body #wstatus').css({'left':(windowWidth/2)-($('#wstatus').width()+18)/2+'px','top':(windowHeight/2)-($('#wstatus').height()+18)/2+'px'});
		}
		//清除
		wsremove =	function(){
			$("body #bremove").remove();
			$("body #wstatus").remove();
		}

		shake = function(o){
		    var $panel = $(o);
		    var box_left = $panel.position().left;	   
		    for(var i=1; 4>=i; i++){
		        $panel.animate({left:box_left-4},50);
		        $panel.animate({left:box_left+4},50);
		    }
		    $panel.css({left:box_left});
		}

		//浏览器宽高的获取
		whWindow();
		//根据参数创建DOM
		switch(status){
			case 1:
				$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s1"></div><span class="wstatus_f">'+html+'</span></div>');
			break;
			case 2:
				$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s2"></div><span class="wstatus_f">'+html+'</span></div>');			break;
			case 3:
				$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s3"></div><span class="wstatus_f">'+html+'</span></div>');
			break;
			default:
				$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s4"></div><span class="wstatus_f">'+html+'</span></div>');
			
		}		
		//调整位置
		popStatuRe();
		//抖动
		if (status == 2 || status ==4) {
			shake('body #wstatus');			
		}		
		
		//是否使用遮照
		if (bremove) {
			$('body').append('<div id="bremove" />');
			$("body #bremove").bind('click', function(event) {
				wsremove();
			});
		}else{
			$('body #wstatus').bind('click',  function(event) {
				wsremove();
			});
		}	
		
		
		

	}
});