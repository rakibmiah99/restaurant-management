<x-main-layout :title="__('menu.hall_report')">
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.hall_reports')" :url-name="__('page.create')"/>
            <div class="mt-3">
                @include('reports.hall.filter_form')
                <x-filter-data :can-export="true" export-url="report.export.hall" translate-from="db.report.hall" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns as $column)
                                <th>{{__('db.report.hall.'.$column)}}</th>
                            @endforeach
                            <th>{{__('page.action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @php $index = \App\Helper::PageIndex() @endphp
                        @foreach ($data as $key=>$item)
                            <tr>
                                <td>{{$index++}}</td>
                                @foreach(request()->columns ?? $columns as $column)
                                    <th>
                                        @if($column == "order_number")
                                            {{$item->order_number}}
                                        @elseif($column == "order_date")
                                            {{$item->order_date}}
                                        @elseif($column == "hotel")
                                            {{$item->hotel?->name}}
                                        @elseif($column == "hall")
                                            {{$item->hall?->name}}
                                        @elseif($column == "cuisine_name")
                                            {{$item->country?->name}}
                                        @elseif($column == "meal_system")
                                            {{$item->meal_system_names}}
                                        @elseif($column == "service_type")
                                            {{$item->$column}}
                                        @elseif($column == "company")
                                            {{$item->company?->name}}
                                        @elseif($column == "breakfast")
                                            {{$item->total_break_fast}}
                                        @elseif($column == "lunch")
                                            {{$item->total_lunch}}
                                        @elseif($column == "dinner")
                                            {{$item->total_dinner}}
                                        @elseif($column == "seheri")
                                            {{$item->total_seheri}}
                                        @elseif($column == "iftar")
                                            {{$item->total_iftar}}
                                        @elseif($column == "total_meal")
                                            {{$item->total_meal}}
                                        @endif
                                    </th>

                                @endforeach
                                <td>
                                    @include('reports.view_btn', ['route' => route('report.show.hall', $item->id)])
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
    <x-view-modal size="modal-lg">
        <div id="data-view" class="table-responsive mt-2 text-nowrap">

        </div>
    </x-view-modal>
</x-main-layout>
<script>
    $('.view-btn').on('click', function (){
        $('#meal-systems').empty();
        modalLoaderON();
        let url = $(this).attr('url')
        axios({
            method: 'get',
            url: url
        })
            .then(function (response){
                modalLoaderOFF();
                const data = response.data;
                $('#data-view').html(data)
            })
            .catch(function (error){

            });
    })
</script>
