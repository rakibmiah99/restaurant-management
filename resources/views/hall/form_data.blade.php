@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp

<div class="mb-3 row">
    <label class="col-md-2 col-form-label">
        {{__('hotel_name')}}
        <x-required/>
        <x-input-error name="name"/>
    </label>
    <div class="col-md-10">
        <input required value="{{$is_edit ? $hotel->name:  old('name')}}" name="name" class="form-control" type="text">
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-text-input" class="col-md-2 col-form-label">
        {{__('page.hotel_code')}}
        <x-required/>
        <x-input-error name="code"/>
    </label>
    <div class="col-md-10">
        <input readonly required value="{{$is_edit ? $hotel->code :\App\Models\Hotel::GenerateUniqueCode()}}" name="code" class="form-control" type="text" id="html5-text-input">
    </div>
</div>

<div class="mb-3 row">
    <label for="html5-url-input" class="col-md-2 col-form-label">
        {{__('page.phone')}}
        <x-required/>
        <x-input-error name="phone"/>
    </label>
    <div class="col-md-10">
        <input required class="form-control" name="phone" type="tel"  value="{{$is_edit ? $hotel->email : old('phone')}}" id="html5-url-input">
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-url-input" class="col-md-2 col-form-label">{{__('page.email')}}</label>
    <div class="col-md-10">
        <input class="form-control" name="email"  value="{{$is_edit ? $hotel->email :  old('email')}}" type="email">
    </div>
</div>
<div class="mb-3 row">
    <label for="html5-tel-input" class="col-md-2 col-form-label">{{__('page.address')}}</label>
    <div class="col-md-10">
        <input class="form-control"  type="text" name="address"  value="{{$is_edit ? $hotel->address : old('address')}}">
    </div>
</div>

<div class="mb-3 row">
    <label for="html5-datetime-local-input" class="col-md-2 col-form-label">{{__('page.hotel_status')}}</label>
    <div class="col-md-10">
        <div class="col-md">
            <div class="form-check form-check-inline mt-1">
                <input  @if($is_edit ? $hotel->status : old('status') ) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">{{__('page.active')}}</label>
            </div>
            <div class="form-check form-check-inline">
                <input @if($is_edit ? !$hotel->status : !old('status')) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
                <label class="form-check-label" for="inlineRadio2">{{__('page.inactive')}}</label>
            </div>
        </div>
    </div>
</div>
