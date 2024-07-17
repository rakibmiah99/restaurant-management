<x-main-layout :title="__('menu.orders')">
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="true" :name="__('page.orders')" :url="route('order.index')" :url-name="__('page.back')"/>
        </div>

        <h1 class="text-center fw-bold text-uppercase mt-5 text-primary">{{__('page.chose_one')}}</h1>


        <div class="row  mt-5">
            <div class="col-md-4">
                <a href="{{route('order.create', ['order-type' => \App\Enums\OrderType::NORMAL->value])}}" class="card row flex-row rounded-2 meal-price-card g-0">
                    <div class="col-md-4">
                        <img style="height: 100px" class="card-img rounded-2 card-img-right" src="{{asset('assets/img/order3.png')}}" alt="Card image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex  align-items-center h-100">
                            <h3 class="card-title text-uppercase m-0 ps-3">{{__('page.normal')}}</h3>

                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{route('order.create', ['order-type' => \App\Enums\OrderType::RAMADAN->value])}}" class="card row flex-row rounded-2 meal-price-card g-0">
                    <div class="col-md-4">
                        <img style="height: 100px" class="card-img rounded-2 card-img-right" src="{{asset('assets/img/order3.png')}}" alt="Card image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex align-items-center h-100">
                            <h3 class="card-title text-uppercase m-0 ps-3" >{{__('page.ramadan')}}</h3>
                        </div>
                    </div>

                </a>
            </div>
            <div class="col-md-4">
                <a href="{{route('order.create', ['order-type' => \App\Enums\OrderType::BOTH->value])}}" class="card row flex-row rounded-2 meal-price-card g-0">
                    <div class="col-md-4">
                        <img style="height: 100px" class="card-img rounded-2 card-img-right"  src="{{asset('assets/img/order3.png')}}" alt="Card image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex align-items-center h-100">
                            <h3 class="card-title text-uppercase m-0 ps-3">{{__('page.both_order')}}</h3>
                        </div>
                    </div>

                </a>
            </div>

        </div>
    </div>


</x-main-layout>
