@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp

<x-input
    :title="__('page.company_code')"
    name="code"
    type="text"
    :required="true"
    :readonly="true"
    :value="$is_edit ? $company->code :\App\Models\Company::GenerateUniqueID()"
/>

<x-input
    :title="__('page.company_name')"
    name="name"
    type="text"
    :required="true"
    :value="$is_edit ? $company->name : old('name')"
/>


<x-input-select2
    :title="__('page.country')"
    :is_required="true"
    :array="$countries"
    name="country_id"
    :value="$is_edit ? $company->country_id : ''"
/>



<x-input-select2
    :title="__('page.meal_price')"
    :is_required="true"
    :array="$meal_prices"
    name="meal_price_id"
    :with_code="true"
    :value="$is_edit ? $company->meal_price?->id : false"
    :code="$is_edit ? $company->meal_price?->code : false"
/>


<x-input
    :title="__('page.company_email')"
    name="email"
    type="email"
    :required="false"
    :value="$is_edit ? $company->email : old('email')"
/>

<x-input
    :title="__('page.company_phone')"
    name="phone"
    type="tel"
    :required="false"
    :value="$is_edit ? $company->phone :  old('phone')"
/>

<x-input
    :title="__('page.company_address')"
    name="address"
    type="text"
    :required="false"
    :value="$is_edit ? $company->address : old('address')"
/>
<x-input
    :title="__('page.company_agent')"
    name="agent_name"
    type="text"
    :required="false"
    :value="$is_edit ? $company->agent_name :old('agent_name')"
/>
<x-input
    :title="__('page.agent_mobile')"
    name="agent_mobile"
    type="tel"
    :required="false"
    :value="$is_edit ? $company->agent_mobile : old('agent_mobile')"
/>

<x-input-status
    :value="$is_edit ? $company->status : old('status')"
    :title="__('page.company_status')"
/>

