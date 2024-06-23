<form action="{{$_SERVER['PHP_SELF']}}" class="row px-2">
    <div class="col-md-3">
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
    <div class="col-md-3">
        <x-input-select2
            mode="vertical"
            :title="__('page.hall')"
            :is_required="false"
            :array="$halls"
            name="hall"
            :key="2"
            :value="request()->get('hall')"
        />
    </div>
    <div class="col-md-3">
        <x-input-select2
            mode="vertical"
            :title="__('page.country')"
            :is_required="false"
            :array="$countries"
            name="country"
            :key="3"
            :value="request()->get('country')"
        />
    </div>
    <div class="col-md-3">
        <x-input-select2
            mode="vertical"
            :title="__('page.meal_system')"
            :is_required="false"
            :array="$meal_systems"
            name="meal_system"
            :key="4"
            :value="request()->get('meal_system')"
        />
    </div>
    <div class="col-md-3">
        <x-input
            mode="vertical"
            :title="__('page.from_date')"
            :is_required="false"
            name="from_date"
            type="date"
            :value="request()->get('from_date')"
        />
    </div>
    <div class="col-md-3">
        <x-input
            mode="vertical"
            :title="__('page.to_date')"
            :is_required="false"
            name="to_date"
            type="date"
            :value="request()->get('to_date')"

        />
    </div>
    @foreach(request()->except(['from_date', 'to_date', 'hotel', 'hall', 'country']) as $input_name=>$value)
        @if(is_array($value))
            @foreach($value as $item)
                <input type="hidden" name="{{$input_name}}[]" value="{{$item}}"/>
            @endforeach
        @else
            <input type="hidden" name="{{$input_name}}" value="{{$value}}"/>
        @endif

    @endforeach
    <div class="col-md-3">
        <label style="font-size: 10px; visibility: hidden" class="col-form-label"> f</label>
        <button type="submit" class="btn btn-primary w-100">{{__('page.filter')}}</button>
    </div>
</form>

<script>
    // datePicker('#from_date')
    $('#hotel').on('change', function (){
        let hotel_id = $(this).val();
        let url = `{{ route('hotel.getHalls', ':hotel_id') }}`.replace(':hotel_id', hotel_id);
        axios.get(url)
            .then(response => {
                $('#hall').html(response.data)
            })
            .catch(error => {

            })
        console.log(url)
    })
</script>
