@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp
@if(!$is_edit) <input type="hidden" name="type" value="{{request()->get('meal-type')}}"/> @endif
<div class="mb-3 row">
    <div class="col-md-4">
        <label for="html5-text-input" class=" col-form-label">
            {{__('page.pricing_code')}}
            <x-required/>
            <x-input-error name="code"/>
        </label>
        <div class="">
            <input readonly required value="{{$is_edit ? $meal_price->code : \App\Models\MealPrice::GenerateUniqueCode()}}" name="code" class="form-control" type="text" id="html5-text-input">
        </div>
    </div>


    <div class="col-md-8">
        <label class=" col-form-label text-md-end">
            {{__('page.pricing_name')}}
            <x-required/>
            <x-input-error name="name"/>
        </label>
        <div class="">
            <input required value="{{$is_edit ? $meal_price->name:  old('name')}}" name="name" class="form-control" type="text">
        </div>
    </div>

    <div class="col-md-4 mt-3">

            <label for="html5-email-input" class="col-form-label">
                {{__('page.cuisine_name')}}
                <x-required/>
                <x-input-error name="country_id" />
            </label>
            <div class="">
                <select required name="country_id" class="form-select select-2" id="countriesId" aria-label="Default select example">
                    <option value="">{{__('page.select')}}</option>
                    @foreach($countries as $county)
                        <option @if(old('country_id' == $county->id)) selected @endif value="{{$county->id}}">{{$county->name}}</option>
                    @endforeach
                </select>
            </div>
    </div>

    <div class="col-md-4 mt-3">
            <label for="html5-url-input" class=" col-form-label">
                {{__('page.service_type')}}
                <x-required/>
                <x-input-error name="service_type" />
            </label>
            <div class="">
                <select name="service_type" id="service_type" class="form-select">
                    <option>{{__('page.select')}}</option>
                    @foreach(\App\ServiceType::toArray() as $type)
                        <option
                            @if($is_edit ? $meal_price->service_type :  old('service_type') == $type) selected @endif
                            value="{{$type}}"
                        >{{$type}}</option>
                    @endforeach
                </select>
            </div>
    </div>

    <div class="col-md-4 mt-3">
            <label for="html5-datetime-local-input" class=" col-form-label">
                {{__('page.pricing_status')}}
                <x-required/>
                <x-input-error name="status" />
            </label>
            <div class="">
                <div class="col-md">
                    <div class="form-check form-check-inline mt-1">
                        <input  @if($is_edit ? $meal_price->status : old('status') ) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1">
                        <label class="form-check-label" for="inlineRadio1">{{__('page.active')}}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input @if($is_edit ? !$meal_price->status : !old('status')) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
                        <label class="form-check-label" for="inlineRadio2">{{__('page.inactive')}}</label>
                    </div>
                </div>
            </div>
    </div>

    <div class="d-flex justify-content-center mt-4 ">
        <div class="w-50 mt-3 border border-1  px-3">
            @if($is_edit)
                @if($meal_systems->count() > 0)
                    @foreach($meal_systems as $meal_system_for_meal_price)
                        @php $meal_system = $meal_system_for_meal_price->meal_system; @endphp
                        <div class="mb-3 mt-3 row">
                            <label for="html5-text-input" class="col-md-5 col-form-label">
                                {{$meal_system->name}}
                                <x-required/>
                                <x-input-error name="meal_systems"/>
                            </label>
                            <div class="col-md-7">
                                <input type="hidden" value="{{$meal_system->id}}" name="meal_systems[]">
                                <input required value="{{$meal_system_for_meal_price->price}}" name="meal_system_price[]" class="form-control" type="number" id="html5-text-input">
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- IF HAS MEAL PRICE BUT NOT ANY MEAL SYSTEM IN  `meal_system_for_meal_price` YOU CAN REMOVE AFTER PRODUCTION AND CLEAN DATA-->
                    @foreach(\App\Models\MealSystem::where('type', $meal_price->type)->get() as $meal_system)
                        <div class="mb-3 mt-3 row">
                            <label for="html5-text-input" class="col-md-5 col-form-label">
                                {{$meal_system->name}}
                                <x-required/>
                                <x-input-error name="meal_systems"/>
                            </label>
                            <div class="col-md-7">
                                <input type="hidden" value="{{$meal_system->id}}" name="meal_systems[]">
                                <input required value="0" name="meal_system_price[]" class="form-control" type="number" id="html5-text-input">
                            </div>
                        </div>
                    @endforeach
                @endif


            @else
                @foreach($meal_systems as $meal_system)
                    <div class="mb-3 mt-3 row">
                        <label for="html5-text-input" class="col-md-5 col-form-label">
                            {{$meal_system->name}}
                            <x-required/>
                            <x-input-error name="meal_systems"/>
                        </label>
                        <div class="col-md-7">
                            <input type="hidden" value="{{$meal_system->id}}" name="meal_systems[]">
                            <input required value="0" name="meal_system_price[]" class="form-control" type="number" id="html5-text-input">
                        </div>
                    </div>
                @endforeach
            @endif



        </div>
    </div>
</div>






