@php $is_edit = isset($is_edit) ? $is_edit : false;@endphp
<div class="row">
    <div class="col-md-4">
        <x-input
            mode="vertical"
            :title="__('page.order_number')"
            name="order_number"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $order->order_number :\App\Models\Order::GenerateOrderNumber()"
        />
    </div>
    <div class="col-md-4">
        <x-input
            mode="vertical"
            :title="__('page.order_date')"
            name="order_date"
            type="date"
            :required="true"
            :readonly="false"
            :min="date('Y-m-d')"
            :value="$is_edit ? $order->order_date : old('order_date') ?? date('Y-m-d')"
        />
    </div>
    <div class="col-md-4">
        <x-service-type :required="true" :value="$is_edit ? $order->service_type : old('service_type')"/>
    </div>
    <div class="col-md-4">
        <x-input-select2
            mode="vertical"
            :title="__('page.company')"
            :is_required="true"
            :array="$companies"
            name="company_id"
            :with_code="true"
            :value="$is_edit ? $order->company_id : old('company_id')"
            :code="$is_edit ? $order->company?->code : false"
            :key="2"
        />
    </div>
    @if(
        request()->get('order-type') == \App\Enums\OrderType::NORMAL->value ||
        request()->get('order-type') == \App\Enums\OrderType::BOTH->value ||
        !request()->get('order-type')
    )
        @if(
            !request()->get(\App\Enums\OrderEditTypeEnum::KEY->value) ||
            request()->get(\App\Enums\OrderEditTypeEnum::KEY->value) == \App\Enums\OrderEditTypeEnum::WITH_MEAL->value
        )
            <div class="col-md-4">
                <x-input-select2
                    mode="vertical"
                    :title="__('page.meal_price_normal')"
                    :is_required="$is_edit ? (boolean) $order->mpi_for_normal : true"
                    :array="$mealPricesNormal"
                    name="mpi_for_normal"
                    :with_code="true"
                    :value="$is_edit ? $order->mpi_for_normal : false"
                    :code="$is_edit ? $order?->meal_price_for_normal?->code : false"
                    :key="3"
                />
            </div>
        @endif
    @endif
    @if(
        request()->get('order-type') == \App\Enums\OrderType::RAMADAN->value ||
        request()->get('order-type') == \App\Enums\OrderType::BOTH->value ||
        !request()->get('order-type')
    )
        @if(
           !request()->get(\App\Enums\OrderEditTypeEnum::KEY->value) ||
           request()->get(\App\Enums\OrderEditTypeEnum::KEY->value) == \App\Enums\OrderEditTypeEnum::WITH_MEAL->value
       )
            <div class="col-md-4">
                <x-input-select2
                    mode="vertical"
                    :title="__('page.meal_price_ramadan')"
                    :is_required="$is_edit ? (boolean)$order->mpi_for_ramadan : true"
                    :array="$mealPricesRamadan"
                    name="mpi_for_ramadan"
                    :with_code="true"
                    :value="$is_edit ? $order->mpi_for_ramadan : old('mpi_for_ramadan')"
                    :code="$is_edit ? $order?->meal_price_for_ramadan?->code : false"
                    :key="4"
                />
            </div>

        @endif
    @endif

    <div class="col-md-4">
        <x-input-select2
            mode="vertical"
            :title="__('page.cuisine_name')"
            :is_required="true"
            :array="$countries"
            name="country_id"
            :value="$is_edit ? $order->country_id : old('country_id')"
        />
    </div>


    <div class="col-md-4">
        <x-input-select2
            mode="vertical"
            :title="__('page.hotel')"
            :is_required="true"
            :array="$hotels"
            name="hotel_id"
            :with_code="true"
            :value="$is_edit ? $order->hotel_id : old('hotel_id')"
            :code="$is_edit ? $order->hotel?->code : false"
            :key="1"
        />
    </div>
    <div class="col-md-4">
        <x-input-select2
            mode="vertical"
            :title="__('page.hall')"
            :is_required="true"
            :array="$is_edit ? $order->hotel->halls : []"
            name="hall_id"
            :value="$is_edit ? $order->hall_id : old('hall_id')"
            input-size="col-md-9"
            label-size="col-md-3"
        />
    </div>

