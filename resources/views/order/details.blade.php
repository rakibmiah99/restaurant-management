<table class="table">
    <tbody id="data" class="table-border-bottom-0">
    @foreach($columns as $column)
        <tr>
            <th>{{__('db.order.'.$column)}}</th>
            <th>:</th>
            <td>
                @if($column == 'status')
                    {{$order?->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value}}
                @elseif($column == 'company_id')
                    {{$order->company?->name}}
                @elseif($column == 'hotel_id')
                    {{$order->hotel?->name}}
                @elseif($column == 'hall_id')
                    {{$order->hall?->name}}
                @elseif($column == 'country_id')
                    {{$order->country?->name}}
                @elseif($column == 'mpi_for_normal')
                    {{$order->meal_price_for_normal?->name}}
                @elseif($column == 'mpi_for_ramadan')
                    {{$order->meal_price_for_ramadan?->name}}
                @endif
                {{$order?->$column}}
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
