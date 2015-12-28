/*
* preloader-web未加载中
* 参数 options close/open
* 参数 time 消失时间
*/
$.extend({
	preloader:{
		count : 0,
		item : 0,
		setCount : function(count){
			this.item = 0;
			this.count = count;		
		},
		setItem : function(){
			this.item += 1;
			if(this.item >= this.count){
				this.init('close');
				return 1;
			}else{
				return this.item / this.count;
			}
		},
		init : function(options){
			switch(options){
				case 'close':
					$('#preloader').hide();
					$('#preloader').animate({
						opacity:0
					},200,'swing' , function(){
						$('#preloader').hide();
					});
				break;
				case 'open':
				default:
					$('#preloader #status').show();
					$('#preloader').show();
					$('#preloader').animate({
						opacity:1
					},200);
			}
		}
	}
});
