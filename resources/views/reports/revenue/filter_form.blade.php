<form action="{{$_SERVER['PHP_SELF']}}" class="row px-2">
    <div class="col-md-2">
        <x-input
            mode="vertical"
            :title="__('page.from_date')"
            :is_required="false"
            name="from_date"
            type="date"
            :value="request()->get('from_date')"
        />
    </div>
    <div class="col-md-2">
        <x-input
            mode="vertical"
            :title="__('page.to_date')"
            :is_required="false"
            name="to_date"
            type="date"
            :value="request()->get('to_date')"

        />
    </div>

    <div class="col-md-2">
        <x-input-select2
            mode="vertical"
            :title="__('page.hotel')"
            :is_required="false"
            :array="$hotels"
            name="hotel"
            :key="1"
            :value="request()->get('hotel')"
        />
    </div>

    <div class="col-md-2">
        <x-input-select2
            mode="vertical"
            :title="__('page.company')"
            :is_required="false"
            :array="$companies"
            name="company"
            :key="4"
            :value="request()->get('company')"
        />
    </div>



    <div class="col-md-2">
        <x-service-type
            mode="vertical"
            :required="false"
            :value="request()->get('service_type')"
        />
    </div>
    <div class="col-md-2">
        <label style="font-size: 10px; visibility: hidden" class="col-form-label"> f</label>
        <button type="submit" class="btn btn-primary w-100">{{__('page.filter')}}</button>
    </div>

    @foreach(request()->except(['from_date', 'to_date', 'hotel', 'hall', 'company', 'country', 'service_type']) as $input_name=>$value)
        @if(is_array($value))
            @foreach($value as $item)
                <input type="hidden" name="{{$input_name}}[]" value="{{$item}}"/>
            @endforeach
        @else
            <input type="hidden" name="{{$input_name}}" value="{{$value}}"/>
        @endif

    @endforeach
</form>
