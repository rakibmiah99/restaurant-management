

<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :url="route('order.choose')" :name="__('page.orders')" :url-name="__('page.create')"/>
            <div class="mt-3">
                @include('order_monitoring.filter_form')
                <x-filter-data export-url="order_monitoring.export" translate-from="db.order_monitoring" :columns="$columns"/>

                <div style="min-height: 400px" class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns as $column)
                                <th>{{__('db.order_monitoring.'.$column)}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    @foreach(request()->columns ?? $columns as $column)
                                        <th>
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
                                        </th>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


               <div class="px-3 mt-3">
                   {{ $data->links() }}
               </div>
            </div>
        </div>
    </div>
</x-main-layout>
