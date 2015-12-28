(function($){
	/**
	 * @brief 删除操作
	 * @param object conf
		   msg :提示信息;
		   form:要提交的表单名称;
		   link:要跳转的链接地址;
	 */
	$.delModel	=	function(conf , type)
	{		
		var ok		=	null;
		var msg   = '确定要删除么？';//提示信息

		if(type == 'form'){
			ok	=	function(){				
				$(conf).submit();
			}
		}else{
			ok	=	function(){
				window.location.href= conf;
			}
		}		
		art.dialog.confirm(msg,ok);		
	}

})(jQuery);