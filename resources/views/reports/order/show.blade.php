<table class="table">
    @foreach(request()->columns ?? $columns as $column)
        <tr>
            <th>{{__('db.report.order.'.$column)}}</th>
            <th>:</th>
            <th>
                @if($column == "order_number")
                    {{$order->order_number}}
                @elseif($column == "order_date")
                    {{$order->order_date}}
                @elseif($column == "hotel")
                    {{$order->hotel?->name}}
                @elseif($column == "hall")
                    {{$order->hall?->name}}
                @elseif($column == "cuisine_name")
                    {{$order->country?->name}}
                @elseif($column == "meal_system")
                    {{$order->meal_system_names}}
                @elseif($column == "service_type")
                    {{$order->$column}}
                @elseif($column == "company")
                    {{$order->company?->name}}
                @elseif($column == "total_of_guest")
                    {{$order->total_guest}}
                @elseif($column == "first_meal_date")
                    {{$order->first_meal_date}}
                @elseif($column == "last_meal_date")
                    {{$order->last_meal_date}}
                @elseif($column == "num_of_days")
                    {{$order->number_of_days}}

                @endif
            </th>
        </tr>
    @endforeach
</table>
