

<x-main-layout :title="__('menu.order_report')">
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.order_reports')" :url-name="__('page.create')"/>
            <div class="mt-3">
                @include('reports.order.filter_form')
                <x-filter-data :can-export="true" export-url="report.export.order" translate-from="db.report.order" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns as $column)
                                <th>{{__('db.report.order.'.$column)}}</th>
                            @endforeach
                            <th>{{__('page.action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @php $index = \App\Helper::PageIndex() @endphp
                        @foreach ($data as $key=>$item)
                            <tr>
                                <td>{{$key++}}</td>
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
                                        @elseif($column == "total_of_guest")
                                            {{$item->total_guest}}
                                        @elseif($column == "first_meal_date")
                                            {{$item->first_meal_date}}
                                        @elseif($column == "last_meal_date")
                                            {{$item->last_meal_date}}
                                        @elseif($column == "num_of_days")
                                            {{$item->number_of_days}}

                                        @endif
                                    </th>

                                @endforeach
                                <th>
                                    @include('reports.view_btn', ['route' => route('report.show.order', $item->id)])
                                </th>
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
