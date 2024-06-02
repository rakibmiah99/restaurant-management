@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp
<div class="mb-3 row">
    <label for="html5-text-input" class="col-md-2 col-form-label">
        {{__('page.company_code')}}
        <x-required/>
        <x-input-error name="unique_id"/>
    </label>
    <div class="col-md-10">
        <input readonly required value="{{$is_edit ? $company->code :\App\Models\Company::GenerateUniqueID()}}" name="unique_id" class="form-control" type="text" id="html5-text-input">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-md-2 col-form-label">
        {{__('company_name')}}
        <x-required/>
        <x-input-error name="name"/>
    </label>
    <div class="col-md-10">
        <input required value="{{$is_edit ? $company->name:  old('name')}}" name="name" class="form-control" type="text">
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-email-input" class="col-md-2 col-form-label">{{__('page.country')}} <x-required/></label>
    <div class="col-md-10">
        <select required name="country_id" class="form-select select-2" id="countriesId" aria-label="Default select example">
            <option value="">{{__('page.select')}}</option>
            @foreach($countries as $county)
                <option @if(old('country_id' == $county->id)) selected @endif value="{{$county->id}}">{{$county->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-email-input" class="col-md-2 col-form-label">{{__('page.meal_price')}}</label>
    <div class="col-md-2 pe-1">
        <input class="form-control" type="text" name="meal_price_code"  value="{{old('meal_price_code')}}" id="mealPriceCode">
    </div>
    <div class="col-md-8 ps-0">
        <select  name="meal_price_id" class="form-select select-2" id="mealPriceId" aria-label="Default select example">
            <option value="">{{__('page.select')}}</option>
            @foreach($meal_prices as $meal_price)
                <option @if(old('meal_price_id' == $meal_price->id)) selected @endif code="{{$meal_price->code}}" value="{{$meal_price->id}}">{{$meal_price->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-url-input" class="col-md-2 col-form-label">{{__('page.company_email')}}</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="email"  value="{{$is_edit ? $company->email : old('email')}}" id="html5-url-input">
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-url-input" class="col-md-2 col-form-label">{{__('page.company_phone')}}</label>
    <div class="col-md-10">
        <input class="form-control" name="phone"  value="{{$is_edit ? $company->phone :  old('phone')}}" type="tel">
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-tel-input" class="col-md-2 col-form-label">{{__('page.company_address')}}</label>
    <div class="col-md-10">
        <input class="form-control"  type="text" name="address"  value="{{$is_edit ? $company->address : old('address')}}">
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-password-input" class="col-md-2 col-form-label">{{__('page.company_agent')}}</label>
    <div class="col-md-10">
        <input class="form-control" name="agent_name"  value="{{$is_edit ? $company->agent_name :old('agent_name')}}" type="text" >
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-number-input" class="col-md-2 col-form-label">{{__('page.agent_mobile')}}</label>
    <div class="col-md-10">
        <input class="form-control" type="tel" name="agent_mobile"  value="{{$is_edit ? $company->agent_mobile : old('agent_mobile')}}">
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-datetime-local-input" class="col-md-2 col-form-label">{{__('page.company_status')}}</label>
    <div class="col-md-10">
        <div class="col-md">
            <div class="form-check form-check-inline mt-1">
                <input  @if($is_edit ? $company->status : old('status') ) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">{{__('page.active')}}</label>
            </div>
            <div class="form-check form-check-inline">
                <input @if($is_edit ? !$company->status : !old('status')) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
                <label class="form-check-label" for="inlineRadio2">{{__('page.inactive')}}</label>
            </div>
        </div>
    </div>
</div>
