<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :url="route('order.choose')" :name="__('page.orders')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data export-url="order.export" translate-from="db.order" :columns="$columns"/>

                <div style="min-height: 400px" class="table-responsive mt-2 text-nowrap">
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
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item view-btn" href="{{route('order.modify', $item->id)}}"><i class='bx bx-low-vision'></i>{{__('page.modify_guest')}}</a>
                                                <a class="dropdown-item view-btn" href="{{route('order.showQR', $item->id)}}"><i class='bx bx-low-vision'></i>{{__('page.show_qr')}}</a>
                                                <a data-bs-toggle="modal" data-bs-target="#viewModal" class="dropdown-item view-btn" href="javascript:void(0);" url="{{route('order.show', $item->id)}}"><i class='bx bx-low-vision'></i>{{__('page.view')}}</a>
                                                <a class="dropdown-item" href="{{route('order.edit', $item->id)}}"><i class="bx bx-edit-alt me-1"></i>{{__('page.edit')}}</a>
                                                <a class="dropdown-item" href="{{route('order.changeStatus', $item->id)}}"><i class='bx bx-checkbox-minus'></i> {{$item->status ? __('page.inactive') : __('page.active') }}</a>
                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route('order.delete', $item->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>{{__('page.delete')}}</a>
                                            </div>
                                        </div>
                                    </td>
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

    <x-view-modal size="modal-lg">
        <div class="table-responsive mt-2 text-nowrap">
            <table class="table">
                <tbody id="data" class="table-border-bottom-0">
                    @foreach($columns as $column)
                        <tr>
                            <th>{{__('db.order.'.$column)}}</th>
                            <th>:</th>
                            <td id="v-{{$column}}"></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
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
            for(let property in data){
                let id = '#v-'+property;

                if (property == "status"){
                    $(id).html(data[property] ? '{{__('page.active')}}' : '{{__('page.inactive')}}')
                }
                else if (
                    property == 'b_start' ||
                    property == 'b_end' ||
                    property == 'l_start' ||
                    property == 'l_end' ||
                    property == 'd_start' ||
                    property == 'd_end' ||
                    property == 's_start' ||
                    property == 's_end' ||
                    property == 'i_start' ||
                    property == 'i_end'
                ){
                    $(id).html(convertTo12HourFormat(data[property]));
                }

                else if (property == "hotel_id"){
                    let name = data.hotel?.name;
                    $(id).html(name);
                }
                else{
                    $(id).html(data[property])
                }
            }
        })
        .catch(function (error){

        });
    })

</script>
