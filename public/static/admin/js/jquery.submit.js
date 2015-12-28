/*
* ajaxsubmit-from表彰ajax提交
* 
*/
$.fn.extend({
	ajaxsubmit:function(options){		
	// alert($(this).serialize());
		// console.log(this);   		
		this.each(function() {
			$this 	=	$(this);
			var settings = $this.data('ajaxsubmit'); 
			if (typeof settings == 'undefined') {		
				var defaults	=	{
					url:$this.attr('action'),
					method:$this.attr('method'),
					success : function(json){
						if(json.status == 0 || !json){
							$.error(json.error);
						}
					}
				};
				settings = $.extend({}, defaults, options);
				// 保存我们新创建的settings
				$this.data('ajaxsubmit',settings); 
			}else{
				// settings，options合并
                settings = $.extend({}, settings, options); 
                // 保存options
                $this.data("ajaxsubmit", settings);
			}


			$this.bind('submit', function(event) {
				event.preventDefault();
				/* Act on the event */	
				var submitData = $(this).serialize();					
				$.ajax({
					url: settings.url,
					dataType: 'json',
					data: submitData,
					type: settings.method,
					success: settings.success,
					error:settings.success
				});
			});      
		}); 		
	}
});