
<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :url="route('hotel.create')" :name="__('page.hotels')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data export-url="hotel.export" translate-from="db.hall" :columns="$columns"/>

                <div class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns  as $column)
                                <th>{{__('db.hall.'.$column)}}</th>
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
                                        @elseif($column == "hotel_id")
                                            <td>{{$item->hotel?->name}}</td>
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
                                                <a data-bs-toggle="modal" data-bs-target="#viewModal" class="dropdown-item view-btn" href="javascript:void(0);" url="{{route('hall.show', $item->id)}}"><i class='bx bx-low-vision'></i>{{__('page.view')}}</a>
                                                <a class="dropdown-item" href="{{route('hall.edit', $item->id)}}"><i class="bx bx-edit-alt me-1"></i>{{__('page.edit')}}</a>
                                                <a class="dropdown-item" href="{{route('hall.changeStatus', $item->id)}}"><i class='bx bx-checkbox-minus'></i> {{$item->status ? __('page.inactive') : __('page.active') }}</a>
                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route('hall.delete', $item->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>{{__('page.delete')}}</a>
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
                            <th>{{__('db.hall.'.$column)}}</th>
                            <th>:</th>
                            <td id="v-{{$column}}"></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-center">
            <table  class="table w-75 table-secondary table-bordered">
                <thead>
                    <tr>
                        <th>{{__('page.meal_system')}}</th>
                        <th>:</th>
                        <th>{{__('page.start_time')}}</th>
                        <th>{{__('page.end_time')}}</th>
                    </tr>
                </thead>

                <tbody id="meal-systems">

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
            let meal_times = data.meal_times;
            for(let property in data){
                let id = '#v-'+property;

                if (property == "status"){
                    $(id).html(data[property] ? '{{__('page.active')}}' : '{{__('page.inactive')}}')
                }

                else if (property == "hotel_id"){
                    let name = data.hotel?.name;
                    $(id).html(name);
                }
                else{
                    $(id).html(data[property])
                }
            }


            meal_times.forEach(function (time){
                let meal_system = time.meal_system.name;
                let tr = `
                    <tr>
                        <td>${meal_system}</td>
                        <td>:</td>
                        <td>${convertTo12HourFormat(time.start_time)}</td>
                        <td>${convertTo12HourFormat(time.end_time)}</td>
                    </tr>
                `;

                $('#meal-systems').append(tr);
            })
        })
        .catch(function (error){

        });
    })

</script>
