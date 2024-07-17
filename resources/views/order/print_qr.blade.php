
<x-main-layout :title="__('menu.orders')">
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="\App\Helper::HasPermissionMenu('order', 'show_qr')" :url="route('order.index')" :name="__('page.orders')" :url-name="__('page.back')"/>
            <div id="data-view">
                <div  style="display: flex; flex-wrap: wrap">
                    @foreach($data as $item)
                        <div style="margin: 10px">
                            <div>
                                {{$item->qr}}
                                <h6>{{$item->name}}</h6>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <button class="btn btn-primary" onclick="printDiv('data-view')">Print</button>
        </div>
    </div>

</x-main-layout>

<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        setTimeout(function(){
            $('#showMealModal').hide();
            $('.modal-backdrop').hide();
        },250);
        window.print();
        // Wait a while a print your contents
        document.body.innerHTML = originalContents;
    }



</script>




