@php $user = auth()->user(); @endphp

<x-main-layout :title="__('page.my_profile')">
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="false" :name="__('page.change_password')" :url="route('user.index')" :url-name="__('page.back')"/>
            <form action="{{route('profile.change_password')}}" method="post" class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <x-input
                            :title="__('page.old_password')"
                            name="old_password"
                            type="text"
                            value=""
                            :required="true"
                        />
                    </div>

                    <div class="col-md-12">
                        <x-input
                            :title="__('page.new_password')"
                            name="new_password"
                            value=""
                            type="text"
                            :required="true"
                        />
                    </div>

                    <div class="col-md-12">
                        <x-input
                            :title="__('page.confirm_password')"
                            name="confirm_new_password"
                            value=""
                            type="text"
                            :required="true"
                        />
                    </div>
                </div>


                <div class="my-3 row">
                    <label for="html5-datetime-local-input" class="col-md-2 col-form-label"></label>
                    <button type="submit" class="btn btn-primary col-2">
                        {{__('page.save')}}
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-main-layout>
