<x-export-layout :title="$title"  :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <th style="font-size: 9px" align="left" width="{{$per_cell}}">
                    @if($column == "order_number")
                        {{$item->order_number}}
                    @elseif($column == "order_date")
                        {{$item->order_date}}
                    @elseif($column == "hotel")
                        {{$item->hotel?->name}}
                    @elseif($column == "hall")
                        {{$item->hall?->name}}
                    @elseif($column == "cuisine_name")
                        {{$item->country?->name}}
                    @elseif($column == "meal_system")
                        {{$item->meal_system_names}}
                    @elseif($column == "service_type")
                        {{$item->$column}}
                    @elseif($column == "company")
                        {{$item->company?->name}}
                    @elseif($column == "total_of_guest")
                        {{$item->total_guest}}
                    @elseif($column == "first_meal_date")
                        {{$item->first_meal_date}}
                    @elseif($column == "last_meal_date")
                        {{$item->last_meal_date}}
                    @elseif($column == "num_of_days")
                        {{$item->number_of_days}}
                    @endif
                </th>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>
