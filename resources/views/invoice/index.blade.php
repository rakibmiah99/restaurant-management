
<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :url="route('invoice.create')" :name="__('page.invoices')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data export-url="invoice.export" translate-from="db.invoice" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns  as $column)
                                <th>{{__('db.invoice.'.$column)}}</th>
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
                                        @if($column == "order_number")
                                            <td>{{$item->order?->order_number}}</td>
                                        @elseif($column == "hotel_id")
                                            <td>{{$item->order?->hotel?->name}}</td>
                                        @elseif($column == "hall_id")
                                            <td>{{$item->order?->hall?->name}}</td>
                                        @else
                                            <td>{{$item->$column}}</td>
                                        @endif

                                    @endforeach

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a {{--data-bs-toggle="modal" data-bs-target="#viewModal"--}} class="dropdown-item view-btn" url="javascript:void(0);" href="{{route('invoice.show', $item->id)}}"><i class='bx bx-low-vision'></i>{{__('page.view')}}</a>
                                                @if(!$item->is_close)
                                                    <a class="dropdown-item" href="{{route('invoice.edit', $item->id)}}"><i class="bx bx-edit-alt me-1"></i>{{__('page.edit')}}</a>
                                                @endif
                                                <a class="dropdown-item" href="{{route('invoice.changeStatus', $item->id)}}"><i class='bx bx-checkbox-minus'></i> {{$item->is_close ? __('page.closed') : __('page.make_to_close') }}</a>
                                                @if(!$item->is_close)
                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route('invoice.delete', $item->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>{{__('page.delete')}}</a>
                                                @endif
                                            </div>
                                        </div>
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



    <x-view-modal size="modal-xl">
        <div id="modal-body"></div>
    </x-view-modal>
</x-main-layout>

<script>

    $('.view-btn').on('click', function (){
        modalLoaderON();
        let url = $(this).attr('url')
        axios({
            method: 'get',
            url: url
        })
        .then(function (response){
            modalLoaderOFF();
            const data = response.data;
            $('#modal-body').html(data);
        })
        .catch(function (error){

        });
    })

</script>
