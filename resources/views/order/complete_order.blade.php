<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :url="route('order.choose')" :name="__('page.complete_orders')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data :can-export="true" export-url="order.export.complete" translate-from="db.complete_order" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns  as $column)
                                <th>{{__('db.complete_order.'.$column)}}</th>
                            @endforeach
                            @if(\App\Helper::HasPermissionMenu('invoice', 'create'))
                                <th>{{__('page.action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php $index = \App\Helper::PageIndex() @endphp
                            @foreach ($data as $key=>$item)
                                <tr>
                                    <td>{{$index++}}</td>
                                    @foreach(request()->columns ?? $columns as $column)
                                       @if($column == "hall")
                                            <td>{{$item->hall?->name}}</td>
                                        @elseif($column == "company_id")
                                            <td>{{$item->company?->name}}</td>
                                        @elseif($column == "hotel")
                                            <td>{{$item->hotel?->name}}</td>
                                        @elseif($column == "cuisine_name")
                                            <td>{{$item->country?->name}}</td>
                                        @elseif($column == "meal_system")
                                            <td>{{$item->meal_system_names}}</td>
                                        @elseif($column == "total_guest")
                                            <td>{{$item->total_guest}}</td>
                                        @else
                                            <td>{{$item->$column}}</td>
                                        @endif
                                    @endforeach

                                    <td>
                                        @if(\App\Helper::HasPermissionMenu('invoice', 'create'))
                                            <a href="{{route('invoice.create', $item->id)}}" class="btn btn-sm btn-primary">{{__('page.generate')}}</a>
                                        @endif
                                    </td>
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

