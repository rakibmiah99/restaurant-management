@php
    $page = request()->page ?? 1;
    $page = $page-1;
@endphp
<x-main-layout :title="__('menu.orders')">
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.orders')" :url-name="__('page.create')">
                <form action="{{route('order.showQR', $order->id)}}" class="d-flex justify-between items-center px-2">
                    

                    <select name="meal-system" style="width: 150px" class="form-select form-select-sm me-4">
                        <option value="">{{__('page.select')}}</option>
                        @foreach($meal_systems as $meal_system)
                            <option 
                            @if (request()->get('meal-system') == $meal_system->name)
                                selected
                            @endif value="{{$meal_system->name}}">{{$meal_system->name}}</option>
                        @endforeach
                    </select>

                    <div style="padding-top: 4px" class="d-flex p-6 justify-between me-4">
                        {{-- <small style="margin-top: 10px" class="mb-0 d-block text-uppercase">{{__('page.guest_mode')}}</small> --}}
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" @if(request()->get('is-available-guest') != "false") checked @endif type="radio"  name="is-available-guest" id="inlineRadio1" value="true">
                          <label class="form-check-label" for="inlineRadio1">{{__('page.only_available')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" @if(request()->get('is-available-guest') == "false") checked @endif type="radio" name="is-available-guest" id="inlineRadio2" value="false">
                          <label class="form-check-label" for="inlineRadio2">{{__('page.all_guest')}}</label>
                        </div>
                    
                    </div>


                    <div class="p-6">
                        <input class="form-control form-control-sm d-inline"
                        name="guest-name"
                        type="text"
                        placeholder="{{__('page.filter_by_guest_name')}}"
                        value="{{request()->get('guest-name')}}"
                    >
                

            
                    </div>

                    <div class="ms-3">
                        <button  type="submit" class="btn btn-sm btn-primary w-100">{{__('page.filter')}}</button>
                    </div>

                    
                    
                    {{-- <div class="col-md-3">
                        <label style="font-size: 10px; visibility: hidden" class="col-form-label"> f</label>
                        <button type="submit" class="btn btn-primary w-100">{{__('page.filter')}}</button>
                    </div> --}}
                </form>
                
            </x-card-header>
            
            
            
            
            <div class="mt-3">


                <div style="min-height: 400px" class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            <th>{{__('page.company_name')}}</th>
                            <th>{{__('page.name')}}</th>
                            <th>{{__('page.meal_system')}}</th>
                            <th>{{__('page.entry_date')}}</th>
                            <th>{{__('page.exit_date')}}</th>
                            <th>{{__('page.action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach ($data as $key=>$item)
                            <tr>
                                <td>{{($per_page_data*$page)+($key+1)}}</td>
                                <td>{{$order->company?->name}}</td>
                                <td>{{$item['name']}}</td>
                                <td>{{$item['meal_system']}}</td>
                                <td>{{$item['from_date']}}</td>
                                <td>{{$item['to_date']}}</td>
                                <td>
                                    <button data-bs-toggle="modal"  data-bs-target="#viewModal"  url="{{route('order.showGuestQr', $item['code'])}}"  class="btn view-btn btn-sm btn-outline-primary">
                                        <i class='bx bx-show'></i>
                                    </button>
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
        <div id="show_guest_qr" class="d-flex flex-column align-items-center ">

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
                $('#show_guest_qr').empty();
                $('#show_guest_qr').append(data);
            })
            .catch(function (error){

            });
    })

</script>
