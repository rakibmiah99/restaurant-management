@php
  $mode = $attributes->get('mode') ?? 'horizontal'; //vertical,horizontal
  $title = $attributes->get('title');
  $value = $attributes->get('value') ?? 1;
@endphp

<div class="mb-3 {{$mode == 'horizontal' ? 'row' : ''}}">
    <label for="html5-datetime-local-input" class="{{$mode == 'horizontal' ? 'col-md-2' : ''}} col-form-label">{{$title}}</label>
    <div class="{{$mode == 'horizontal' ? 'col-md-10' : ''}}">
        <div class="col-md">
            <div class="form-check form-check-inline mt-1">
                <input  @if($value == 1) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">{{__('page.active')}}</label>
            </div>
            <div class="form-check form-check-inline">
                <input @if($value == 0) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
                <label class="form-check-label" for="inlineRadio2">{{__('page.inactive')}}</label>
            </div>
        </div>
    </div>
</div>
