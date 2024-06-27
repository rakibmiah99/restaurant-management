
<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :url="route('company.create')" :name="__('page.companies')" :url-name="__('page.create')"/>
            <div class="mt-3">
                <x-filter-data export-url="company.export" translate-from="db.company" :columns="$columns"/>

                <div class="table-responsive mt-2 text-nowrap">
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
                                                <a data-bs-toggle="modal" data-bs-target="#viewModal" class="dropdown-item view-btn" href="javascript:void(0);" url="{{route('company.show', $item->id)}}"><i class='bx bx-low-vision'></i>{{__('page.view')}}</a>
                                                <a class="dropdown-item" href="{{route('company.edit', $item->id)}}"><i class="bx bx-edit-alt me-1"></i>{{__('page.edit')}}</a>
                                                <a class="dropdown-item" href="{{route('company.changeStatus', $item->id)}}"><i class='bx bx-checkbox-minus'></i> {{$item->status ? __('page.inactive') : __('page.active') }}</a>
                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route('company.delete', $item->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>{{__('page.delete')}}</a>
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
                            <th>{{__('db.company.'.$column)}}</th>
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
                console.log(data[property])
                $(id).html(data[property])


            }
        })
        .catch(function (error){

        });
    })

</script>
