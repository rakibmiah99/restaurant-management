<x-export-layout :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <th style="font-size: 9px" align="left" width="{{$per_cell}}">
                    @if($column == "order_number")
                        {{$item?->order?->order_number}}
                    @elseif($column == "hotel_id")
                        {{$item?->order?->hotel?->name}}
                    @elseif($column == "company")
                        {{$item?->order?->company?->name}}
                    @elseif($column == "cuisine_name")
                        {{$item?->order?->country?->name}}
                    @elseif($column == "service_type")
                        {{$item?->order?->service_type}}
                    @elseif($column == "no_of_guest")
                        {{$item?->order?->total_guest}}
                    @elseif($column == "days")
                        {{$item?->order?->days}}
                    @elseif($column == "meal_system")
                        {{$item?->meal_system_names}}
                    @else
                        {{$item->$column}}
                    @endif
                </th>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>
