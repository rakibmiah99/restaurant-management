

<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.invoice_reports')" :url-name="__('page.create')"/>
            <div class="mt-3">
                @include('reports.invoice.filter_form')
                <x-filter-data :can-export="true" export-url="report.export.invoice" translate-from="db.report.invoice" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns as $column)
                                <th>{{__('db.report.invoice.'.$column)}}</th>
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
                                <th>
                                    @include('reports.view_btn', ['route' => route('report.show.invoice', $item->id)])
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
