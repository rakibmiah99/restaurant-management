@php $settings = \App\Models\CompanySetting::first(); @endphp

<x-main-layout :title="__('menu.invoice')">
    <div class="p-4">
        <div class="card pb-4">
            <div id="invoice">
                <div class="border p-3">
                    <h3 class="text-center mb-2">{{__('page.invoice')}}</h3>
                    <div>
                        <img src="{{asset('assets/logo.png')}}" alt="" height="50">
                    </div>
                    <div class="d-flex">
                        <div class="w-50">
                            <table class="table table-borderless">
                                @foreach(['name', 'address', 'phone', 'email'] as $column)
                                    <tr>
                                        <td style="width: 7%" class="ps-0">{{__('page.'.$column)}}</td>
                                        <td style="width: 2%">:</td>
                                        <td style="text-align: left" class="p-0">
                                            @if($column == 'name')
                                                {{$settings->company_name}}
                                            @elseif($column == 'address')
                                                {{$settings->company_address}}
                                            @elseif($column == 'phone')
                                                {{$settings->company_phone}}
                                            @elseif($column == 'email')
                                                {{$settings->company_email}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="w-50">
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width: 30%" class="ps-0">{{__('page.invoice_number')}}</td>
                                    <td style="width: 2%">:</td>
                                    <td style="text-align: left" class="p-0">
                                        {{$invoice->invoice_number}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex">
                        <div class="w-50">
                            <b class="d-block">{{__('page.date')}}</b>
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width: 30%" class="ps-0">{{__('page.invoice_date')}}</td>
                                    <td style="width: 2%">:</td>
                                    <td style="text-align: left" class="p-0">
                                        {{$invoice->invoice_date}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="w-50">
                            <b class="d-block">{{__('page.invoice_to')}}</b>
                            <table class="table table-borderless">
                                @foreach([ 'name', 'address', 'phone', 'email'] as $column)
                                    <tr>
                                        <td style="width: 7%" class="ps-0">{{__('page.'.$column)}}</td>
                                        <td style="width: 2%">:</td>
                                        <td style="text-align: left" class="p-0">
                                            @if($column == 'name')
                                                {{$invoice->order?->company?->name}}
                                            @elseif($column == 'address')
                                                {{$invoice->order?->company?->address}}
                                            @elseif($column == 'phone')
                                                {{$invoice->order?->company?->phone}}
                                            @elseif($column == 'email')
                                                {{$invoice->order?->company?->email}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>


                        </div>
                    </div>

                </div>

                <div class="p-3">
                    <table class="table table-bordered mb-3">
                        <tr>
                            <th>{{__('page.meal_system')}}</th>
                            <th>{{__('page.total_meal')}}</th>
                            <th>{{__('page.price')}}</th>
                            <th>{{__('page.total_price')}}</th>
                        </tr>
                        @foreach($invoice->invoice_data as $item)
                            <tr>
                                <input type="hidden" value="{{$item->meal_system_id}}" required name="meal_system_id[]">
                                <td>{{ $item->meal_system->name}}</td>
                                <td>{{$item->total_meal}}</td>
                                <td>
                                    {{$item->price}}
                                </td>
                                <td class="total_price">{{$item->total_price}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-end" colspan="3">{{__('page.discount')}}</td>
                            <td>{{$invoice->discount}}</td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="3">{{__('page.tax')}}</td>
                            <td>{{$invoice->tax_amount}}</td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="3">{{__('page.total')}}</td>
                            <td>{{$invoice->total_with_tax}}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="text-center">
                <button class="btn btn-primary" id="printBtn">{{__('page.print')}}</button>
            </div>
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

    $('#printBtn').on('click', function (){
        printDiv('invoice');
    })
</script>
