@php
    $per_cell = $attributes->get('per_cell');
    $columns = $attributes->get('columns');
    $headings = $attributes->get('headings');
@endphp

<html>
<head>
    <title>ff</title>
    <style>

    </style>
</head>
<body>
<table class="table">
    <thead>
    <tr class="info">
        <td align="center" colspan="{{count($columns)+1}}">
            <img src="{{public_path('assets/logo.png')}}"  alt="logo" height="50" width="50"/>
            <br>
            Title
            <br>
            {{date('d M,Y h:i:s A')}}
            <br>
            {{auth()->user()->name}}
            <br>
        </td>
    </tr>
    <tr>
        <th width="5">{{__('page.sl')}}</th>
        @foreach(request()->columns ?? $columns as $column)
            <th  width="{{$per_cell}}"><b>{{__($headings.'.'.$column)}}</b></th>
        @endforeach
    </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        {{$slot}}
    </tbody>
</table>
</body>
</html>
