<x-export-layout :title="$title"  :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <td style="font-size: 9px" align="left" width="{{$per_cell}}">
                    @if($column == "order_number")
                        {{$item->order?->order_number}}
                    @elseif($column == 'meal_date')
                        {{$item->$column}}
                    @elseif($column == "order_date")
                        {{$item->order?->order_date}}
                    @elseif($column == "hotel")
                        {{$item->order?->hotel?->name}}
                    @elseif($column == "hall")
                        {{$item->order?->hall?->name}}
                    @elseif($column == "cuisine_name")
                        {{$item->order?->country?->name}}
                    @elseif($column == "meal_system_id")
                        {{$item->meal_system?->name}}
                    @elseif($column == "complete")
                        {{$item->total_taken}}
                    @elseif($column == "total_meal")
                        {{$item->total_guest}}
                    @elseif($column == "in_hall")
                        {{$item->in_hall}}
                    @endif
                </td>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>

