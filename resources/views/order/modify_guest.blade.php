@php $is_edit = request()->segment(2) ?? false  @endphp
<x-main-layout>
    <div class="p-4">
        <div class="card pb-3">
            <x-card-header :name="__('page.orders').'-'.__('page.modify_guest')" :url="route('order.index')" :url-name="__('page.back')"/>

            <table class="table table-bordered table-light">
                <tr>
                    @foreach((new \App\Models\Order())->getColumns() as $column)
                        @if(in_array($column, ['order_note', 'order_type', 'status']) )
                        @else
                            <th class="bg-primary text-white" style="font-size: 12px">{{__('db.order.'.$column)}}</th>
                        @endif
                    @endforeach

                </tr>
                <tr>
                    @foreach((new \App\Models\Order())->getColumns() as $column)
                        @if(in_array($column, ['order_note', 'order_type', 'status']) )
                        @else
                            <td style="font-size: 12px; text-transform: capitalize">
                                @if($column == "company_id")
                                    {{$order->company?->name}}
                                @elseif($column == "hall_id")
                                    {{$order->hall?->name}}
                                @elseif($column == "country_id")
                                    {{$order->country?->name}}
                                @elseif($column == "mpi_for_normal")
                                    {{$order->meal_price_for_normal?->name}}
                                @elseif($column == "mpi_for_ramadan")
                                    {{$order->meal_price_for_ramadan?->name}}
                                @else
                                    {{$order->$column}}
                                @endif
                            </td>
                        @endif
                    @endforeach

                </tr>
            </table>

            <div class="d-flex px-4 justify-content-center mt-3">
                <table class="table w-75 table-bordered table-light">
                    <tr>
                        <th class="bg-primary text-white">{{__('page.meal_system')}}</th>
                        <th class="bg-primary text-white">{{__('page.days')}}</th>
                        <th class="bg-primary text-white">{{__('page.total_meal')}}</th>
                        <th class="bg-primary text-white">{{__('page.price')}}</th>
                        <th class="bg-primary text-white">{{__('page.total_price')}}</th>
                    </tr>
                    @foreach($order->available_meal_systems as $meal_system)
                    <tr>
                        <td>{{$meal_system->name}}</td>
                        <td>{{$meal_system->days}}</td>
                        <td>{{$meal_system->count_of_meal}}</td>
                        <td>{{$meal_system->price}}</td>
                        <td>{{$meal_system->total_price}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <div class="row">
                <form action="" method="get" class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <x-input
                                mode="vertical"
                                :title="__('page.from_date')"
                                name="from_date"
                                :required="true"
                                :readonly="false"
                                type="date"
                                :value="request()->get('from_date')"
                            />

                        </div>
                        <div class="col-2">
                            <x-input
                                mode="vertical"
                                :title="__('page.from_date')"
                                name="to_date"
                                :required="true"
                                :readonly="false"
                                type="date"
                                :value="request()->get('to_date')"
                            />

                        </div>
                        <div class="col-2">
                            <x-input
                                mode="vertical"
                                :title="__('page.number_of_guest')"
                                name="guest"
                                :required="true"
                                :readonly="false"
                                type="number"
                                :value="request()->get('guest')"
                            />

                        </div>
                        <div class="col-3">
                            <x-input-select2
                                mode="vertical"
                                :title="__('page.meal_system')"
                                name="meal_system"
                                :array="$meal_systems"
                                :required="true"
                                :readonly="false"
                                :value="request()->get('meal_system')"
                                :key="1"
                            />



                        </div>
                        <div class="col-3">
                            <div class="d-flex flex-column">
                                <label style="visibility: hidden" for="html5-datetime-local-input" class="col-form-label">d</label>
                                <button type="submit" class="btn btn-primary">
                                    {{__('page.filter')}}
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

            </div>

            <form action="{{route('order.modify.save', $order->id)}}" method="post" class="row card-body">
                @csrf
                <table class="table  table-light">
                    <tr>
                        <th class="bg-primary text-white">{{__('page.date')}}</th>
                        <th class="bg-primary text-white">{{__('page.exist_guest')}}</th>
                        <th class="bg-primary text-white">{{__('page.new_guest')}}</th>
                        <th class="bg-primary text-white">{{__('page.current_meal_system')}}</th>
                        <th class="bg-primary text-white">{{__('page.meal_system')}}</th>
                    </tr>

                    @foreach($date_wise_meal_data as $item)
                    <tr>
                        <td style="width: 15%">
                            <input name="meal_date[]" value="{{$item->meal_date}}" type="hidden"/>
                            {{$item->meal_date}}
                        </td>
                        <td style="width: 15%">
                            {{$item->number_of_guest}}
                        </td>
                        <td style="width: 20%">
                            <input name="number_of_guest[]" class="form-control" type="number" value="{{request()->guest}}"/>
                        </td>
                        <td style="width: 25%">
                            <input name="from_meal_system_id[]" value="{{$item->order_meal_system_id}}" type="hidden"/>
                            {{$item->meal_system_name}}
                        </td>
                        <td style="width: 25%">
                            <select name="to_meal_system[]" class="form-control">
                                <option value="">{{__('page.select')}}</option>
                                @if($item->meal_date == date('Y-m-d'))
                                    @foreach($order->today_meal_price_wise_meal_systems as $meal_system)
                                        <option @if(request()->get('meal_system') == $meal_system->id) selected @endif value="{{$meal_system->id}}">
                                            {{$meal_system->name}}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach($order->meal_price_wise_meal_systems as $meal_system)
                                        <option @if(request()->get('meal_system') == $meal_system->id) selected @endif value="{{$meal_system->id}}">
                                            {{$meal_system->name}}
                                        </option>
                                    @endforeach
                                @endif


                            </select>
                        </td>
                    </tr>
                    @endforeach
                </table>

                @if(count($date_wise_meal_data))
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary">{{__('page.save')}}</button>
                    </div>
                @endif

            </form>
        </div>
    </div>
</x-main-layout>
