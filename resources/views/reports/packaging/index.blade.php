

<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.orders')" :url-name="__('page.create')"/>
            <div class="mt-3">
                @include('reports.packaging.filter_form')
                <x-filter-data export-url="report.export.packaging" translate-from="db.report.kitchen" :columns="$columns"/>

                <div style="min-height: 400px" class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns as $column)
                                <th>{{__('db.report.packaging.'.$column)}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach ($data as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                @foreach(request()->columns ?? $columns as $column)
                                    <th>
                                        @if($column == "cuisine_name")
                                            {{$item->country}}
                                        @else
                                            {{$item->$column}}
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
