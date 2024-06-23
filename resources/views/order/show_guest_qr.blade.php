<div class="d-flex flex-column align-items-center">
    {{$qr}}
    <h4 class="mt-2">{{__('page.ask_me_to_get_meal')}}</h4>
    <h3>{{$guest_name}}</h3>
    <a href="{{route('take_meal', $code)}}" class="btn-primary btn-sm">{{__('page.take_meal')}}</a>
</div>
