<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="true" :name="__('page.meal_price')" :url="route('meal_price.index')" :url-name="__('page.back')"/>
        </div>

        <h1 class="text-center fw-bold text-uppercase mt-5">{{__('page.chose_one')}}</h1>


        <div class="row  mt-5">
            <div class="col-md-6">
                <a href="{{route('meal_price.create', ['meal-type' => \App\MealSystemType::NORMAL->value])}}" class="card row flex-row rounded-2 meal-price-card g-0 ">
                    <div class="col-md-4">
                        <img class="card-img rounded-2 card-img-right" style="height: 180px" src="{{asset('assets/img/normal.jpg')}}" alt="Card image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex justify-content-center align-items-center h-100">
                            <h1 class="card-title text-uppercase">{{__('page.normal_day')}}</h1>

                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{route('meal_price.create', ['meal-type' => \App\MealSystemType::RAMADAN->value])}}" class="card row flex-row rounded-2 meal-price-card g-0">
                    <div class="col-md-4">
                        <img class="card-img rounded-2 card-img-right" style="height: 180px" src="{{asset('assets/img/ramadan.jpg')}}" alt="Card image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex justify-content-center align-items-center h-100">
                            <h1 class="card-title text-uppercase" >{{__('page.ramadan_day')}}</h1>

                        </div>
                    </div>

                </a>
            </div>

        </div>
    </div>


</x-main-layout>
