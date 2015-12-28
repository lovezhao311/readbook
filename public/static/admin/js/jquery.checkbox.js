;
(function($) {
	$.fn.checkboxClass = function() {
		var checked = function(obj) {
			if (obj.is(':checked')) {
				obj.attr('checked', true);
				var pid = obj.data('pid');
				if (typeof pid == 'undefined') {
					return true;
				}
				var thisObj = $("[type='checkbox'][data-id='" + pid + "']");
				thisObj.prop('checked', true);
				checked(thisObj);
			} else {
				obj.attr('checked', false);
				var id = obj.data('id');
				if (typeof id == 'undefined') {
					return false;
				}
				var thisObj = $("[type='checkbox'][data-pid='" + id + "']");
				thisObj.prop('checked', false);
				checked(thisObj);
			}
		}
		$(this).click(function() {
			var obj = $(this);
			checked(obj);
		});
	}
})(jQuery)