@php $is_edit = request()->segment(2) ?? false  @endphp
<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="true" :name="__('page.orders')" :url="route('order.index')" :url-name="__('page.back')"/>
            @if($order->is_modified && !request()->get(\App\Enums\OrderEditTypeEnum::KEY->value))
                @include('order.is_modified')
            @else
                <form action="{{route('order.update', request()->id)}}" method="post" class="card-body">
                    @csrf
                    <input type="hidden" name="{{\App\Enums\OrderEditTypeEnum::KEY->value}}" value="{{request()->get(\App\Enums\OrderEditTypeEnum::KEY->value)}}" />
                    @include('order.form_data', compact('is_edit'))

                    <div class="mb-3 row">
                        <label for="html5-datetime-local-input" class="col-md-2 col-form-label"></label>
                        <button type="submit" class="btn btn-primary col-2">
                            {{__('page.save')}}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-main-layout>
