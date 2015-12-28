
$(function(){		

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	//load隐藏
	$("#preloader").preloader('close');
	//table切换
	if(typeof $.fn.idTabs != 'undefined'){
		$(".headbar ul.tab").idTabs(); 
	}
	//checkboxClass
	if(typeof $.fn.checkboxClass != 'undefined'){
		$(".jquerycheckbox[type='checkbox']").checkboxClass();
	}

	if(typeof $.fn.CustomSelect != 'undefined'){
		$('select').CustomSelect({visRows:10});	
	}
	

	//隔行换色
	$(".list_table tr:nth-child(even)").addClass('even');
	$(".list_table tr").hover(
		function () {
			$(this).addClass("sel");
		},
		function () {
			$(this).removeClass("sel");
		}
	);

	//checkbox全选
	$(".all_checkbox").click(function(){	
		$(".item_checkbox").each(function(){
			$(this).attr("checked" , true);	
		});			
	});

	

	$('[rel="preloader"]').bind('submit',function(){
		var invalid = true;
		for(var i = 0; i < this.elements.length; i++)
        {
        	var e = this.elements[i];
        	if((e.type == "text" || e.type == "password" || e.type == "select-one" || e.type == "textarea") && e.getAttribute("pattern") && e.style.display!='none' && e.offsetWidth > 0)
            {
            	if (e.className.indexOf(" invalid-text")==-1)
				{
					invalid = false;
				}
            }
        }
			
        if(invalid){
        	$("#preloader").preloader('open');
        }
		// console.log(this.elements);	
	});


	

	//
	$('.M').hover(
	    function(){
	      $(this).addClass('active');
	    },
	    function(){
	      $(this).removeClass('active');
	    }
    );	

	$("input").bind('blur', function(event) {
	  event.preventDefault();
	  $(this).css({borderColor:'#dcdcdc'});
	});
	$("input").bind('focus', function(event) {
	  event.preventDefault();
	  $(this).css({borderColor:'#fc9938'});
	});

	$("[data-href]").bind('click',function(){
		var href = $(this).data('href');
		var msg = $(this).data('msg');
		var confirm = art.dialog.confirm(msg, function(){
    		$.ajax({
	            url: href, type:'DELETE',
	            success: function (json) {
	            	confirm.close();
	            	var message = art.dialog({
					    title: 'loading'
					});
	                if(json.type == 'success'){
	                    location.reload();
	                }else{
	                	message.content(json.message);            	
	                }
	                               
	            }
	        });
	        return false;
		}, function(){
		    return true;
		});
        
	});

})

function change(id, choose)
{
  document.getElementById(id).value = choose.options[choose.selectedIndex].title;
}
