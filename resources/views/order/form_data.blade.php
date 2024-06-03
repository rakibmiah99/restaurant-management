@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp

<div class="row">
    <div class="col-md-4">
        <x-input
            mode="vertical"
            :title="__('page.order_number')"
            name="order_number"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $hall->code :\App\Models\Order::GenerateOrderNumber()"
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
            :value="$is_edit ? $hall->code : old('order_date')"
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
            :value="$is_edit ? $order->hotel_id : old('company_id')"
            :code="$is_edit ? $order->company?->code : false"
            :key="2"
        />
    </div>
    @if(request()->get('order-type') == \App\Enums\OrderType::NORMAL->value || request()->get('order-type') == \App\Enums\OrderType::BOTH->value )
        <div class="col-md-4">
            <x-input-select2
                mode="vertical"
                :title="__('page.meal_price_normal')"
                :is_required="true"
                :array="$mealPricesNormal"
                name="mpi_for_normal"
                :with_code="true"
                :value="$is_edit ? $order->mpi_for_normal : false"
                :code="$is_edit ? $order->mpi_for_normal?->code : false"
                :key="3"
            />
        </div>
    @endif
    @if(request()->get('order-type') == \App\Enums\OrderType::RAMADAN->value || request()->get('order-type') == \App\Enums\OrderType::BOTH->value )
        <div class="col-md-4">
            <x-input-select2
                mode="vertical"
                :title="__('page.meal_price_ramadan')"
                :is_required="true"
                :array="$mealPricesRamadan"
                name="mpi_for_ramadan"
                :with_code="true"
                :value="$is_edit ? $order->mpi_for_normal : false"
                :code="$is_edit ? $order->mpi_for_normal?->code : false"
                :key="4"
            />
        </div>
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
            :array="[]"
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
    :required="true"
    :value="$is_edit ? $order->order_note:  old('order_note')"
/>

<x-input-status :value="$is_edit ? $order->status : old('status')" :title="__('page.hotel_status')"/>
<div class="row">
    <div class="col-md-6 mb-3">
        <x-input-select2
            :title="__('page.meal_system')"
            :is_required="false"
            :array="[]"
            name="meal_system_for_meal_price"
            :value="$is_edit ? $company->country_id : ''"
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

        </tbody>
    </table>
</div>

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

    let mpi_ramadan_id;
    let mpi_normal_id;
    $('#mpi_for_normal').on('change',function (){
        mpi_normal_id = $(this).val();
        callMealPriceWiseMealSystem();
    })
    $('#mpi_for_ramadan').on('change',function (){
        mpi_ramadan_id = $(this).val();
        callMealPriceWiseMealSystem()
    })

    function callMealPriceWiseMealSystem(){
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
            let tr = `
                <tr>

                    <td style="width: 26%;" ">
                        ${name}
                        <input type="hidden" value="${selected_meal_system}" class="meal_system_price_id" name="meal_system_price_id[]"/>
                    </td>
                    <td style="width: 18%">
                        <input type='number' required class='form-control' name='guest[]'/>
                    </td>
                    <td style="width: 14%">
                        <input type='date' required class='form-control' name='from_date[]'/>
                    </td>
                    <td style="width: 14%">
                        <input type='date' required class="form-control" name='to_date[]'/>
                    </td>
                    <td style="width: 8%">${price}</td>
                    <td style="width: 14%">0</td>
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



    $('form').on('submit', function (e){
        let has_meal_system = $('.meal_system_price_id').length;
        if(has_meal_system == 0){
            e.preventDefault();
            Toast('At least one need one system', 'error')
        }
    })


    $('#order_meal_price').on('click', '.remove-meal-system', function (){
        $(this).parent().parent().remove();
    })
</script>
