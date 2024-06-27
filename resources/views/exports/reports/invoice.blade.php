<x-export-layout :title="$title"  :per_cell="$per_cell" :columns="$columns" :headings="$headings">
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
                    @elseif($column == "service_type")
                        {{$item?->order?->service_type}}
                    @else
                        {{$item->$column}}
                    @endif
                </th>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>
