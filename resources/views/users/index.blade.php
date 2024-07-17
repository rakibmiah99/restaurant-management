
<x-main-layout :title="__('menu.users')">
    <div class="p-4">
        <div class="card">
           <x-card-header :can-create="\App\Helper::HasPermissionMenu('user', 'create')" :url="route('user.create')" :name="__('page.users')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data export-url="invoice.export" translate-from="db.users" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns  as $column)
                                <th>{{__('db.users.'.$column)}}</th>
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
                                        @if($column == "roles")
                                            <td>{{implode($item->roles->pluck('name')->toArray())}}</td>
                                        @elseif($column == "hotel_id")
                                            <td>{{$item->order?->hotel?->name}}</td>
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
                                                permission-for="user"
                                                route-prefix="user"
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



    <x-view-modal :title="__('page.view_user_permissions')" size="modal-xl">
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
