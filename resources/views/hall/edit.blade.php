@php $is_edit = request()->segment(2) == "edit"  @endphp
<x-main-layout>
    <div class="p-4">
        <div class="card">
            <x-card-header :name="__('page.hotels')" :url="route('hotel.index')" :url-name="__('page.back')"/>
            <form action="{{route('hotel.update', request()->id)}}" method="post" c class="card-body">
                @csrf

                @include('hotel.form_data', compact('is_edit'))

                <div class="mb-3 row">
                    <label for="html5-datetime-local-input" class="col-md-2 col-form-label"></label>
                    <button type="submit" class="btn btn-primary col-2">
                        {{__('page.save')}}
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-main-layout>
