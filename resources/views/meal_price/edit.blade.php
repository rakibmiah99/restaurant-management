@php $is_edit = request()->segment(2) == "edit"  @endphp
<x-main-layout :title="__('menu.meal_price')">
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="true" :name="__('page.meal_price')" :url="route('meal_price.index')" :url-name="__('page.back')"/>
            <form action="{{route('meal_price.update', request()->id)}}" method="post" class="card-body">
                @csrf

                @include('meal_price.form_data', compact('is_edit'))

                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        {{__('page.save')}}
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-main-layout>
