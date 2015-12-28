@extends('admin.main')


@section('content')
<div class="operating">
	<div class="search f_r">		
	</div>
	<a href="{{route('admin.rbac.navigation.create')}}">
		<button type="button" class="operating_btn">
			<span class="addition">{{ trans('common.add') }}{{ trans('rbac.navigation') }}</span>
		</button>
	</a>		
</div>

<div class="field">
	<table class="list_table">
		<colgroup>
			<col>
			<col>	
			<col width="180px">
			<col width="180px">
		</colgroup>

		<thead>
			<tr class="">
				<th>{{ trans('rbac.navigation_name') }}</th>
				<th>{{ trans('common.url') }}</th>
				<th>{{ trans('common.sort') }}</th>				
				<th>{{ trans('common.operate') }}</th>
			</tr>
		</thead>
	</table>
</div>

<div class="content" style="height: 326px;">	
	
		<table class="list_table">
			<colgroup>
				<col>
				<col>			
				<col width="180px">
				<col width="180px">
			</colgroup>
			<tbody>	
			@foreach ($navigationRows as $element)			
				<tr  data-id="{{$element['id']}}" data-parent="{{$element['pid']}}">					
					<td>
						<img class="operator" src="/static/admin/images/close.gif"  alt="关闭">						
						{{$element['name']}}
					</td>
					<td>{{$element['url']}}</td>			
					<td><input type="text" class="tiny" name="sort[{{ $element['id'] }}]" value="{{$element['sort']}}"/></td>
					<td>
						<a title="{{ trans('common.delete') }}{{ trans('rbac.navigation') }}" href="javascript:void(0);" data-msg="{{ trans('common.confirm_delete',['name'=>trans('rbac.navigation')]) }}" data-href="{{ route('admin.rbac.navigation.destroy' , ['id'=>$element['id']]) }}">
						<img alt="{{ trans('common.delete') }}" src="/static/admin/images/icon_del.gif" class="operator">
						</a>		
						<a title="{{ trans('common.edit') }}{{ trans('rbas.navigation') }}" href="{{ route('admin.rbac.navigation.edit' , ['id'=>$element['id']]) }}">
							<img alt="{{ trans('common.edit') }}" src="/static/admin/images/icon_edit.gif" class="operator">
						</a>
					</td>
				</tr>
			@if(!empty($element->children))
			@foreach ($element->children as $value)
				<tr  data-id="{{$value['id']}}" data-parent="{{$value['pid']}}">					
					<td>
						<img class="operator" style="margin-left:30px" src="/static/admin/images/close.gif"  alt="关闭">						
						{{$value['name']}}
					</td>
					<td>{{$value['url']}}</td>			
					<td><input type="text" class="tiny" name="sort[{{ $value['id'] }}]" value="{{$value['sort']}}"/></td>
					<td>
						<a title="{{ trans('common.delete') }}{{ trans('rbac.navigation') }}" href="javascript:void(0);" data-msg="{{ trans('common.confirm_delete',['name'=>trans('rbac.navigation')]) }}" data-href="{{ route('admin.rbac.navigation.destroy' , ['id'=>$value['id']]) }}">
						<img alt="{{ trans('common.delete') }}" src="/static/admin/images/icon_del.gif" class="operator">
						</a>		
						<a title="{{ trans('common.edit') }}{{ trans('rbas.navigation') }}" href="{{ route('admin.rbac.navigation.edit' , ['id'=>$value['id']]) }}">
							<img alt="{{ trans('common.edit') }}" src="/static/admin/images/icon_edit.gif" class="operator">
						</a>
					</td>
				</tr>

			@if(!empty($value->children))
			@foreach ($value->children as $vo)
				<tr  data-id="{{$vo['id']}}" data-parent="{{$vo['pid']}}">					
					<td>
						<img class="operator" style="margin-left:60px" src="/static/admin/images/close.gif"  alt="关闭">						
						{{$vo['name']}}
					</td>
					<td>{{$vo['url']}}</td>			
					<td><input type="text" class="tiny" name="sort[{{ $vo['id'] }}]" value="{{$vo['sort']}}"/></td>
					<td>
						<a title="{{ trans('common.delete') }}{{ trans('rbac.navigation') }}" href="javascript:void(0);" data-msg="{{ trans('common.confirm_delete',['name'=>trans('rbac.navigation')]) }}" data-href="{{ route('admin.rbac.navigation.destroy' , ['id'=>$vo['id']]) }}">
						<img alt="{{ trans('common.delete') }}" src="/static/admin/images/icon_del.gif" class="operator">
						</a>		
						<a title="{{ trans('common.edit') }}{{ trans('rbas.navigation') }}" href="{{ route('admin.rbac.navigation.edit' , ['id'=>$vo['id']]) }}">
							<img alt="{{ trans('common.edit') }}" src="/static/admin/images/icon_edit.gif" class="operator">
						</a>
					</td>
				</tr>
				
			@endforeach
			@endif

			@endforeach
			@endif

			@endforeach
			</tbody>

		</table>
	
</div>


<script type="text/javascript">
	$('.list_table .operator').bind('click',function(){
		var src = ['/static/admin/images/close.gif' , '/static/admin/images/open.gif'];
		var operatorTR = $(this).parent().parent();
		var pid = operatorTR.data('id');

		if($(this).attr('src') == src[0]){
			$(this).attr('src',src[1]);
			$("[data-parent='"+pid+"'] td:first-child img").trigger('click');
			$("[data-parent='"+pid+"']").hide();
		}else{
			$(this).attr('src',src[0]);
			$("[data-parent='"+pid+"'] td:first-child img").trigger('click');
			$("[data-parent='"+pid+"']").show();
		}
		
	});
</script>


@endsection