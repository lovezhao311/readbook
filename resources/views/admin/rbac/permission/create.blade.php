@extends('admin.main')

@section('content')
	{{-- expr --}}

<div class="content_box">
	<div class="content form_content">
		@if(isset($permissionRow) && isset($permissionRow['id']))
		<form method="post" action="{{ route('admin.rbac.permission.update' , ['id'=>$permissionRow['id']]) }}" rel="preloader">
		@else
		<form method="post" action="{{ route('admin.rbac.permission.store') }}" rel="preloader">
		@endif
			<table class="form_table" cellpadding="0" cellspacing="0" id="tab-1">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>					
				<tr>
					<th>{{ trans('rbac.permission_display_name') }}</th>
					<td>
						@if(isset($permissionRow) && isset($permissionRow['display_name']))
						<input type="text" name="display_name" value="{{ $permissionRow['display_name'] }}" alt="{{ trans('rbac.permission_name') }}({{ trans('common.required') }})" class="small" pattern="required" />
						@else
						<input type="text" name="display_name" value="{{ old('display_name') }}" alt="{{ trans('rbac.permission_display_name') }}({{ trans('common.required') }})" class="small" pattern="required" />
						@endif
						<label>*{{ trans('rbac.permission_display_name') }}({{ trans('common.required') }})</label>
					</td>
				</tr>
				<tr>
					<th>{{ trans('common.belong_to') }}{{ trans('rbac.permission') }}</th>
					<td>
						<select name="pid" class="middle" >
							<option value='0'> {{ trans('common.belong_to') }}{{ trans('common.superior') }} </option>
							@foreach ($permissionRows as $element)
							@if (isset($permissionRow['pid']) && $permissionRow['pid'] == $element['id'])
								<option value="{{$element['id']}}" selected="selected"> {{$element['display_name']}} </option>
							@else
								<option value="{{$element['id']}}"> {{$element['display_name']}} </option>
							@endif								
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<th>{{ trans('rbac.permission_name') }}</th>
					<td>
						@if(isset($permissionRow) && isset($permissionRow['name']))
						<input type="text" name="name" value="{{ $permissionRow['name'] }}" alt="{{ trans('rbac.permission_name') }}({{ trans('common.required') }})" class="middle" pattern="required" />
						@else
						<input type="text" name="name" value="{{ old('name') }}" alt="{{ trans('rbac.permission_name') }}({{ trans('common.required') }})" class="middle" pattern="required" />
						@endif
						<label>*{{ trans('rbac.permission_name') }}({{ trans('common.required') }})</label>
					</td>
				</tr>
				
				<tr>
					<th>{{ trans('common.description') }}</th>
					<td>
						@if(isset($permissionRow) && isset($permissionRow['description']))
						<textarea name="description" class="normal">{{ $permissionRow['description'] }}</textarea>
						@else
						<textarea name="description" class="normal">{{ old('description') }}</textarea>
						@endif
					</td>
				</tr>									
			</table>

			<table class="form_table" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>
				<tr>
					<td>
					 	<input type="hidden" name="_token"  value="{{ csrf_token() }}"/> 
					 	@if(isset($permissionRow) && isset($permissionRow['id']))
					 	<input name="_method" type="hidden" value="PUT">
					 	@endif
					</td>
					<td>
						<button class="submit" type="submit"><span>{{ trans('common.submit') }}</span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@stop