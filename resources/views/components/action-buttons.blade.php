@php
    $model = $attributes->get('model');
    $permission_for = $attributes->get('permission-for');
    $route_prefix = $attributes->get('route-prefix');
    $edit = $attributes->get('edit');
    $delete = $attributes->get('delete');
    $status = $attributes->get('status');
@endphp

<div class="dropdown-menu" style="">
    <a data-bs-toggle="modal" data-bs-target="#viewModal" class="dropdown-item view-btn" href="javascript:void(0);" url="{{route($route_prefix.'.show', $model->id)}}"><i class='bx bx-low-vision me-1'></i>{{__('page.view')}}</a>
    @if(\App\Helper::HasPermissionMenu($permission_for, 'update') && (!isset($edit) || $edit !== false ))
        <a class="dropdown-item" href="{{route($route_prefix.'.edit', $model->id)}}"><i class="bx bx-edit-alt me-1"></i>{{__('page.edit')}}</a>
    @endif

    @if(\App\Helper::HasPermissionMenu($permission_for, 'change_status') && (!isset($status) || $status !== false ))
        <a class="dropdown-item" href="{{route($route_prefix.'.changeStatus', $model->id)}}"><i class='bx bx-checkbox-minus'></i> {{$model->status ? __('page.inactive') : __('page.active') }}</a>
    @endif

    @if(\App\Helper::HasPermissionMenu($permission_for, 'delete') && (!isset($delete) || $delete !== false ))
        <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route($route_prefix.'.delete', $model->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>{{__('page.delete')}}</a>
    @endif
    {{$slot}}

</div>
