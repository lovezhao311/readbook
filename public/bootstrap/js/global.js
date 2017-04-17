$._messengerDefaults = {
    extraClasses: 'messenger-fixed messenger-on-top messenger-on-right',
    'theme': "air"
}


$.extend({
    buttonObject: false,
    formLuffyZhaoErrorMessages: [],
    /**
     * 错误信息提示
     * @author luffy<luffyzhao@vip.126.com>
     * @dateTime 2016-05-06T17:43:43+0800
     * @param    {[type]}                 info [description]
     * @return   {[type]}                      [description]
     */
    messageError: function(info) {
        return this.globalMessenger().post({
            message: info,
            type: 'error'
        });
    },
    /**
     * 成功信息提示
     * @author luffy<luffyzhao@vip.126.com>
     * @dateTime 2016-05-06T17:43:57+0800
     * @param    {[type]}                 info [description]
     * @return   {[type]}                      [description]
     */
    messageSuccess: function(info) {
        this.globalMessenger().post({
            message: info,
            type: 'success'
        });
    },

    /**
     * 提交按钮禁用
     * @return {[type]} [description]
     */
    buttonDisabled: function() {
        this.buttonObject.attr('disabled', 'disabled');
        if(this.buttonObject.find('.icon-spinner').length == 0){
            this.buttonObject.html('<i class="icon-spinner icon-spin"></i>'+this.buttonObject.html());
        }else{
            this.buttonObject.find('.icon-spinner').show();
        }
    },

    /**
     * 提交铵钮启用
     * @return {[type]} [description]
     */
    buttonEnable: function() {
        if (this.buttonObject != false) {
            this.buttonObject.find('.icon-spinner').hide();
            this.buttonObject.removeAttr('disabled');
        }
    },
    /**
     * ajax请求成功数据处理
     * @author luffy<luffyzhao@vip.126.com>
     * @dateTime 2016-05-06T17:19:26+0800
     * @param    {[type]}                 result [description]
     * @return   {[type]}                        [description]
     */
    ajaxDoneResult: function(result) {
        if (result.code == 1) {
            if (typeof result.url == 'undefined') {
                result.url = '/admin/index/index';
            }

            if (typeof result.data == 'undefined') {
                result.data = '成功！';
            }

            $.messageSuccess(result.msg);

            setTimeout(function() {
                    location.href = result.url;
                },
                1000 * result.wait);


        } else if (result.code == 2) {
            if (typeof result.url == 'undefined') {
                result.url = '/admin/index/index';
            }
            $.messageSuccess('权限发生改变！');
            setTimeout(function() {
                    location.href = result.url;
                },
                1000);
        } else if (result.code == 3) {
            $.messageSuccess(result.msg);
        } else if (result.code == 4) {
            $.messageError(result.msg);
        } else {
            if (typeof result.msg == 'string') {
                $.formLuffyZhaoErrorMessages.push($.messageError(result.msg));
            } else {
                for (i in result.msg) {
                    $.formLuffyZhaoErrorMessages.push($.messageError(result.msg[i]));
                }
            }
        }

        $.buttonEnable();
    },
    /**
     * ajax请求失败数据处理
     * @param  {[type]} result [description]
     * @return {[type]}        [description]
     */
    ajaxFailResult: function(result) {
        $.messageError('网络错误,请联系管理员');
        $.buttonEnable();
    },

});


$.fn.extend({
    /**
     * ajax提交
     * @return {[type]} [description]
     */
    formLuffyZhao: function(fields, is_ajax) {
        var me = $(this);
        if (typeof(is_ajax) == 'undefined') {
            is_ajax = true;
        }

        $(this).submit(function(event) {
            for (var i = $.formLuffyZhaoErrorMessages.length - 1; i >= 0; i--) {
                $.formLuffyZhaoErrorMessages[i].hide();
            }
            $.formLuffyZhaoErrorMessages = [];

            $.buttonObject = $(this).find('button[type="submit"]');
            if(typeof(window.editor) != 'undefined'){
                window.editor.sync();
            }
            var action = $(this).attr('action'),
                method = $(this).attr('method'),
                data = $(this).serialize();

            // 按钮禁用
            $.buttonDisabled();

            if (typeof method == 'undefined' || method.length == 0) {
                method = 'get';
            }

            if (typeof action == 'undefined' || action.length == 0) {
                $.formLuffyZhaoErrorMessages.push($.messageError('内部错误！'));
                // 启用按钮
                $.buttonEnable();
            } else {
                var validator = new FormValidator(me.attr('name'), fields, function(errors) {
                    if (errors.length > 0) {
                        for (variable in errors) {
                            for (var i = 0; i < errors[variable].messages.length; i++) {
                                $.formLuffyZhaoErrorMessages.push($.messageError(errors[variable].messages[i]));
                            }
                            // $.messageError(errors[variable].message);
                        }
                    }
                });
                // 表单验证
                if (validator.errors.length !== 0) {
                    $.buttonEnable();
                    return false;
                }
                // event.preventDefault();
                if (is_ajax == true) {
                    event.preventDefault();
                    $.ajax({
                            url: action,
                            type: method,
                            dataType: 'json',
                            data: data,
                        })
                        .done($.ajaxDoneResult)
                        .fail($.ajaxFailResult);
                }
                // ajax提交                
            }
        });
    }
});
