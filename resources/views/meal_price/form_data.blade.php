@php $is_edit = isset($is_edit) ? $is_edit : false;  @endphp
@if(!$is_edit) <input type="hidden" name="type" value="{{request()->get('meal-type')}}"/> @endif
<div class="mb-3 row">
    <div class="col-md-4">
        <x-input
            mode="vertical"
            :title="__('page.pricing_code')"
            name="code"
            type="text"
            :required="true"
            :readonly="true"
            :value="$is_edit ? $meal_price->code : \App\Models\MealPrice::GenerateUniqueCode()"
        />
    </div>


    <div class="col-md-8">
        <x-input
            mode="vertical"
            :title="__('page.pricing_name')"
            name="name"
            type="text"
            :required="true"
            :value="$is_edit ? $meal_price->name:  ''"
        />
    </div>

    <div class="col-md-4 mt-3">

            <x-input-select2
                mode="vertical"
                :title="__('page.cuisine_name')"
                :is_required="true"
                :array="$countries"
                name="country_id"
                :value="$is_edit ? $meal_price->country_id : ''"
            />

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
        <x-input-status
            mode="vertical"
            :value="$is_edit ? $meal_price->status : old('status')"
            :title="__('page.pricing_status')"
        />
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
                                <input min="1" required value="{{$meal_system_for_meal_price->price}}" name="meal_system_price[]" class="form-control" type="number" id="html5-text-input">
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
                                <input min="1" required value="0" name="meal_system_price[]" class="form-control" type="number" id="html5-text-input">
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
                            <input required min="1" value="0" name="meal_system_price[]" class="form-control" type="number" id="html5-text-input">
                        </div>
                    </div>
                @endforeach
            @endif



        </div>
    </div>
</div>






