<x-export-layout :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <td style="font-size: 9px" align="left" width="{{$per_cell}}">
                @if($column == "status")
                    {{$item->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value }}
                @elseif($column == "hotel_id")
                    {{$item->hotel?->name}}
                @elseif(
                        $column == 'b_start' ||
                        $column == 'b_end' ||
                        $column == 'l_start' ||
                        $column == 'l_end' ||
                        $column == 'd_start' ||
                        $column == 'd_end' ||
                        $column == 's_start' ||
                        $column == 's_end' ||
                        $column == 'i_start' ||
                        $column == 'i_end'
                    )
                    {{\App\Helper::ConvertTo12HourFormat($item->$column)}}
                @else
                    {{$item->$column}}
                    @endif
                </td>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>

