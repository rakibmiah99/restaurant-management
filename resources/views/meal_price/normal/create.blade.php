<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :name="__('page.meal_price')" :url="route('meal_price.index')" :url-name="__('page.back')"/>
            <form action="{{route('meal_price.store')}}" method="post" c class="card-body">
                @csrf
                @include('meal_price.form_data')

                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        {{__('page.save')}}
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-main-layout>

@include('company.common_script')
