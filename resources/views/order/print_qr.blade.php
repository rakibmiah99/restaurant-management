
<x-main-layout :title="__('menu.orders')">
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="\App\Helper::HasPermissionMenu('order', 'show_qr')" :url="route('order.index')" :name="__('page.orders')" :url-name="__('page.back')">
                <form action="{{route('order.printQR', $order->id)}}" class="d-flex justify-between items-center px-2">
                    

                    <select name="per-page" style="width: 150px" class="form-select form-select-sm me-4">
                        @foreach(config('page.page_view_options_print') as $page)
                            <option 
                            @if (request()->get('per-page') == $page)
                                selected
                            @elseif(!request()->get('per-page') && config('page.per_page_view_print') == $page)
                                selected
                            @endif value="{{$page}}">{{$page}}</option>
                        @endforeach
                    </select>

                    <select name="meal-system" style="width: 150px" class="form-select form-select-sm me-4">
                        <option value="">{{__('page.select')}}</option>
                        @foreach($meal_systems as $meal_system)
                            <option 
                            @if (request()->get('meal-system') == $meal_system->id)
                                selected
                            @endif value="{{$meal_system->id}}">{{$meal_system->name}}</option>
                        @endforeach
                    </select>

                    <div style="padding-top: 4px" class="d-flex p-6 justify-between me-4">
                        {{-- <small style="margin-top: 10px" class="mb-0 d-block text-uppercase">{{__('page.guest_mode')}}</small> --}}
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" @if(request()->get('is-available-guest') == "false") checked @endif type="radio"  name="is-available-guest" id="inlineRadio1" value="true">
                          <label class="form-check-label" for="inlineRadio1">{{__('page.only_available')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" @if(request()->get('is-available-guest') != "false") checked @endif type="radio" name="is-available-guest" id="inlineRadio2" value="false">
                          <label class="form-check-label" for="inlineRadio2">{{__('page.all_guest')}}</label>
                        </div>
                    
                    </div>

                    <select name="segment" style="width: 150px" class="form-select form-select-sm me-4">
                        {{-- <option>{{__('page.select')}}</option> --}}
                        @foreach($segments as $segment)
                            <option 
                            @if (request()->get('segment') == $segment)
                                selected
                            @endif value="{{$segment}}">{{$segment+1}}
                        </option>
                        @endforeach
                    </select>

            
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
            <div id="data-view">
                <div  style="display: flex; flex-wrap: wrap">
                    @foreach($data as $item)
                        <div style="margin: 10px">
                            <div>
                                {{$item->qr}}
                                <small class="d-block">{{$item->meal_system}}</small>
                                <h6>{{$item->name}}</h6>
                                
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <button type="submit" class="btn btn-primary" onclick="printDiv('data-view')">Print</button>
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




