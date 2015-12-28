@extends('admin.main')

@section('content')

<div class="content_box">
	<div class="content form_content">	
		@if (isset($navigationRow))
		<form method="post" action="{{ route('admin.rbac.navigation.update',['id'=>$navigationRow->id]) }}" rel="preloader">
		@else
		<form method="post" action="{{ route('admin.rbac.navigation.store') }}" rel="preloader">
		@endif
		
			<table class="form_table" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>				
				<tr>
					<th>{{ trans('rbac.navigation_name') }}</th>
					<td>
						@if(isset($navigationRow) && isset($navigationRow))
						<input type="text" name="name" value="{{ $navigationRow->name }}" alt="{{ trans('rbac.navigation_name') }}({{ trans('common.required') }})" pattern="required" class="middle"   />
						@else
						<input type="text" name="name" value="{{ old('name') }}" alt="{{ trans('rbac.navigation_name') }}({{ trans('common.required') }})" pattern="required" class="middle"   />
						@endif
						<label>*{{ trans('rbac.navigation_name') }}({{ trans('common.required') }})</label>
					</td>
				</tr>

				<tr>
					<th>{{ trans('common.belong_to') }}{{ trans('rbac.navigation') }} </th>
					<td>
						<select name="pid" class="normal" >
							<option value='0' data-modifier="mod"> {{ trans('common.belong_to') }}{{ trans('common.superior') }} </option>	
							@foreach ($navigationRows as $element)
							@if(isset($navigationRow) && $element->id == $navigationRow->pid)
							<option value="{{ $element->id }}" selected='selected'>|--{{ $element->name }}</option>
							@else
								<option value="{{ $element->id }}">|--{{ $element->name }}</option>
							@endif
							@if($element->children)
								@foreach ($element->children as $el)
								@if(isset($navigationRow) && $el->id == $navigationRow->pid)
									<option value="{{ $el->id }}" selected='selected'>&nbsp;&nbsp;&nbsp;&nbsp;|----{{ $el->name }}</option>
								@else
									<option value="{{ $el->id }}">&nbsp;&nbsp;&nbsp;&nbsp;|----{{ $el->name }}</option>
								@endif
								@endforeach
							@endif
							@endforeach
						</select>
					</td>
				</tr>

				<tr>
					<th>{{ trans('common.url') }}</th>
					<td>
						@if(isset($navigationRow) && isset($navigationRow))
						<input type="text" name="url" value="{{ $navigationRow->url }}" alt="{{ trans('common.url') }}({{ trans('common.required') }})" pattern="required" class="middle"   />
						@else
						<input type="text" name="url" value="{{ old('url') }}" alt="{{ trans('common.url') }}({{ trans('common.required') }})" pattern="required" class="middle"   />
						@endif
						<label>*{{ trans('common.url') }}({{ trans('common.required') }})</label>
					</td>
				</tr>

				<tr>
					<th>{{ trans('common.sort') }}</th>
					<td>
						<input type="text" class="tiny" name="sort" value="0">						
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
					 	@if(isset($navigationRow) && !empty($navigationRow))
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