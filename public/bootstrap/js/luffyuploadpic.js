if (typeof jQuery === 'undefined') {
  throw new Error('luffyUpload\'s JavaScript requires jQuery')
}

+function ($) {
  'use strict';
  var version = $.fn.jquery.split(' ')[0].split('.')
  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1)) {
    throw new Error('luffyUpload\'s JavaScript requires jQuery version 1.9.1 or higher')
  }
}(jQuery);

+function ($) {
  'use strict';

  var luffyUploadPic = function (element) {
        var that = this;

        that.element = $(element);

        that.element.bind('click', function(event) {
          var id = $(this).attr('id');

          if(typeof(id) == 'undefined'){
              console.error('参数不正确！');
              return false;
          }
          jQuery.ajax({
              type: 'get',
              url:'/admin/Upload/index/id/'+id,
              success: function(data) {
                  bootbox.dialog({
                      className: 'modal-dialog-luffy',
                      message: data,
                      title: "文件上传"
                  });
              }
          });
      });

  };

  $.fn.luffyuploadpic = function () {
    new luffyUploadPic(this);
  };

}(jQuery);

