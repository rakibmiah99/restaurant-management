<table class="table">
    @foreach(request()->columns ?? $columns as $column)
        <tr>
            <th>{{__('db.report.revenue.'.$column)}}</th>
            <th>:</th>
            <th>
                @if($column == "order_number")
                    {{$invoice?->order?->order_number}}
                @elseif($column == "hotel_id")
                    {{$invoice?->order?->hotel?->name}}
                @elseif($column == "company")
                    {{$invoice?->order?->company?->name}}
                @elseif($column == "cuisine_name")
                    {{$invoice?->order?->country?->name}}
                @elseif($column == "service_type")
                    {{$invoice?->order?->service_type}}
                @elseif($column == "no_of_guest")
                    {{$invoice?->order?->total_guest}}
                @elseif($column == "days")
                    {{$invoice?->order?->days}}
                @elseif($column == "meal_system")
                    {{$invoice?->meal_system_names}}
                @else
                    {{$invoice->$column}}
                @endif
            </th>
        </tr>
    @endforeach
</table>
