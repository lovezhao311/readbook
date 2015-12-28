// contents of main.js:
require.config({
    baseUrl: "./vendor/modules",
    paths: {
        jquery: '../jquery/jquery.min',
        'jquery.preloader' : '../jquery/preloader/jquery.preloader'
    },
    shim : {
       'jquery.preloader' : ['jquery'],
       'lib/preloader' : ['jquery.preloader']
    }
});

require(['jquery'] , function(){
    $.get('/admin/post/index' , function(status){
        if(status == 0){
            require(['login/index'] , function(login){
                var html = login();
                $('body').html(html);
                $('title').html('登陆');
            });
        }else{       
            
        }
    });
});

require(['lib/preloader'], function( preloader ){ 
    var html = preloader();
    $('body').append(html);
    $.preloader.setCount(2);
});
