<div class="card" style="height: calc(100vh - 200px)">
    <div class="card-body d-flex flex-column justify-content-center align-items-center">
        <h1 class="text-center text-uppercase text-primary">{{__('page.this_order_was_modified')}}</h1>
        <h5 class="text-center">{{__('page.do_you_want_to_update')}}</h5>
        <div class="mt-2">
            <a href="{{route('order.edit', $order->id)}}?{{\App\Enums\OrderEditTypeEnum::KEY->value}}={{\App\Enums\OrderEditTypeEnum::WITH_OUT_MEAL->value}}" class="btn btn-primary">
                {{__('page.with_out_meal_system')}} ?
            </a>
            <a href="{{route('order.edit', $order->id)}}?{{\App\Enums\OrderEditTypeEnum::KEY->value}}={{\App\Enums\OrderEditTypeEnum::WITH_MEAL->value}}" class="btn ms-2 btn-danger">
                {{__('page.with_meal_system')}} ?
            </a>
        </div>
    </div>
</div>
