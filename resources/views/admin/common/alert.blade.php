<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>跳转</title>
	<script src="/static/admin/js/jquery.min.js"></script>
</head>
<style type="text/css">
	*{margin: 0;padding: 0;}
	body{font-size: 12px;}
	div{margin-top: 200px; text-align: center;}
	p{color: #666;padding:5px 0;}
	h1{padding: 10px 0;}
</style>
<body>
	<div>
		@if(isset($type) && $type == 'warning')
		<h1>:-(</h1>
		@else
		<h1>:-)</h1>
		@endif
		@if (!empty($message) && is_array($message))
		@foreach ($message as $element)
			<p>{{$element}}</p>
		@endforeach
		@elseif(!empty($message) && is_string($message))
		<p>{{$message}}</p>
		@endif
		@if (isset($hrefs))		
		<p>			
			@foreach ($hrefs as $element)
			[<a href="{{$element['url']}}">{{$element['name']}}</a>]&nbsp;&nbsp;
			@endforeach
		</p>
		@endif
		<p>
			<strong id="time">5</strong>
			{{ trans('common.seconds_jump') }}
			@if (isset($location))	
			[<a href="{{$location['url']}}" id="autoLocation">{{$location['name']}}</a>]
			@else	
			[<a href="javascript:history.back();"  id="autoLocation">{{ trans('page.previous') }}</a>]
			@endif
		</p>
	</div>
</body>
<script type="text/javascript">
	var interval = false;
	interval = setInterval(function(){
		// document.getElementById()
		var time = parseInt(document.getElementById('time').innerHTML);
		time = time - 1;		
		if(time == 0){
			setTimeout(interval);
			location.href=$('#autoLocation').attr('href');
		}
		document.getElementById('time').innerHTML = time;
	},1000);
	// setInterval()
</script>
</html>