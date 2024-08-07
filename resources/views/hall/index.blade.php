
<x-main-layout :title="__('menu.hall')">
    <div class="p-4">
        <div class="card">
           <x-card-header :can-create="\App\Helper::HasPermissionMenu('hall', 'create')" :url="route('hall.create')" :name="__('page.halls')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data :can-export="\App\Helper::HasPermissionMenu('hall', 'export')" export-url="hall.export" translate-from="db.hall" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
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
                        @php $index = \App\Helper::PageIndex() @endphp
                            @foreach ($data as $key=>$item)
                                <tr>
                                    <td>{{$index++}}</td>
                                    @foreach(request()->columns ?? $columns as $column)
                                        @if($column == "status")
                                            <td>{{$item->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value }}</td>
                                        @elseif($column == "hotel_id")
                                            <td>{{$item->hotel?->name}}</td>
                                        @elseif(
                                                $column == 'b_start' ||
                                                $column == 'b_end' ||
                                                $column == 'l_start' ||
                                                $column == 'l_end' ||
                                                $column == 'd_start' ||
                                                $column == 'd_end' ||
                                                $column == 's_start' ||
                                                $column == 's_end' ||
                                                $column == 'i_start' ||
                                                $column == 'i_end'
                                            )
                                            <td>{{\App\Helper::ConvertTo12HourFormat($item->$column)}}</td>
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
                                                permission-for="hall"
                                                route-prefix="hall"
                                            />
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
