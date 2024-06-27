<x-export-layout :title="$title"  :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <td style="font-size: 9px" align="left" width="{{$per_cell}}">
                @if($column == "status")
                    {{$item->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value }}
                @elseif($column == "hall_id")
                    {{$item->hall?->name}}
                @elseif($column == "company_id")
                    {{$item->company?->name}}
                @elseif($column == "hotel_id")
                    {{$item->hotel?->name}}
                @elseif($column == "country_id")
                    {{$item->country?->name}}
                @elseif($column == "mpi_for_normal")
                    {{$item->meal_price_for_normal?->name}}
                @elseif($column == "mpi_for_ramadan")
                    {{$item->meal_price_for_ramadan?->name}}
                @else
                    {{$item->$column}}
                @endif
                </td>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>

