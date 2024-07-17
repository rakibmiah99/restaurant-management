<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :can-create="\App\Helper::HasPermissionMenu('order', 'create')" :url="route('order.choose')" :name="__('page.orders')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data :can-export="\App\Helper::HasPermissionMenu('order', 'export')" export-url="order.export" translate-from="db.order" :columns="$columns"/>

                <div  class="table-responsive table-paginate mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns  as $column)
                                <th>{{__('db.order.'.$column)}}</th>
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
                                        @if($column == "status")
                                            <td>{{$item->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value }}</td>
                                        @elseif($column == "hall_id")
                                            <td>{{$item->hall?->name}}</td>
                                        @elseif($column == "company_id")
                                            <td>{{$item->company?->name}}</td>
                                        @elseif($column == "hotel_id")
                                            <td>{{$item->hotel?->name}}</td>
                                        @elseif($column == "country_id")
                                            <td>{{$item->country?->name}}</td>
                                        @elseif($column == "mpi_for_normal")
                                            <td>{{$item->meal_price_for_normal?->name}}</td>
                                        @elseif($column == "mpi_for_ramadan")
                                            <td>{{$item->meal_price_for_ramadan?->name}}</td>
                                        @else
                                            <td>{{$item->$column}}</td>
                                        @endif
                                    @endforeach

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>

                                            <x-action-buttons
                                                :model="$item"
                                                permission-for="order"
                                                route-prefix="order"
                                                :edit="false"
                                                :delete="false"
                                            >
                                                @if(\App\Helper::HasPermissionMenu('order', 'modify_guest'))
                                                    <a class="dropdown-item view-btn" href="{{route('order.modify', $item->id)}}"><i class='bx bx-revision me-1'></i>{{__('page.modify_guest')}}</a>
                                                @endif
                                                @if(\App\Helper::HasPermissionMenu('order', 'show_qr'))
                                                        <a class="dropdown-item view-btn" href="{{route('order.showQR', $item->id)}}"><i class='bx bx-qr me-1'></i>{{__('page.show_qr')}}</a>
                                                        <a class="dropdown-item view-btn" href="{{route('order.printQR', $item->id)}}"><i class='bx bx-printer me-1'></i>{{__('page.print_qr')}}</a>
                                                @endif

                                                @if($item->can_edit && \App\Helper::HasPermissionMenu('order', 'update') )
                                                    <a class="dropdown-item" href="{{route('order.edit', $item->id)}}"><i class="bx bx-edit-alt me-1"></i>{{__('page.edit')}}</a>
                                                @endif
                                                @if($item->can_edit && \App\Helper::HasPermissionMenu('order', 'delete'))
                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route('order.delete', $item->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>{{__('page.delete')}}</a>
                                                @endif
                                            </x-action-buttons>
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
