<x-export-layout :title="$title"  :per_cell="$per_cell" :columns="$columns" :headings="$headings">
    @foreach ($data as $key=>$item)
        <tr>
            <td style="font-size: 9px" width="5">{{$key+1}}</td>
            @foreach(request()->columns ?? $columns as $column)
                <th style="font-size: 9px" align="left" width="{{$per_cell}}">
                    @if($column == "cuisine_name")
                        {{$item->country}}
                    @else
                        {{$item->$column}}
                    @endif
                </th>

            @endforeach
        </tr>
    @endforeach
</x-export-layout>
