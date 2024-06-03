@php
    $mode = $attributes->get('mode') ?? 'horizontal'; //vertical,horizontal
    $name = $attributes->get('name');
    $array = $attributes->get('array');
    $column = $attributes->get('column') ?? 'id';
    $display_column = $attributes->get('column') ?? 'name';
    $is_required = $attributes->get('is_required');
    $title = $attributes->get('title');
    $value = $attributes->get('value');
    $input_size = "";
    $label_size = "";
    if ($mode == "horizontal"){
        $input_size = $attributes->get('input-size') ?? 'col-md-10';
        $label_size = $attributes->get('label-size') ?? 'col-md-2';
    }
    //if you want with a code input need following
    $with_code = $attributes->get('with_code');
    $code = $attributes->get('code');

    //if you need multiple with code input box
    $key = $attributes->get('key') ?? 0;
@endphp


@if(!$with_code)

    <div class="mb-3 {{$mode == "horizontal" ? 'row' : ''}}">
        <label for="{{$name}}" class="{{$label_size}} col-form-label">
            {{$title}}
            @if($is_required)
                <x-required/>
                <x-input-error name="{{$name}}"/>
            @endif

        </label>
        <div class="{{$input_size}}">
            <select @if($is_required) required @endif name="{{$name}}" class="form-select select-2" id="{{$name}}">
                <option value="">{{__('page.select')}}</option>
                @foreach($array as $item)
                    <option @if(old('country_id' == $item->$column)) selected @endif value="{{$item->$column}}">{{$item->$display_column}}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($value)
        <script>
            $('#{{$name}}').val('{{$value}}')
        </script>
    @endif
@endif



@if($with_code)
    <div class="mb-3 {{$mode == "horizontal" ? 'row' : ''}}">
        <label for="{{$name}}" class="{{$mode == "horizontal" ? 'col-md-2' : ''}} col-form-label">
            {{$title}}
            @if($is_required)
                <x-required/>
                <x-input-error name="{{$name}}"/>
            @endif
        </label>
@if($mode == "vertical") <div class="d-flex "> @endif
            <div class="{{$mode == "horizontal" ? 'col-md-2' : 'w-25'}} pe-1">
                <input class="form-control" type="text" name="{{$name}}-code"  value="{{$code ?? old($name."-code")}}" id="{{$name}}-code">
            </div>
            <div class="{{$mode == "horizontal" ? 'col-md-8' : 'w-75'}}  ps-0">
                <select @if($is_required) required @endif  name="{{$name}}" class="form-select select-2" id="{{$name}}">
                    <option value="">{{__('page.select')}}</option>
                    @foreach($array as $item)
                        <option code="{{$item->code}}" value="{{$item->$column}}">{{$item->$display_column}}</option>
                    @endforeach
                </select>
            </div>
@if($mode == "vertical") </div> @endif
    </div>


    <script>
        let selectedEl{{$key}} = $("#{{$name}}");
        selectedEl{{$key}}.on('change', function (){
            let code = $("#{{$name}} :selected").attr('code')
            $('#{{$name}}-code').val(code)
        })

        let keypressTimeout{{$key}} = null;
        $('#{{$name}}-code').on('keyup', function (){
            clearTimeout(keypressTimeout{{$key}})
            $("#{{$name}} option[value='']").prop('selected', true);
            let code = $(this).val();

            selectedEl{{$key}}.val("")
            $("#{{$name}} option").each(function () {
                let selected = $(this).attr('code');
                let selected_val = $(this).val();
                if (selected == code) {
                    selectedEl{{$key}}.val(selected_val);
                }
            });

            keypressTimeout{{$key}} = setTimeout(function (){
                selectedEl{{$key}}.change();
            }, 500)

        })

        @if($value)
            $('#{{$name}}').val({{$value}})
            $('#{{$name}}-code').val('{{$code}}')
        @endif
    </script>
@endif


