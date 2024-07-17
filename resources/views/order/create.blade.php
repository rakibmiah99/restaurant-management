<x-main-layout :title="__('menu.orders')">
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="true" :name="__('page.orders')" :url="route('order.index')" :url-name="__('page.back')"/>
            <form action="{{route('order.store')}}" method="post" class="card-body">
                @csrf
                @include('order.form_data')

                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        {{__('page.save')}}
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-main-layout>

