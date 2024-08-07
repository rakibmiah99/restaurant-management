<x-main-layout :title="__('menu.company_settings')">
    <div class="p-4">
        <div class="card">
            <x-card-header :name="__('page.company_settings')" :url="route('settings.company')" :url-name="__('page.back')"/>
            <form enctype="multipart/form-data" action="{{route('settings.company.update')}}" method="post"  class="card-body">
                @csrf
                <x-input
                    :title="__('page.company_name')"
                    name="company_name"
                    type="text"
                    :required="true"
                    :value="$settings?->company_name"
                />

                <x-input
                    :title="__('page.company_phone')"
                    name="company_phone"
                    type="text"
                    :required="true"
                    :readonly="false"
                    :value="$settings?->company_phone"
                />

                <x-input
                    :title="__('page.company_email')"
                    name="company_email"
                    type="email"
                    :required="true"
                    :value="$settings?->company_email"
                />
                <x-input
                    :title="__('page.company_website')"
                    name="company_website"
                    type="text"
                    :required="true"
                    :value="$settings?->company_website"
                />

                <x-input
                    :title="__('page.company_address')"
                    name="company_address"
                    type="text"
                    :required="true"
                    :value="$settings?->company_address"
                />

                <x-input
                    :title="__('page.tax')"
                    name="tax"
                    type="numeric"
                    :required="true"
                    :value="$settings?->tax"
                />
                <x-input
                    :title="__('page.how_long_hours_order_will_editing_be_unavailable')"
                    name="order_can_edit_before"
                    type="numeric"
                    :required="true"
                    :value="$settings?->order_can_edit_before"
                />

                <div class="col-md-12">
                    <x-input
                        :title="__('page.image')"
                        name="file"
                        type="file"
                        :required="false"
                    />
                </div>



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

