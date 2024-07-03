@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp
<div class="row">
    <div class="col-md-6">
        <x-input
            :title="__('page.role_name')"
            mode="vertical"
            name="role_name[en]"
            type="text"
            :required="true"
            :value="isset($role_has_permissions) ? $role->getTranslation('display_name', 'en') : ''"
        />
    </div>
    <div class="col-md-6">
        <x-input
            label-size="4"
            input-size="8"
            mode="vertical"
            :title="__('page.role_name')"
            name="role_name[ar]"
            type="text"
            :required="false"
            :value="isset($role_has_permissions) ? $role->getTranslation('display_name', 'ar') : ''"
        />
    </div>
    @foreach($permissions as $groupName => $actions)
        <div class="col-md-3 mb-4">
            <label class="d-block mb-1 group-name" for="{{$groupName}}">
                <input id="{{$groupName}}" type="checkbox">
                <b>{{__('permission.'.$groupName)}}</b>
            </label>

            <div class="group-items">
                @foreach($actions as $permission)
                    <label class="d-block" for="{{$permission->name}}">
                        <input @if(isset($role_has_permissions) && in_array($permission->id, $role_has_permissions)) checked  @endif name="permission_id[]" value="{{$permission->id}}" id="{{$permission->name}}" type="checkbox">
                        <span>{{__('permission.'.$permission->name)}}</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>


<script>

    let group_name = $('.group-name');
    for(let i = 0; i< group_name.length; i++){
        let group_input = group_name.eq(i).children().first();
        let group_items = group_name.eq(i).next().find('input');
        let status = true;
        for (let j =0; j < group_items.length; j++){
            let check_status = group_items.eq(j).is(':checked')
            if(!check_status){
                status = false;
                break;
            }
        }

        group_input.attr('checked', status)
    }

    group_name.on('click', function(){
        let group_input_checked = $(this).children().first().is(':checked');
        let group_items = $(this).next().find('input');
        for (let i =0; i < group_items.length; i++){
            group_items.eq(i).attr('checked', group_input_checked)
        }
    })
</script>
