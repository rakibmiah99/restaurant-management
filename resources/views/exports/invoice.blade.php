<x-export-layout :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <td style="font-size: 9px" align="left" width="{{$per_cell}}">
                    @if($column == "order_number")
                        {{$item->order?->order_number}}
                    @elseif($column == "hotel_id")
                        {{$item->order?->hotel?->name}}
                    @elseif($column == "hall_id")
                        {{$item->order?->hall?->name}}
                    @else
                        {{$item->$column}}
                    @endif
                </td>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>

