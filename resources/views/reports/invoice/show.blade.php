<table class="table">
    @foreach(request()->columns ?? $columns as $column)
        <tr>
            <th>{{__('db.report.invoice.'.$column)}}</th>
            <th>:</th>
            <th>
                @if($column == "order_number")
                    {{$invoice?->order?->order_number}}
                @elseif($column == "hotel_id")
                    {{$invoice?->order?->hotel?->name}}
                @elseif($column == "company")
                    {{$invoice?->order?->company?->name}}
                @elseif($column == "service_type")
                    {{$invoice?->order?->service_type}}
                @else
                    {{$invoice->$column}}
                @endif
            </th>
        </tr>
    @endforeach
</table>
