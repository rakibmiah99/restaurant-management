
<x-main-layout :title="__('menu.meal_price')">
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="\App\Helper::HasPermissionMenu('meal_price', 'create')" :url="route('meal_price.choose')" :name="__('page.meal_price')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data :can-export="\App\Helper::HasPermissionMenu('meal_price', 'export')" export-url="meal_price.export" translate-from="db.meal_price" :columns="$columns"/>

                <div class="table-responsive table-paginate mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            @foreach(request()->columns ?? $columns  as $column)
                                <th>{{__('db.meal_price.'.$column)}}</th>
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
                                    @if($column == 'country_id')
                                        <td>{{$item->country?->name}}</td>
                                    @elseif($column == "status")
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
                                        <x-action-buttons
                                            :model="$item"
                                            permission-for="meal_price"
                                            route-prefix="meal_price"
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
                        <th>{{__('db.meal_price.'.$column)}}</th>
                        <th>:</th>
                        <td id="v-{{$column}}"></td>
                    </tr>
                @endforeach

                </tbody>
            </table>




            <div class="d-flex justify-content-center">
                <table  class="table w-75 table-secondary table-bordered">
                    <thead>
                        <tr>
                            <th>Meal System Name</th>
                            <th>:</th>
                            <th>Price</th>
                        </tr>
                    </thead>

                    <tbody id="meal-systems">

                    </tbody>
                </table>
            </div>
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
                    if (property == "country_id"){
                        $(id).html(data.country.name)
                    }
                    else if (property == "status"){
                        $(id).html(data[property] ? '{{__('page.active')}}' : '{{__('page.inactive')}}')
                    }
                    else{
                        $(id).html(data[property])
                    }

                }

                let meal_systems = $('#meal-systems')
                meal_systems.empty();
                data.meal_systems.forEach(function(item){
                    let tr = `
                        <tr >
                            <td>${item.meal_system.name}</td>
                            <td>:</td>
                            <td>${item.price}</td>
                        </tr>
                    `;

                    meal_systems.append(tr)
                })
            })
            .catch(function (error){

            });
    })

</script>
