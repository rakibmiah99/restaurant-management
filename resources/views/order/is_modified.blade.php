<div class="card" style="height: calc(100vh - 200px)">
    <div class="card-body d-flex flex-column justify-content-center align-items-center">
        <h1 class="text-center text-uppercase text-primary">This Order Was Modified!</h1>
        <h5 class="text-center">Do you want to update</h5>
        <div class="mt-2">
            <a href="{{route('order.edit', $order->id)}}?{{\App\Enums\OrderEditTypeEnum::KEY->value}}={{\App\Enums\OrderEditTypeEnum::WITH_OUT_MEAL->value}}" class="btn btn-primary">
                Without Meal System ?
            </a>
            <a href="{{route('order.edit', $order->id)}}?{{\App\Enums\OrderEditTypeEnum::KEY->value}}={{\App\Enums\OrderEditTypeEnum::WITH_MEAL->value}}" class="btn ms-2 btn-danger">
                With Meal System ?
            </a>
        </div>
    </div>
</div>