</div>



<x-input
    :title="__('page.order_note')"
    name="order_note"
    :required="false"
    type="text-area"
    :value="$is_edit ? $order->order_note:  old('order_note')"
/>

<x-input-status :value="$is_edit ? $order->status : old('status')" :title="__('page.hotel_status')"/>
@if(
  !request()->get('edit-with') ||
  request()->get('edit-with') == "meal-system"
)

<div class="row">
    <div class="col-md-6 mb-3">
        <x-input-select2
            :title="__('page.meal_system')"
            :is_required="false"
            :array="[]"
            name="meal_system_for_meal_price"
            :value="''"
            input-size="col-md-8"
            label-size="col-md-4"
        />
    </div>
    <div class="col-md-4 mb-3">
        <button  id="add-meal-system" type="button" class="btn btn-primary">
            {{__('page.add')}}
        </button>
    </div>
</div>

<div class="mt-5 mb-5 d-flex justify-content-center">
    <table class="table table-bordered  rounded-5 " style="width: 90%">
        <thead>
        <tr>
            <th>{{__('page.meal_system')}}</th>
            <th>{{__('page.number_of_guest')}}</th>
            <th>{{__('page.from_date')}}</th>
            <th>{{__('page.to_date')}}</th>
            <th>{{__('page.price')}}</th>
            <th>{{__('page.total_days')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="order_meal_price">
        @if($is_edit && !$order->is_modified)
            @foreach($order->meal_systems as $meal_system_info)
                <tr type="{{$meal_system_info->meal_system->type}}">
                    <td style="width: 26%;">
                        {{$meal_system_info->meal_system->name."-".$meal_system_info->meal_system->type}}
                        <input type="hidden" value="{{$meal_system_info->meal_system_for_meal_price_id}}" class="meal_system_price_id" name="meal_system_price_id[]"/>
                    </td>
                    <td style="width: 18%">
                        <input type='number' value="{{$meal_system_info->number_of_guest}}"  required class='form-control' name='guest[]'/>
                    </td>
                    <td style="width: 14%">
                        <input type='date' value="{{$meal_system_info->from_date}}" required class='form-control from-date' name='from_date[]'/>
                    </td>
                    <td style="width: 14%">
                        <input type='date' required value="{{$meal_system_info->to_date}}" class="form-control to-date" name='to_date[]'/>
                    </td>
                    <td style="width: 8%">{{$meal_system_info->price}}</td>
                    <td class="days" style="width: 14%">{{$meal_system_info->days}}</td>
                    <td style="width: 6%">
                        <button type="button" class="btn btn-sm remove-meal-system rounded-pill btn-icon btn-danger text-white">
                            <span class="tf-icons bx bx-x"></span>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
@endif

<script>
    $('#hotel_id').on('change', function (){
        let hotel_id = $(this).val();
        let url = `{{ route('hotel.getHalls', ':hotel_id') }}`.replace(':hotel_id', hotel_id);
        axios.get(url)
        .then(response => {
            $('#hall_id').html(response.data)
        })
        .catch(error => {

        })
        console.log(url)
    })

    $('#mpi_for_normal').on('change',function (){
        let type = '{{\App\MealSystemType::NORMAL->value}}';
        removeTypeWiseMealSystems(type)
        callMealPriceWiseMealSystem();
    })
    $('#mpi_for_ramadan').on('change',function (){
        let type = '{{\App\MealSystemType::RAMADAN->value}}';
        removeTypeWiseMealSystems(type)
        callMealPriceWiseMealSystem()
    })

    @if($is_edit)
        callMealPriceWiseMealSystem();
    @endif


    function removeTypeWiseMealSystems(type){
        let tr = $('tr');
        for(let i = 0; i < tr.length; i++){
            let el = tr.eq(i);
            if(el.attr('type') == type){
                el.remove();
            }
        }
    }

    function callMealPriceWiseMealSystem(){
        let mpi_normal_id = $('#mpi_for_normal').val();
        let mpi_ramadan_id = $('#mpi_for_ramadan').val();
        axios.get('{{route('meal-system-by-meal-price')}}', {
            params: {
                meal_price_ids: [mpi_normal_id, mpi_ramadan_id]
            }
        })
        .then(function (response) {
            $('#meal_system_for_meal_price').html(response.data)
        })
        .then(function (error){
            console.log('need to handle error ', error)
        })
    }


    //add meal system in order
    $('#add-meal-system').on('click', function (){

        let selected_meal_system = $('#meal_system_for_meal_price').val();
        let price = $('#meal_system_for_meal_price option:selected').attr('price');
        let type = $('#meal_system_for_meal_price option:selected').attr('type');
        let name = $('#meal_system_for_meal_price option:selected').text();

        if (!selected_meal_system){
            Toast('{{__('page.please_select_a_meal_system')}}', 'error');
        }
        else if (!price){
            Toast('{{__('page.this_meal_system_has_no_price')}}', 'error');
        }
        else if(checkExistMealSystem(selected_meal_system)){
            Toast('{{__('page.this_meal_system_already_exist')}}', 'error');
        }
        else{
            let today = "{{date('Y-m-d')}}";
            let tr = `
                <tr type="${type}">
                    <td style="width: 26%;">
                        ${name}
                        <input type="hidden" value="${selected_meal_system}" class="meal_system_price_id" name="meal_system_price_id[]"/>
                    </td>
                    <td style="width: 18%">
                        <input type='number' required class='form-control' name='guest[]'/>
                    </td>
                    <td style="width: 14%">
                        <input type='date' required min="${today}" class='form-control from-date' name='from_date[]'/>
                    </td>
                    <td style="width: 14%">
                        <input type='date' required min="${today}" class="form-control to-date" name='to_date[]'/>
                    </td>
                    <td style="width: 8%">${price}</td>
                    <td class="days" style="width: 14%">0</td>
                    <td style="width: 6%">
                        <button type="button" class="btn btn-sm remove-meal-system rounded-pill btn-icon btn-danger text-white">
                          <span class="tf-icons bx bx-x"></span>
                        </button>
                    </td>
                </tr>
            `;

            $('#order_meal_price').append(tr)
        }



        function checkExistMealSystem(id){
            let is_exist = false;
            for(let i =0; i < $('.meal_system_price_id').length; i++){
                let res = $('.meal_system_price_id').eq(i).val() == id;
                if(res){
                    is_exist =  true;
                    break;
                }
            }
            return is_exist;
        }

    })



    //form submit condition
    @if(request()->get(\App\Enums\OrderEditTypeEnum::KEY->value) == \App\Enums\OrderEditTypeEnum::WITH_MEAL->value)
        $('form').on('submit', function (e){
            let has_meal_system = $('.meal_system_price_id').length;
            if(has_meal_system == 0){
                e.preventDefault();
                Toast('At least one need one system', 'error')
            }
        })
    @endif

    //remove meal system
    $('#order_meal_price').on('click', '.remove-meal-system', function (){
        $(this).parent().parent().remove();
    })


    $('#order_meal_price').on('change', '.from-date', function (){
        calculateDays();
    })

    $('#order_meal_price').on('change', '.to-date', function (){
        calculateDays();
    })

    function calculateDays(){
        const from_date_els = $('.from-date');

        for(let i =0; i < from_date_els.length; i++){
            let tr = from_date_els.eq(i).parent().parent();
            let from_date = from_date_els.eq(i).val();
            let to_date = tr.find('.to-date').val();
            let days_el = tr.find('.days');
            let count_of_days = dateDiff(from_date, to_date)
            days_el.html(count_of_days)
        }



    }





</script>
