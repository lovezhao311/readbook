@extends('admin.main')


@section('content')
<div class="operating">
  <div class="search f_r">
    <form method="get" name="searchModForm">
      <input type="text" value="" name="manage_name" placeholder="{{ trans('rbac.manage_name') }}" class="small">
      <button type="submit" class="btn"><span class="sch">{{ trans('common.search') }}</span></button>
    </form>
  </div>

  <a href="{{route('admin.rbac.manage.create')}}">
    <button type="button" class="operating_btn">
      <span class="addition">{{ trans('common.add') }}{{ trans('rbac.manage') }}</span>
    </button>
  </a>
  <a class="all_checkbox" href="javascript:void(0);">
    <button class="operating_btn">
      <span class="sel_all">{{ trans('common.sel_all') }}</span>
    </button>
  </a>
  <a href="javascript:void(0);">
    <button class="operating_btn">
      <span class="delete">{{ trans('common.sel_delete') }}</span>
    </button>
  </a>
</div>

<div class="field">
  <table class="list_table">
    <colgroup>
      <col width="40px">
      <col>
      <col>
      <col>
      <col width="180px">
      <col width="180px">
      <col width="180px">
    </colgroup>

    <thead>
      <tr class="">
        <th>{{ trans('common.choice') }}</th>
        <th>{{ trans('rbac.manage_name') }}</th>
        <th>{{ trans('common.email') }}</th>
        <th>{{ trans('common.belong_to') }}{{ trans('rbac.role') }}</th>
        <th>{{ trans('common.created_at') }}</th>
        <th>{{ trans('common.updated_at') }}</th>
        <th>{{ trans('common.operate') }}</th>
      </tr>
    </thead>
  </table>
</div>

<div class="content" style="height: 326px;">
  <form name="groupFrom" method="post" action="{{ route('admin.rbac.manage.destroy') }}">
    <table class="list_table">
      <colgroup>
        <col width="40px">
        <col>
        <col>
        <col>
        <col width="180px">
        <col width="180px">
        <col width="180px">
      </colgroup>
      <tbody>
        @foreach ($pages as $page)
        <tr class="">
          <td><input type="checkbox" value="{{ $page->id }}" class="item_checkbox" name="id[]"></td>
          <td>{{ $page->name }}</td>
          <td>{{ $page->email }}</td>
          @if($roleRows = $page->roles()->get())
          <td>
            @foreach ($roleRows as $element)
              <abbr title='{{ $element->description }}'>{{ $element->display_name }}</abbr>
            @endforeach
          </td>
          @endif
          <td>{{ $page->created_at }}</td>
          <td>{{ $page->updated_at }}</td>
          <td>
            <a title="{{ trans('common.delete') }}{{ trans('rbac.manage') }}" href="javascript:void(0);" data-msg="{{ trans('common.confirm_delete',['name'=>trans('rbac.manage')]) }}" data-href="{{ route('admin.rbac.manage.destroy' , ['id'=>$page->id]) }}">
              <img alt="{{ trans('common.delete') }}" src="/static/admin/images/icon_del.gif" class="operator">
            </a>
            <a title="{{ trans('common.edit') }}{{ trans('rbas.manage') }}" href="{{ route('admin.rbac.manage.edit' , ['id'=>$page->id]) }}">
              <img alt="{{ trans('common.edit') }}" src="/static/admin/images/icon_edit.gif" class="operator">
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>

    </table>
  </form>
</div>
@include('admin.common.page')
@endsection
