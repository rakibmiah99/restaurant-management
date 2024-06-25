@php $settings = \App\Models\CompanySetting::first(); @endphp
<div class="border p-3">
    <h3 class="text-center mb-2">{{__('page.invoice')}}</h3>
    <div>
        <img src="{{asset('assets/logo.png')}}" alt="" height="50">
    </div>
    <div class="d-flex p-3">
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
                    <td style="width: 15%" class="ps-0">{{__('page.invoice_number')}}</td>
                    <td style="width: 2%">:</td>
                    <td style="text-align: left" class="p-0">
                        {{$invoice->invoice_number}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="d-flex">
        <div class="w-50">

        </div>
        <div class="w-50">

        </div>
    </div>

</div>
