<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{ trans('auth.login') }}-{{ trans('common.version') }}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/static/admin/style/public.css'>
<link rel='stylesheet' type='text/css' href='/static/admin/style/admin_login.css'>
</head>
<body>
<div id="preloader"> 
 <div id="status">
  <i class="iconfont icon-load"></i>
 </div> 
</div>
<div class="main">
  <div class="title"></div>
  <div class="login">
    <form action="{{ url('/admin/common/login/') }}" method="post" name="cms" rel="loginsubmit">
      <div class="inputbox">
        <dl>
          <dd>{{ trans('auth.user_name') }}:</dd>
          <dd>
            <input type="text" name="name" id="login_name" size="13" />
          </dd>
          <dd>{{ trans('auth.password') }}</dd>
          <dd>
            <input type="password" name="password" id="login_pwd" size="13" />
          </dd>
          <dd>{{ trans('auth.verify') }}</dd>
          <dd style="width: 50px;">
            <input type="text" name="verify" size="3" class="verifyinput" />            
          </dd>
          <dd><img src="{{ url('/admin/common/captcha/default') }}" id="verifyimg" /></dd>          
        </dl>       
      </div>
      <div class="butbox">
        <dl>
          <dd><input name="submit" type="submit" value="" class="input" /></dd>
          <dd>
            <input type="hidden" name="_token"  value="{{ csrf_token() }}"/>
          </dd>
          <dd>{{ trans('common.brief_description') }}</dd>
        </dl>
      </div>
      <div style="clear:both"></div>
    </form>
  </div>
</div>
<div class="copyright"> 
  Powered by <a href="" target="_blank">{{ trans('common.version') }}</a>&nbsp;Copyright&nbsp;&copy;2011-2012 
</div>
<script type="text/javascript" src="/static/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/js/jquery.preloader.js"></script>
<script type="text/javascript" src="/static/admin/js/jquery.submit.js"></script>
<script type="text/javascript" src="/static/admin/js/jquery.popstatus.js"></script>
<script type="text/javascript" src="/static/admin/js/main.js"></script>  
<script type="text/javascript">
function ajaxSuccess(json , xhrstatus , exception)
{
  if(xhrstatus == 'success'){
    if(!json || json.type == 'warning'){
      $.popstatus(4, json.message,true);
    }else{
      $("#preloader").preloader('open');
      var link = ((typeof json.href == 'undefined') || (json.href == '')) ? "/admin/" : json.href;
      location.href = link;
    }
  }else{
    var errorMessage = '';
    for (var Things in json.responseJSON) {
      for (var i in json.responseJSON[Things]){
        errorMessage += json.responseJSON[Things][i];
      }
    };
    $.popstatus(4, errorMessage,true);
    $('#verifyimg').trigger('click');
  }
}



$("[rel='loginsubmit']").ajaxsubmit({
  success:ajaxSuccess
});

$("#verifyimg").on('click', function(event) {
  event.preventDefault();
  $(this).attr('src',$(this).attr('src')+'?');
});
</script>
</body>
</html>