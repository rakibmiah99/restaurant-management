@php
    $page = request()->page ?? 1;
    $page = $page-1;
@endphp
<x-main-layout :title="__('menu.orders')">
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('order.choose')" :name="__('page.orders')" :url-name="__('page.create')"/>
            <div class="mt-3">


                <div style="min-height: 400px" class="table-responsive mt-2 text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('page.sl')}}</th>
                            <th>Company Name</th>
                            <th>Name</th>
                            <th>{{__('page.action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach ($data as $key=>$item)
                            <tr>
                                <td>{{($per_page_data*$page)+($key+1)}}</td>
                                <td>{{$order->company?->name}}</td>
                                <td>{{$item['name']}}</td>
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
