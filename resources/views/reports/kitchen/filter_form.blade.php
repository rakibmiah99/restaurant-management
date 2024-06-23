<form action="{{$_SERVER['PHP_SELF']}}" class="row px-2">
    <div class="col-md-2">
        <x-input
            mode="vertical"
            :title="__('page.from_meal_date')"
            :is_required="false"
            name="from_meal_date"
            type="date"
            :value="request()->get('from_meal_date')"
        />
    </div>
    <div class="col-md-2">
        <x-input
            mode="vertical"
            :title="__('page.to_meal_date')"
            :is_required="false"
            name="to_meal_date"
            type="date"
            :value="request()->get('to_meal_date')"
        />
    </div>


    <div class="col-md-3">
        <x-input-select2
            mode="vertical"
            :title="__('page.cuisine_name')"
            :is_required="false"
            :array="$countries"
            name="country"
            :key="3"
            :value="request()->get('country')"
        />
    </div>
    <div class="col-md-3">
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

    @foreach(request()->except(['from_meal_date', 'to_meal_date', 'country', 'service_type']) as $input_name=>$value)
        @if(is_array($value))
            @foreach($value as $item)
                <input type="hidden" name="{{$input_name}}[]" value="{{$item}}"/>
            @endforeach
        @else
            <input type="hidden" name="{{$input_name}}" value="{{$value}}"/>
        @endif

    @endforeach
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
