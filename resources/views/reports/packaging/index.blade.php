

<x-main-layout :title="__('menu.packaging_report')">
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.packaging_reports')" :url-name="__('page.create')"/>
            <div class="mt-3">
                @include('reports.packaging.filter_form')
                <x-filter-data :can-export="true" :search="false" export-url="report.export.packaging" translate-from="db.report.kitchen" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
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
                        @php $index = \App\Helper::PageIndex() @endphp
                        @foreach ($data as $key=>$item)
                            <tr>
                                <td>{{$index++}}</td>
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
                    <x-when-table-empty :data-length="$data->count()"/>
                </div>


                <div class="px-3 mt-3">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
