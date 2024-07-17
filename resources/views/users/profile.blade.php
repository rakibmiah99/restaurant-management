@php $user = auth()->user(); @endphp

<x-main-layout :title="__('page.my_profile')">
    <div class="p-4">
        <div class="card">
            <x-card-header :can-create="false" :name="__('page.profile')" :url="route('user.index')" :url-name="__('page.back')"/>
            <form enctype="multipart/form-data" action="{{route('profile.update')}}" method="post" class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <x-input
                            :title="__('page.name')"
                            name="name"
                            type="text"
                            :required="true"
                            :value="$user->name"
                        />
                    </div>

                    <div class="col-md-12">
                        <x-input
                            :title="__('page.email')"
                            name="email"
                            type="email"
                            :disabled="true"
                            :required="false"
                            :value="$user->email"
                        />
                    </div>

                    <div class="col-md-12">
                        <x-input
                            :title="__('page.phone')"
                            name="phone"
                            type="text"
                            :required="false"
                            :value="$user->phone"
                        />
                    </div>

                    <div class="col-md-12">
                        <x-input
                            :title="__('page.location')"
                            name="location"
                            type="text"
                            :required="false"
                            :value="$user->location"
                        />
                    </div>

                    <div class="col-md-12">
                        <x-input
                            :title="__('page.website')"
                            name="website"
                            type="text"
                            :required="false"
                            :value="$user->website"
                        />
                    </div>

                    <div class="col-md-12">
                        <x-input
                            :title="__('page.image')"
                            name="file"
                            type="file"
                            :required="false"
                        />
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <img class="img-thumbnail img-thumbnail-shadow" width="200px"  src="{{auth()->user()->image}}"/>
                            </div>
                        </div>
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
