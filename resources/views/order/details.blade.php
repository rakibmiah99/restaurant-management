<table class="table">
    <tbody id="data" class="table-border-bottom-0">
    @foreach($columns as $column)
        <tr>
            <th>{{__('db.order.'.$column)}}</th>
            <th>:</th>
            <td>
                @if($column == 'status')
                    {{$order?->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value}}
                @elseif($column == 'company_id')
                    {{$order->company?->name}}
                @elseif($column == 'hotel_id')
                    {{$order->hotel?->name}}
                @elseif($column == 'hall_id')
                    {{$order->hall?->name}}
                @elseif($column == 'country_id')
                    {{$order->country?->name}}
                @elseif($column == 'mpi_for_normal')
                    {{$order->meal_price_for_normal?->name}}
                @elseif($column == 'mpi_for_ramadan')
                    {{$order->meal_price_for_ramadan?->name}}
                @endif
                {{$order?->$column}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<h4 class="text-center mt-2">Meal Systems</h4>
<div class="mt-2 mb-3 d-flex justify-content-center">
    <table class="table table-bordered  rounded-5 " style="width: 90%">
        <thead>
        <tr>
            <th>{{__('page.meal_system')}}</th>
            <th>{{__('page.number_of_guest')}}</th>
            <th>{{__('page.from_date')}}</th>
            <th>{{__('page.to_date')}}</th>
            <th>{{__('page.price')}}</th>
            <th>{{__('page.total_days')}}</th>
        </tr>
        </thead>
        <tbody id="order_meal_price">
        @foreach($order->meal_systems as $meal_system_info)
            <tr type="{{$meal_system_info->meal_system->type}}">
                <td style="width: 26%;">
                    {{$meal_system_info->meal_system->name."-".$meal_system_info->meal_system->type}}
                </td>
                <td style="width: 18%">
                    {{$meal_system_info->number_of_guest}}
                </td>
                <td style="width: 14%">
                    {{$meal_system_info->from_date}}
                </td>
                <td style="width: 14%">
                    {{$meal_system_info->to_date}}
                </td>
                <td style="width: 8%">{{$meal_system_info->price}}</td>
                <td class="days" style="width: 14%">{{$meal_system_info->days}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="text-center mt-2">
    <a href="{{route('order.printDetails', $order->id)}}" target="_blank" class="btn btn-primary" id="printBtn">{{__('page.print')}}</a>
</div>
