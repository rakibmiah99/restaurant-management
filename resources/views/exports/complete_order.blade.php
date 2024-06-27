<x-export-layout :title="$title"  :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <td style="font-size: 9px" align="left" width="{{$per_cell}}">
                    @if($column == "hall")
                        {{$item->hall?->name}}
                    @elseif($column == "company_id")
                        {{$item->company?->name}}
                    @elseif($column == "hotel")
                        {{$item->hotel?->name}}
                    @elseif($column == "cuisine_name")
                        {{$item->country?->name}}
                    @elseif($column == "meal_system")
                        {{$item->meal_system_names}}
                    @elseif($column == "total_guest")
                        {{$item->total_guest}}
                    @else
                        {{$item->$column}}
                    @endif
                </td>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>

