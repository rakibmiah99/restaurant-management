@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp

<div class="row">
    <div class="col-md-12">
        <x-input
            :title="__('page.name')"
            name="name"
            type="text"
            :required="true"
            :value="$is_edit ? $user->name : old('name')"
        />
    </div>

    <div class="col-md-12">
        <x-input
            :title="__('page.email')"
            name="email"
            type="email"
            :required="true"
            :value="$is_edit ? $user->email : old('email')"
        />
    </div>

    <div class="col-md-12">
        <x-input
            :title="__('page.phone')"
            name="phone"
            type="text"
            :required="false"
            :value="$is_edit ? $user->phone : old('phone')"
        />
    </div>

    <div class="col-md-12">
        <x-input
            :title="__('page.location')"
            name="location"
            type="text"
            :required="false"
            :value="$is_edit ? $user->location : old('location')"
        />
    </div>

    <div class="col-md-12">
        <x-input
            :title="__('page.website')"
            name="website"
            type="text"
            :required="false"
            :value="$is_edit ? $user->website : old('website')"
        />
    </div>

    <div class="col-md-12">
        <x-input
            :title="__('page.password')"
            name="password"
            type="password"
            value=""
            :required="!$is_edit"
        />
    </div>

    <div class="col-md-12">
        <x-input
            :title="__('page.confirm_password')"
            name="confirm_password"
            value=""
            type="password"
            :required="!$is_edit"
        />
    </div>

    <div class="col-md-12">
        <x-input-select2
            :title="__('page.assign_role')"
            name="role_id"
            :is_required="true"
            :array="$roles"
            :value="$is_edit ? $user_role_id : old('role_id')"
            :key="1"
        />
    </div>
</div>
