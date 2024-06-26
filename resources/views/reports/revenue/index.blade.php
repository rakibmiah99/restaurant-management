

<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.invoices')" :url-name="__('page.create')"/>
            <div class="mt-3">
                @include('reports.revenue.filter_form')
                <x-filter-data export-url="report.export.revenue" translate-from="db.report.revenue" :columns="$columns"/>

                <div style="min-height: 400px" class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns as $column)
                                <th>{{__('db.report.revenue.'.$column)}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach ($data as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                @foreach(request()->columns ?? $columns as $column)
                                    <td>
                                        @if($column == "order_number")
                                            {{$item?->order?->order_number}}
                                        @elseif($column == "hotel_id")
                                            {{$item?->order?->hotel?->name}}
                                        @elseif($column == "company")
                                            {{$item?->order?->company?->name}}
                                        @elseif($column == "cuisine_name")
                                            {{$item?->order?->country?->name}}
                                        @elseif($column == "service_type")
                                            {{$item?->order?->service_type}}
                                        @elseif($column == "no_of_guest")
                                            {{$item?->order?->total_guest}}
                                        @elseif($column == "days")
                                            {{$item?->order?->days}}
                                        @elseif($column == "meal_system")
                                            {{$item?->meal_system_names}}
                                        @else
                                            {{$item->$column}}
                                        @endif
                                    </td>
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
