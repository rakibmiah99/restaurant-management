@php
    $service_type = $attributes->get('value') ?? old('service_type');
    $required = $attributes->get('required') ?? false;
@endphp

<div class="">
    <label for="html5-url-input" class=" col-form-label">
        {{__('page.service_type')}}
        <x-required/>
        <x-input-error name="service_type" />
    </label>
    <div class="">
        <select @if($required) required @endif  name="service_type" id="service_type" class="form-select">
            <option value="">{{__('page.select')}}</option>
            @foreach(\App\ServiceType::toArray() as $type)
                <option
                    @if($service_type == $type) selected @endif value="{{$type}}"
                >{{$type}}</option>
            @endforeach
        </select>
    </div>
</div>
