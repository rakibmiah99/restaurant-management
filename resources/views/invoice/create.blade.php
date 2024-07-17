<x-main-layout :title="__('menu.invoice')">
    <div class="p-4">
        <div class="card">
            <x-card-header :name="__('page.invoices')" :url="route('invoice.index')" :url-name="__('page.back')"/>
            <form action="{{route('invoice.store', $order?->id)}}" method="post" class="card-body">
                @csrf
                @include('invoice.form_data')

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

@include('company.common_script')
