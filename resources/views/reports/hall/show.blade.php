<table class="table">
    @foreach(request()->columns ?? $columns as $column)
        <tr>
            <th>{{__('db.report.hall.'.$column)}}</th>
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
                @elseif($column == "breakfast")
                    {{$order->total_break_fast}}
                @elseif($column == "lunch")
                    {{$order->total_lunch}}
                @elseif($column == "dinner")
                    {{$order->total_dinner}}
                @elseif($column == "seheri")
                    {{$order->total_seheri}}
                @elseif($column == "iftar")
                    {{$order->total_iftar}}
                @elseif($column == "total_meal")
                    {{$order->total_meal}}
                @endif
            </th>
        </tr>
    @endforeach
</table>
