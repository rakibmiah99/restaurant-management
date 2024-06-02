
<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :url="route('hotel.create')" :name="__('page.hotels')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data export-url="hotel.export" translate-from="db.hotel" :columns="$columns"/>

                <div class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns  as $column)
                                <th>{{__('db.hotel.'.$column)}}</th>
                            @endforeach
                            <th>{{__('page.action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    @foreach(request()->columns ?? $columns as $column)
                                        @if($column == "status")
                                            <td>{{$item->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value }}</td>
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
                                                <a data-bs-toggle="modal" data-bs-target="#viewModal" class="dropdown-item view-btn" href="javascript:void(0);" url="{{route('hotel.show', $item->id)}}"><i class='bx bx-low-vision'></i>{{__('page.view')}}</a>
                                                <a class="dropdown-item" href="{{route('hotel.edit', $item->id)}}"><i class="bx bx-edit-alt me-1"></i>{{__('page.edit')}}</a>
                                                <a class="dropdown-item" href="{{route('hotel.changeStatus', $item->id)}}"><i class='bx bx-checkbox-minus'></i> {{$item->status ? __('page.inactive') : __('page.active') }}</a>
                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route('hotel.delete', $item->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>{{__('page.delete')}}</a>
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
                            <th>{{__('db.hotel.'.$column)}}</th>
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
                else{
                    $(id).html(data[property])
                }


            }
        })
        .catch(function (error){

        });
    })

</script>
