@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp

<x-input-select2
    :title="__('page.hotel_name')"
    :is_required="true"
    :array="$hotels"
    name="hotel_id"
    :value="$is_edit ? $hall->hotel_id : old('hotel_id')"
/>


<x-input
    :title="__('page.hall_name')"
    name="name"
    :required="true"
    :value="$is_edit ? $hall->name:  old('name')"
/>

<x-input
    :title="__('page.hall_code')"
    name="code"
    :required="true"
    :readonly="true"
    :value="$is_edit ? $hall->code :\App\Models\Hotel::GenerateUniqueCode()"
/>

<x-input
    :title="__('page.capacity')"
    name="capacity"
    type="number"
    :required="true"
    :value="$is_edit ? $hall->capacity : old('capacity')"
/>
<x-input
    :title="__('page.breakfast_start_time')"
    name="b_start"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->b_start)) : old('b_start')"
/>
<x-input
    :title="__('page.breakfast_end_time')"
    name="b_end"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->b_end)) : old('b_end')"
/>
<x-input
    :title="__('page.lunch_start_time')"
    name="l_start"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->l_start)) : old('l_start')"
/>
<x-input
    :title="__('page.lunch_end_time')"
    name="l_end"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->l_end)) : old('l_end')"
/>

<x-input
    :title="__('page.dinner_start_time')"
    name="d_start"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->d_start)) : old('d_start')"
/>
<x-input
    :title="__('page.dinner_end_time')"
    name="d_end"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->d_end)) : old('d_end')"
/>
<x-input
    :title="__('page.seheri_start_time')"
    name="s_start"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->s_start)) : old('s_start')"
/>
<x-input
    :title="__('page.seheri_end_time')"
    name="s_end"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->s_end)) : old('s_end')"
/>
<x-input
    :title="__('page.iftar_start_time')"
    name="i_start"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->i_start)) : old('i_start')"
/>
<x-input
    :title="__('page.iftar_start_time')"
    name="i_end"
    type="time"
    :required="true"
    :value="$is_edit ? date('H:i', strtotime($hall->i_end)) : old('i_end')"
/>
<x-input-status :value="$is_edit ? $hall->status : old('status')" :title="__('page.hall_status')"/>
