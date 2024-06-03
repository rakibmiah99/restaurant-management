@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp

<x-input
    :title="__('page.hotel_name')"
    name="name"
    type="text"
    :required="true"
    :value="$is_edit ? $hotel->name : old('name')"
/>

<x-input
    :title="__('page.hotel_code')"
    name="code"
    type="text"
    :required="true"
    :readonly="true"
    :value="$is_edit ? $hotel->code :\App\Models\Hotel::GenerateUniqueCode()"
/>

<x-input
    :title="__('page.phone')"
    name="phone"
    type="tel"
    :required="true"
    :value="$is_edit ? $hotel->phone : old('phone')"
/>

<x-input
    :title="__('page.email')"
    name="email"
    type="email"
    :required="false"
    :value="$is_edit ? $hotel->email : old('email')"
/>

<x-input
    :title="__('page.address')"
    name="address"
    type="text"
    :required="false"
    :value="$is_edit ? $hotel->address : old('address')"
/>

<x-input-status
    :value="$is_edit ? $hotel->status : old('status')"
    :title="__('page.hotel_status')"
/>
