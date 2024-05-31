

<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :url="route('company')" name="Back"/>
            <form action="{{route('company.store')}}" method="post" c class="card-body">
                @csrf
                <div class="mb-3 row">
                    <label for="html5-text-input" class="col-md-2 col-form-label">
                        Company Code
                        <x-required/>
                        <x-input-error name="unique_id"/>
                    </label>
                    <div class="col-md-10">
                        <input readonly required value="{{\App\Models\Company::GenerateUniqueID()}}" name="unique_id" class="form-control" type="text" id="html5-text-input">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">
                        Company Name
                        <x-required/>
                        <x-input-error name="name"/>
                    </label>
                    <div class="col-md-10">
                        <input required value="{{old('name')}}" name="name" class="form-control" type="search">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="html5-email-input" class="col-md-2 col-form-label">Country <x-required/></label>
                    <div class="col-md-10">
                        <select required name="country_id" class="form-select select-2" id="countriesId" aria-label="Default select example">
                            <option value="">Select</option>
                            @foreach($countries as $county)
                                <option @if(old('country_id' == $county->id)) selected @endif value="{{$county->id}}">{{$county->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="html5-email-input" class="col-md-2 col-form-label">Meal Price</label>
                    <div class="col-md-2 pe-1">
                        <input class="form-control" type="text" name="meal_price_code"  value="{{old('meal_price_code')}}" id="mealPriceCode">
                    </div>
                    <div class="col-md-8 ps-0">
                        <select  name="meal_price_id" class="form-select select-2" id="mealPriceId" aria-label="Default select example">
                            <option value="">Select</option>
                            @foreach($meal_prices as $meal_price)
                                <option @if(old('meal_price_id' == $meal_price->id)) selected @endif code="{{$meal_price->code}}" value="{{$meal_price->id}}">{{$meal_price->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="html5-url-input" class="col-md-2 col-form-label">Company Email</label>
                    <div class="col-md-10">
                        <input class="form-control" name="email" type="email"  value="{{old('email')}}" id="html5-url-input">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="html5-url-input" class="col-md-2 col-form-label">Company Phone</label>
                    <div class="col-md-10">
                        <input class="form-control" name="phone"  value="{{old('phone')}}" type="tel">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="html5-tel-input" class="col-md-2 col-form-label">Company Address</label>
                    <div class="col-md-10">
                        <input class="form-control"  type="text" name="address"  value="{{old('address')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="html5-password-input" class="col-md-2 col-form-label">Company Agent</label>
                    <div class="col-md-10">
                        <input class="form-control" name="agent_name"  value="{{old('agent_name')}}" type="password" >
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="html5-number-input" class="col-md-2 col-form-label">Agent Mobile</label>
                    <div class="col-md-10">
                        <input class="form-control" type="tel" name="agent_mobile"  value="{{old('agent_mobile')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Company Status</label>
                    <div class="col-md-10">
                        <div class="col-md">
                            <div class="form-check form-check-inline mt-1">
                                <input  @if(old('status') ) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input @if(!old('status')) checked @endif class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
                                <label class="form-check-label" for="inlineRadio2">Inactive</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mb-3 row">
                    <label for="html5-datetime-local-input" class="col-md-2 col-form-label"></label>
                    <button type="submit" class="btn btn-primary col-2">
                        Save
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-main-layout>

<script>
    let mealPriceId = $("#mealPriceId");
    $('#countriesId').on('change', function (){
        let code = $("#countriesId :selected").attr('code')
        console.log(code)
    })
    mealPriceId.on('change', function (){
        let code = $("#mealPriceId :selected").attr('code')
        $('#mealPriceCode').val(code)
    })

    let mealPriceTimeout = null;
    $('#mealPriceCode').on('keyup', function (){
        clearTimeout(mealPriceTimeout)
        $("#mealPriceId option[value='']").prop('selected', true);
        let code = $(this).val();

        mealPriceId.val("")
        $("#mealPriceId option").each(function () {
            let selected = $(this).attr('code');
            let selected_val = $(this).val();
            if (selected == code) {
                mealPriceId.val(selected_val);
            }
        });

        mealPriceTimeout = setTimeout(function (){
            mealPriceId.change();
        }, 500)


    })
</script>
