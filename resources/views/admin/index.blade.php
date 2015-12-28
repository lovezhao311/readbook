<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{ trans('common.common_title') }} - {{ trans('common.cms') }}</title>
<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_style.css" />
<script src="/static/admin/js/jquery-1.4.4.min.js"></script>
</head>
<body>

<div class="top">
  <div class="top_about"> 
    <a href="#" class="help1" id="btn2">{{ trans('common.use_help') }}</a>
    <a href="#" class="help2">{{ trans('common.about') }}</a>
  </div>
  <div class="admin_logo">
    <img src="/static/admin/images/admin_logo.jpg">
  </div>
  <div class="top_nav">
      <ul>      
        @foreach($navigations as $key=>$navigation)
        @if($key == 0)
        <li><a target="left" href="{{ url('admin/common/left/') }}?id={{ $navigation->id }}" class="selected">{{ $navigation->name }}</a></li>
        @else
        <li><a target="left" href="{{ url('admin/common/left/') }}?id={{ $navigation->id }}">{{ $navigation->name }}</a></li>
        @endif
        @endforeach          
      </ul>
  </div>
  <div class="top_member">
  {{ trans('common.welcome') }} Admin | <a href="#">{{ trans('common.account_management') }}</a>  | <a href="#">{{ trans('common.edit') }}</a> | <a href="#">{{ trans('common.n_messages' , array('number'=>3)) }}</a>
  </div>
</div>

<div class="side_switch" id="side_switch">
</div>
<div class="side_switchl" id="side_switchl">
</div>

<div class="left" id="left">
  <div class="member_info">
    <div class="member_ico">
      <img src="/static/admin/images/a.png" width="43" height="43">
    </div>
    <a class="system_a" href="">{{ trans('common.system_setting') }}</a>
    <a href="" class="system_log">{{ trans('common.admin_lock') }}</a>
    <a href="{{ url('admin/common/login/logout') }}" class="system_logout">{{ trans('common.logout') }}</a>
  </div>
  <iframe name="left" id="left" src="{{ url('admin/common/left') }}" frameborder="false" scrolling="no" style="border:none; margin-bottom:10px;"  width="100%" height="100%" ></iframe>
</div>

<div class="right" id="right">
  <iframe name="main" id="main" src="{{ url('admin/index/main') }}" frameborder="false" scrolling="auto" style="border:none; margin-bottom:10px;"  width="100%" height="auto" ></iframe>
</div>

<script type="text/javascript">
  //高度自适应
  initLayout();
  $(window).resize(function()
  {
    initLayout();
  });

  function initLayout()
  {
    var h1 = document.documentElement.clientHeight - $(".top").outerHeight(true);
    var h2 = h1 - $(".headbar").height() - $(".pages_bar").height() - 30;
    $('.left').height(h1);
    $('.right').height(h2);
    $('#main').height(h2);
  }

  //
  $("#side_switch").click(function(){
    $("#left").hide();
    $("#right").css('margin-left',0);
    $(this).hide();
    $("#side_switchl").show();
  });
  $("#side_switchl").click(function(){
    $("#left").show();
    $("#right").css('margin-left',200);
    $(this).hide();
    $("#side_switch").show();
  });
  $(".top_nav a").bind('click',  function(event) {
    $(".top_nav a").removeClass('selected');
    $(this).addClass('selected');
  });
</script>
</body>
</html>