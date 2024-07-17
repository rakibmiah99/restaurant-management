<div class="row">
@foreach($permissions as $groupName => $actions)
    <div class="col-md-3 mb-4">
        <label class="d-block mb-1 group-name" for="{{$groupName}}">
            <b>{{__('permission.'.$groupName)}}</b>
        </label>

        <div class="group-items">
            @foreach($actions as $permission)
                <label class="d-block" for="{{$permission->name}}">
                    @if(isset($role_has_permissions) && in_array($permission->id, $role_has_permissions))
                        <i style="color: #219C90" class="bi bi-check2-circle"></i>
                    @else
                        <i class="bi text-danger bi-x-circle"></i>
                    @endif
                    <span>{{__('permission.'.$permission->name)}}</span>
                </label>
            @endforeach
        </div>
    </div>
@endforeach
</div>
