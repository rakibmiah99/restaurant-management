@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp

<div class="row">
    <div class="col-md-6">
        <x-input-select2
            :title="__('page.order_number')"
            :is_required="true"
            :array="$orders"
            label-size="col-md-4"
            input-size="col-md-8"
            name="order_id"
            display_column="order_number"
            :value="$is_edit ? $company->country_id : $order?->id"
            :key="1"
        />
    </div>
    <div class="col-md-6">
        <x-input
            :title="__('page.order_date')"
            label-size="col-md-4"
            input-size="col-md-8"
            name="order_date"
            type="date"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $company->unique_id : $order?->order_date"
        />
    </div>
    <div class="col-md-6">
        <x-input
            :title="__('page.invoice_number')"
            label-size="col-md-4"
            input-size="col-md-8"
            name="invoice_number"
            type="text"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $company->unique_id :\App\Models\Invoice::GenerateInvoiceNumber()"
        />
    </div>
    <div class="col-md-6">
        <x-input
            :title="__('page.invoice_date')"
            label-size="col-md-4"
            input-size="col-md-8"
            name="invoice_date"
            type="date"
            :required="true"
            :readonly="false"
            :value="$is_edit ? $company->unique_id :\App\Models\Company::GenerateUniqueID()"
        />
    </div>
    <div class="col-md-6">
        <x-input
            :title="__('page.company_code')"
            label-size="col-md-4"
            input-size="col-md-8"
            name="company_code"
            type="text"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $company->unique_id : $order?->company?->code"
        />
    </div>
    <div class="col-md-6">
        <x-input
            :title="__('page.company_name')"
            label-size="col-md-4"
            input-size="col-md-8"
            name="company_name"
            type="text"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $company->unique_id : $order?->company?->name"
        />
    </div>
    <div class="col-md-6">
        <x-input
            :title="__('page.cuisine_name')"
            label-size="col-md-4"
            input-size="col-md-8"
            name="cuisine_name"
            type="text"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $company->unique_id : $order?->country?->name"
        />
    </div>
    <div class="col-md-6">
        <x-input
            :title="__('page.service_type')"
            label-size="col-md-4"
            input-size="col-md-8"
            name="service_type"
            type="text"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $company->unique_id : $order?->service_type"
        />
    </div>
    <div class="col-md-12">
        <x-input
            :title="__('page.order_note')"
            label-size="col-md-2"
            input-size="col-md-10"
            name="order_note"
            type="text"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $company->unique_id : $order?->order_note"
        />
    </div>
</div>

@if($order)
<table class="table table-bordered mb-3">
    <tr>
        <th>{{__('page.meal_system')}}</th>
        <th>{{__('page.total_meal')}}</th>
        <th>{{__('page.price')}}</th>
        <th>{{__('page.total_price')}}</th>
    </tr>
    @foreach($available_meal_systems as $item)
        <tr>
            <input type="hidden" value="{{$item->meal_system_id}}" required name="meal_system_id[]">
            <td>{{$item->name}}</td>
            <td>{{$item->count_of_meal}}</td>
            <td>
                <input total-meal="{{$item->count_of_meal}}" value="{{$item->price}}" class="form-control price" required min="1" name="price[]">
            </td>
            <td class="total_price">{{$item->total_price}}</td>
        </tr>
    @endforeach
</table>

<div class="row">
    <div class="col-md-4">
        <x-input
            mode="vertical"
            :title="__('page.total_discount')"
            name="discount"
            type="number"
            :required="true"
            :readonly="false"
            :value="0"
        />
    </div>
    <div class="col-md-4">
        <x-input
            after-label="<span value='{{$tax_percentage}}' id='tax_percentage'>({{$tax_percentage}}%)</span>"
            mode="vertical"
            :title="__('page.total_tax')"
            name="tax"
            type="number"
            :required="true"
            :readonly="true"
            :value="$tax_amount"
        />
    </div>
    <div class="col-md-4">
        <x-input
            mode="vertical"
            :title="__('page.total_amount')"
            name="total"
            type="number"
            :required="true"
            :readonly="true"
            :value="$total_with_tax"
        />
    </div>
</div>
@endif
<script>

    $('#order_id').on('change', function (){
        let order_id = $(this).val();
        let url = "{{route('invoice.create', 'order_id')}}".replace('order_id', order_id);
        console.log(url)
        location.href = url;
    })


    $('.price').on('keyup', function (){
        calculation();
    });

    $('#discount').on('keyup', function (){
        calculation();
    })







    function calculation(){
        let total_price_elements = $('.total_price');
        let tax_percentage = $('#tax_percentage').attr('value');
        let discount = $('#discount').val();
        let price_elements = $('.price');


        for(let i =0; i< price_elements.length; i++){
            let price_el = price_elements.eq(i);
            let price = price_el.val();
            let tr = price_el.parent().parent();
            let total_price_el = tr.find('.total_price');
            let total_meal = price_el.attr('total-meal');
            total_price_el.html(price * total_meal);
        }

        let total_price = 0;
        for(let i = 0; i < total_price_elements.length; i++){
            let price = total_price_elements.eq(i).html();
            total_price += parseFloat(price);
        }

        tax_percentage = parseFloat(tax_percentage);
        //get total price after discount
        total_price -= discount;
        //get percentage amount
        let tax_amount = (total_price * tax_percentage) / 100;

        //get total price with tax amount
        total_price+=tax_amount;


        $('#tax').val(tax_amount)
        $('#total').val(total_price)

    }


    calculation();





</script>

