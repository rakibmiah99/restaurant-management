<x-main-layout>
    <div class="p-4">
        <div class="card">
           <x-card-header :url="route('company.create')" name="Create"/>
            <div class="mt-3">

                <form class="d-flex px-2 justify-content-between" id="search-form">
                    <select name="perpage" onchange="$('#search-form').trigger('submit')" style="width: 150px" class="form-select form-select-sm">
                        <option @if(request()->perpage == 10) selected @endif value="10">10</option>
                        <option @if(request()->perpage == 30) selected @endif value="30">30</option>
                        <option @if(request()->perpage == 50) selected @endif value="50">50</option>
                        <option @if(request()->perpage == 100) selected @endif value="100">100</option>
                    </select>

                    <!-- searchData function in main layout script -->
                    <input value="{{request()->q}}" name="q" onkeyup="searchData()" style="width: 150px" id="searchInput" class="form-control d-inline form-control-sm" type="text" placeholder="search">

                </form>

                <div class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Agent</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $key=>$item)
                                <tr>
                                    <th>{{$key+1}}</th>
                                    <th>{{$item->code}}</th>
                                    <th>{{$item->name}}</th>
                                    <th>{{$item->country_id}}</th>
                                    <th>{{$item->agent_name}}</th>
                                    <th>{{$item->email}}</th>
                                    <th>{{$item->status ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value }}</th>
                                    <th>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a data-bs-toggle="modal" data-bs-target="#viewModal" class="dropdown-item view-btn" href="javascript:void(0);" url="{{route('company.show', $item->id)}}"><i class='bx bx-low-vision'></i> View</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="{{route('company.changeStatus', $item->id)}}"><i class='bx bx-checkbox-minus'></i> {{$item->status ? \App\Enums\Status::INACTIVE->value : \App\Enums\Status::ACTIVE->value }}</a>
                                                <a data-bs-toggle="modal" data-bs-target="#deleteModal" url="{{route('company.delete', $item->id)}}"  class="dropdown-item delete-btn" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                    </th>
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
                let tr = `
                    <tr>
                        <th>${property}</th>
                        <th>:</th>
                        <td>${data[property]}</td>
                    </tr>
                `;
                $('#data').append(tr);
            }
        })
        .catch(function (error){

        });
    })

</script>
