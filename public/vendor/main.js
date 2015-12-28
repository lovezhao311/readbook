// contents of main.js:
require.config({
    baseUrl: "./vendor/modules",
    paths: {
        jquery: '../jquery/jquery.min',
        'jquery.preloader' : '../jquery/preloader/jquery.preloader'
    },
    shim : {
       'jquery.preloader' : ['jquery'],
       'lib/preloader' : ['jquery.preloader'],
       'lib/topnav'	: ['jquery.preloader']
    }
});

require(['lib/preloader'], function( preloader ){ 
    var html = preloader();
    $('body').append(html);
    $.preloader.setCount(1);
});


require(['lib/topnav'], function( topnav ){
	$.get('/admin/common/nav' , function(json){
		var html = topnav(json);
	    $('#logout').before(html);
	    $.preloader.setItem(1);
	});    
});

