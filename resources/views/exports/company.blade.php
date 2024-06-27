<x-export-layout :title="$title"  :title="$title" :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <td style="font-size: 9px" align="left" width="{{$per_cell}}">
                    @if($column == "status")
                        {{$item->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value }}
                    @elseif($column == 'country_id')
                        {{$item->country?->name}}
                    @elseif($column == 'meal_price_id')
                        {{$item->meal_price?->name}}
                    @else
                        {{$item->$column}}
                    @endif
                </td>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>

