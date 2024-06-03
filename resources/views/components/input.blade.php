@php
    $mode = $attributes->get('mode') ?? 'horizontal'; //vertical,horizontal
    $name = $attributes->get('name');
    $title = $attributes->get('title');
    $value = $attributes->get('value');
    $type = $attributes->get('type') ?? "text";
    $input_size = "";
    $label_size = "";
    if ($mode == "horizontal"){
        $input_size = $attributes->get('input-size') ?? 'col-md-10';
        $label_size = $attributes->get('label-size') ?? 'col-md-2';
    }

    $required = $attributes->get('required') ?? false;
    $readonly = $attributes->get('readonly') ?? false;
    $disabled = $attributes->get('disabled') ?? false;

@endphp
<div class="mb-3 {{$mode == 'horizontal' ? 'row' : '' }}" >
    <label for="{{$name}}" class="{{ $label_size  }} col-form-label">
        {{$title}}

        @if($required)
            <x-required/>
            <x-input-error name="{{$name}}"/>
        @endif
    </label>
    <div class="{{$input_size}} ">
        <input
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
            class="form-control" name="{{$name}}"
            type="{{$type}}"
            value="{{$value}}"
            id="{{$name}}">
    </div>
</div>
