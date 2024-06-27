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
                    @elseif($column == "breakfast")
                        {{$item->total_break_fast}}
                    @elseif($column == "lunch")
                        {{$item->total_lunch}}
                    @elseif($column == "dinner")
                        {{$item->total_dinner}}
                    @elseif($column == "seheri")
                        {{$item->total_seheri}}
                    @elseif($column == "iftar")
                        {{$item->total_iftar}}
                    @elseif($column == "total_meal")
                        {{$item->total_meal}}
                    @endif
                </th>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>
