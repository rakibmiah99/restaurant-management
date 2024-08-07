
<x-main-layout :title="__('menu.roles')">
    <div class="p-4">
        <div class="card">
           <x-card-header :can-create="\App\Helper::HasPermissionMenu('role', 'create')" :url="route('role.create')" :name="__('page.roles')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <div class="table-responsive mt-2 table-paginate text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns  as $column)
                                <th>{{__('db.company.'.$column)}}</th>
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
                                            @if($column == "status")
                                                {{$item->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value }}
                                            @elseif($column == 'country_id')
                                                {{$item->country?->name}}
                                            @elseif($column == 'meal_price_id')
                                                {{$item->meal_price?->name}}
                                            @else
                                                {{$item->$column}}
                                            @endif
                                        </td>

                                    @endforeach

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>



                                            <div class="dropdown-menu" style="">
                                                <a data-bs-toggle="modal" data-bs-target="#viewModal" class="dropdown-item view-btn" href="javascript:void(0);" url="{{route('role.show', $item->id)}}"><i class='bx bx-low-vision me-1'></i>{{__('page.view')}}</a>
                                                @if($item->is_system != 1)
                                                    @if(\App\Helper::HasPermissionMenu('role', 'update'))
                                                        <a class="dropdown-item" href="{{route('role.edit', $item->id)}}"><i class="bx bx-edit-alt me-1"></i>{{__('page.edit')}}</a>
                                                    @endif

                                                    @if(\App\Helper::HasPermissionMenu('role', 'delete'))
                                                        <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route('role.delete', $item->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>{{__('page.delete')}}</a>
                                                    @endif
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
