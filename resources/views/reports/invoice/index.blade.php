

<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.invoices')" :url-name="__('page.create')"/>
            <div class="mt-3">
                @include('reports.invoice.filter_form')
                <x-filter-data export-url="report.export.invoice" translate-from="db.report.invoice" :columns="$columns"/>

                <div style="min-height: 400px" class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns as $column)
                                <th>{{__('db.report.invoice.'.$column)}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @php $index = \App\Helper::PageIndex() @endphp
                        @foreach ($data as $key=>$item)
                            <tr>
                                <td>{{$index++}}</td>
                                @foreach(request()->columns ?? $columns as $column)
                                    <td>
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
