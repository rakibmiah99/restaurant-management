<html
    lang="{{app()->getLocale() == "en" ? 'en' : 'ar'}}"
    dir="{{app()->getLocale() == "en" ? 'ltr' : 'rtl'}}"
>
    <head>
        <x-header/>
    </head>
    <body>
        <h1 class="text-center my-3">{{__('page.order_details')}}</h1>
        <div id="data-view" class="table-responsive mt-2 text-nowrap">
        <table class="table">
            <tbody id="data" class="table-border-bottom-0">
            @foreach($columns as $column)
                <tr>
                    <th>{{__('db.order.'.$column)}}</th>
                    <th>:</th>
                    <td>
                        @if($column == 'status')
                            {{$order?->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value}}
                        @elseif($column == 'company_id')
                            {{$order->company?->name}}
                        @elseif($column == 'hotel_id')
                            {{$order->hotel?->name}}
                        @elseif($column == 'hall_id')
                            {{$order->hall?->name}}
                        @elseif($column == 'country_id')
                            {{$order->country?->name}}
                        @elseif($column == 'mpi_for_normal')
                            {{$order->meal_price_for_normal?->name}}
                        @elseif($column == 'mpi_for_ramadan')
                            {{$order->meal_price_for_ramadan?->name}}
                        @endif
                        {{$order?->$column}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <h4 class="text-center mt-2">{{__('page.meal_system')}}</h4>
        <div class="mt-2 mb-3 d-flex justify-content-center">
            <table class="table table-bordered  rounded-5 " style="width: 100%">
                <thead>
                <tr>
                    <th>{{__('page.meal_system')}}</th>
                    <th>{{__('page.number_of_guest')}}</th>
                    <th>{{__('page.from_date')}}</th>
                    <th>{{__('page.to_date')}}</th>
                    <th>{{__('page.price')}}</th>
                    <th>{{__('page.total_days')}}</th>
                </tr>
                </thead>
                <tbody id="order_meal_price">
                @foreach($order->meal_systems as $meal_system_info)
                    <tr type="{{$meal_system_info->meal_system->type}}">
                        <td style="width: 26%;">
                            {{$meal_system_info->meal_system->name."-".$meal_system_info->meal_system->type}}
                        </td>
                        <td style="width: 18%">
                            {{$meal_system_info->number_of_guest}}
                        </td>
                        <td style="width: 14%">
                            {{$meal_system_info->from_date}}
                        </td>
                        <td style="width: 14%">
                            {{$meal_system_info->to_date}}
                        </td>
                        <td style="width: 8%">{{$meal_system_info->price}}</td>
                        <td class="days" style="width: 14%">{{$meal_system_info->days}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </body>
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

        printDiv('data-view');


        $(document).ready(function (){
            window.close()
        })
    </script>
</html>
