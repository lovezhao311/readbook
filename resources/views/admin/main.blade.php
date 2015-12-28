<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ trans('common.common_title') }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_style.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_right.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/style/public.css" />
	<script src="/static/admin/js/jquery.min.js"></script>
	<script src="/static/admin/js/artTemplate/artTemplate.js" type="text/javascript"></script>
	<script src="/static/admin/js/artTemplate/artTemplate-plugin.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/static/admin/js/artdialog/skins/idialog.css" type="text/css" />
	<script src="/static/admin/js/jquery.idTabs.min.js" type="text/javascript"></script>	
	<script src="/static/admin/js/artdialog/artDialog.js?skin=idialog" type="text/javascript"></script>
	<script src="/static/admin/js/artdialog/plugins/iframeTools.js" type="text/javascript"></script>
	<script src="/static/admin/js/validate.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="/static/admin/js/validate/style.css">	
	<script src="/static/admin/js/jquery.stonecms.js" type="text/javascript"></script>
	<script src="/static/admin/js/jquery.checkbox.js" type="text/javascript"></script>
	<script src="/static/admin/js/function.js" type="text/javascript"></script>
	<script type="text/javascript" src="/static/admin/js/jquery.popstatus.js"></script>
	<script type="text/javascript" src="/static/admin/js/jquery.preloader.js"></script>
	<script type="text/javascript" src="/static/admin/js/jquery.custom-select.js"></script>
	<script src="/static/admin/js/main.js"></script>
</head>
<body>
	<div id="preloader"> 
	 <div id="status">
	  <i class="iconfont icon-load"></i>
	 </div> 
	</div>
	<div class="right_body">
		<div class="top_subnav">{{ trans('common.common_title') }} ＞ {{ $userIndex }}</div>
		@if (isset($errors))
			<div class="alt-error">
				@foreach ($errors as $element)
					@foreach ($element as $el)
						<span>{{$el}}</span>
					@endforeach
				@endforeach
			</div>
		@endif		
		@yield('content')
	</div>
</body>
</html>