/*
* preloader-web未加载中
* 参数 options close/open
* 参数 time 消失时间
*/
$.fn.extend({
	preloader:function(options,time){
		this.each(function() {
			$this 	=	$(this);
			if(typeof time == 'undefined' || time < 100)
					time = 1000;
			switch(options){

				case 'close':
					$this.find("#status").hide();
					$this.animate({
						opacity:0
					},time,'swing' , function(){
						$(this).hide();
					});
				break;
				case 'open':
				default:
					$this.find("#status").show();
					$this.show();
					$this.animate({
						opacity:1
					},time);
			}
		});
	}
});