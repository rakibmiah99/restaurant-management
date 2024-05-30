<x-main-layout>
    <div class="p-4">
        <div class="card">
            <div class="d-flex pe-4 justify-content-between align-items-center">
                <h5 class="card-header">Companies</h5>
                <button type="button" class="btn btn-sm btn-primary">Create</button>
            </div>
            <hr class="m-0">
            <div class="mt-3">

                <form class="d-flex px-2 justify-content-between" id="search-form">
                    <select name="perpage" onchange="$('#search-form').trigger('submit')" style="width: 150px" class="form-select form-select-sm">
                        <option @if(request()->perpage == 10) selected @endif value="10">10</option>
                        <option @if(request()->perpage == 30) selected @endif value="30">30</option>
                        <option @if(request()->perpage == 50) selected @endif value="50">50</option>
                        <option @if(request()->perpage == 100) selected @endif value="100">100</option>
                    </select>

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
                                    <th>{{$item->status}}</th>
                                    <th>Action</th>
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

</x-main-layout>

<script>
    let timeout = null;
    function searchData(){
        clearTimeout(timeout);
        timeout = setTimeout(function (){
            $('#search-form').trigger('submit');
        }, 500)
    }
</script>
