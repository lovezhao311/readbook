$(document).ready(function() {


    $('.delete').bind('click', function(event) {
        event.preventDefault();
        var $this = $(this);
        bootbox.confirm({
            size: 'small',
            message: "确认删除这条数据吗?",
            callback: function(result) {
                if (result == true) {
                    $.ajax({
                            url: $this.attr('href'),
                            type: 'post',
                            dataType: 'json',
                        })
                        .done($.ajaxDoneResult)
                        .fail($.ajaxFailResult);
                }
            }
        });
    });

    $('.ajax-get').bind('click', function(event) {
        event.preventDefault();
        $.buttonObject = $(this);
        $.buttonDisabled();
        var $this = $(this);
        bootbox.confirm({
            size: 'small',
            message: ($this.data('msg') !== 'undefined') ? $this.data('msg') : "准备好了吗？",
            callback: function(result) {
                if (result == true) {
                    $.ajax({
                            url: $this.attr('href'),
                            type: 'get',
                            dataType: 'json',
                        })
                        .done($.ajaxDoneResult)
                        .fail($.ajaxFailResult);
                }
            }
        });

    });

    $('.ajax-get-all').bind('click', function(argument) {
        event.preventDefault();
        var $this = $(this);
        $('.table .check:checked').each(function(index, el) {
            $.buttonObject = $this;
            $.buttonDisabled();
            var value = $(this).val(),
                name = $(this).attr('name');
            $.ajax({
                    url: $this.attr('href'),
                    data: name + '='+ value,
                    type: 'get',
                    dataType: 'json',
                })
                .done($.ajaxDoneResult)
                .fail($.ajaxFailResult);
        });
    });

    $('.check-all').on('ifChecked', function(argument) {
        $(this).parents('table').find('.check').iCheck('check');
    });

    $('.check-all').on('ifUnchecked', function(argument) {
        $(this).parents('table').find('.check').iCheck('uncheck');
    });


    if (typeof $.fn.iCheck !== 'undefined') {
        $('input').iCheck({
            checkboxClass: 'icheckbox_minimal-green',
            radioClass: 'iradio_minimal-green',
            increaseArea: '20%' // optional
        });
    }

    // 日期
    if (typeof $.fn.datetimepicker !== 'undefined') {
        $('input.date').datetimepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            autoclose: true,
            minView: 'month',
        });
    }

    if (typeof $.fn.luffyuploadpic !== 'undefined') {
        $("img.upload").luffyuploadpic();
    }
});
