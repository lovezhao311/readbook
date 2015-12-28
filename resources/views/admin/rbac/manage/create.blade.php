@extends('admin.main')

@section('content')

<div class="content_box">
	<div class="content form_content">
		@if (isset($manageRow))
		<form method="post" action="{{ route('admin.rbac.manage.update',['id'=>$manageRow->id]) }}" rel="preloader">
		@else
		<form method="post" action="{{ route('admin.rbac.manage.store') }}" rel="preloader">
		@endif

			<table class="form_table" cellpadding="0" cellspacing="0" id="tab-1">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>
				<tr>
					<th>{{ trans('rbac.manage_name') }}</th>
					<td>
						@if(isset($manageRow) && isset($manageRow))
						<input type="text" name="name" value="{{ $manageRow->name }}" alt="{{ trans('rbac.manage_name') }}({{ trans('common.required') }})" pattern="required" class="normal"   />
						@else
						<input type="text" name="name" value="{{ old('name') }}" alt="{{ trans('rbac.manage_name') }}({{ trans('common.required') }})" pattern="required" class="normal"   />
						@endif
						<label>*{{ trans('rbac.manage_name') }}({{ trans('common.required') }})</label>
					</td>
				</tr>
				<tr>
					<th>{{ trans('common.email') }}</th>
					<td>
						@if(isset($manageRow) && isset($manageRow))
						<input type="text" name="email" value="{{ $manageRow->email }}" alt="{{ trans('rbac.email') }}({{ trans('common.required') }})" pattern="required" class="normal"   />
						@else
						<input type="text" name="email" value="{{ old('email') }}" alt="{{ trans('rbac.email') }}({{ trans('common.required') }})" pattern="required" class="normal"   />
						@endif
						<label>*{{ trans('common.email') }}({{ trans('common.required') }})</label>
					</td>
				</tr>
				<tr>
					<th>{{ trans('auth.password') }}</th>
					<td>
					@if (isset($manageRow))
						<input type="password" name="password" value="" class="normal"   />
						<label>*{{ trans('auth.password_update_tip') }}</label>
					@else
						<input type="password" name="password" value="" alt="{{ trans('rbac.password') }}({{ trans('common.required') }})" pattern="required" class="normal"   />
						<label>*{{ trans('auth.password') }}({{ trans('common.required') }})</label>
					@endif

					</td>
				</tr>
				<tr>
					<th>{{ trans('common.confirm') }}{{ trans('auth.password') }}</th>
					<td>
					@if (isset($manageRow))
						<input type="password" name="password_confirmation" value="" class="normal"   />
					@else
						<input type="password" name="password_confirmation" value="" alt="{{ trans('common.confirm') }}{{ trans('rbac.password') }}({{ trans('common.required') }})" pattern="required" class="normal"   />
						<label>*{{ trans('common.confirm') }}{{ trans('auth.password') }}({{ trans('common.required') }})</label>
					@endif

					</td>
				</tr>

				<tr>
					<th>{{ trans('common.belong_to') }}{{ trans('rbac.role') }}</th>
					<td>
					@foreach ($roleRows as $element)
						<label class="attr">
						@if (isset($roleCheckeds) && in_array($element->id , $roleCheckeds))
							<input type="checkbox" name="roles[]" checked="checked" value="{{ $element->id }}">
						@else
							<input type="checkbox" name="roles[]" value="{{ $element->id }}">
						@endif
							{{ $element->display_name }}
						</label>
					@endforeach
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
					 	@if(isset($manageRow) && !empty($manageRow))
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
