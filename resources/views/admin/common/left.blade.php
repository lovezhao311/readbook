<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ trans('common.cms') }}</title>
  <link rel="stylesheet" type="text/css" href="/static/admin/css/admin_style.css" />
<script src="/static/admin/js/jquery-1.4.4.min.js"></script>
</head>
<body>
<div class="left">  
  @foreach ($navigations as $navigation)
  <div class="left_title"> {{ $navigation->name }} </div>
  <ul class="side left_title_child">
    @forelse ($navigation->children as $element)
      <li><a target="main" href="{{ $element->url }}">{{ $element->name }}</a></li> 
    @empty      
    @endforelse           
  </ul> 
  @endforeach 
  
  <ul class="side catsub">
      <li class="feed"><a href="http://www.uimaker.com">{{ trans('common.subscribe') }}</a></li>
      <li class="side_about"><a href="#">{{ trans('common.copyright_statement') }}</a></li>
  </ul>
</div>
<script type="text/javascript">
  $(".left_title").bind('click', function(event) {
    $('.left_title_child').hide();
    $(this).next().show();
  });  
  $(".left_title_child a").bind('click',function(){
    $(".left_title_child a").removeClass('selected');
    $(this).addClass('selected');
  });

  $(function(){
    $(".left_title_child:first").show();
    // $(".left_title_child a:first").trigger('click');
  });
</script>
</body>
</html>