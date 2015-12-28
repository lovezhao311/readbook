@extends('admin.main')


@section('content')
<div class="operating">
	<div class="search f_r">		
	</div>
	<a href="{{route('admin.rbac.permission.create')}}">
		<button type="button" class="operating_btn">
			<span class="addition">{{ trans('common.add') }}{{ trans('rbac.permission') }}</span>
		</button>
	</a>		
</div>

<div class="field">
	<table class="list_table">
		<colgroup>
			<col>
			<col>
			<col>
			<col width="180px">
			<col width="180px">
			<col width="180px">
		</colgroup>

		<thead>
			<tr class="">
				<th>{{ trans('rbac.permission_name') }}</th>
				<th>{{ trans('rbac.permission_display_name') }}</th>
				<th>{{ trans('common.description') }}</th>
				<th>{{ trans('common.created_at') }}</th>
				<th>{{ trans('common.updated_at') }}</th>				
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
				<col>
				<col width="180px">
				<col width="180px">
				<col width="180px">
			</colgroup>
			<tbody>	
			@foreach ($permissionRows as $element)			
				<tr  data-id="{{$element['id']}}" data-parent="{{$element['pid']}}">					
					<td>
						<img class="operator" src="/static/admin/images/close.gif"  alt="关闭">						
						{{$element['name']}}
					</td>
					<td>{{$element['display_name']}}</td>
					<td>{{$element['description']}}</td>
					<td>{{$element['created_at']}}</td>
					<td>{{$element['updated_at']}}</td>
					<td>
						<a title="{{ trans('common.delete') }}{{ trans('rbac.permission') }}" href="javascript:void(0);" data-msg="{{ trans('common.confirm_delete',['name'=>trans('rbac.permission')]) }}" data-href="{{ route('admin.rbac.permission.destroy' , ['id'=>$element['id']]) }}">
						<img alt="{{ trans('common.delete') }}" src="/static/admin/images/icon_del.gif" class="operator">
						</a>		
						<a title="{{ trans('common.edit') }}{{ trans('rbas.permission') }}" href="{{ route('admin.rbac.permission.edit' , ['id'=>$element['id']]) }}">
							<img alt="{{ trans('common.edit') }}" src="/static/admin/images/icon_edit.gif" class="operator">
						</a>
					</td>
				</tr>
				@if(isset($element['children']))
					@foreach ($element['children'] as $el)					
					<tr data-id="{{$el['id']}}" data-parent="{{$el['pid']}}">						
						<td>							
							<img class="operator"  style="margin-left:30px" src="/static/admin/images/close.gif"  alt="关闭">							
							{{$el['name']}}
						</td>
						<td>{{$el['display_name']}}</td>
						<td>{{$el['description']}}</td>
						<td>{{$el['created_at']}}</td>
						<td>{{$el['updated_at']}}</td>
						<td>
							<a title="{{ trans('common.delete') }}{{ trans('rbac.permission') }}" href="javascript:void(0);" data-msg="{{ trans('common.confirm_delete',['name'=>trans('rbac.permission')]) }}" data-href="{{ route('admin.rbac.permission.destroy' , ['id'=>$el['id']]) }}">
							<img alt="{{ trans('common.delete') }}" src="/static/admin/images/icon_del.gif" class="operator">
							</a>		
							<a title="{{ trans('common.edit') }}{{ trans('rbas.permission') }}" href="{{ route('admin.rbac.permission.edit' , ['id'=>$el['id']]) }}">
								<img alt="{{ trans('common.edit') }}" src="/static/admin/images/icon_edit.gif" class="operator">
							</a>							
						</td>
					</tr>
					@endforeach
				@endif
			@endforeach
			</tbody>

		</table>
	
</div>


<script type="text/javascript">
	$('.list_table .operator').click(function(){
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