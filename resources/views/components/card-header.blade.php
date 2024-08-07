<div class="d-flex pe-4 justify-content-between align-items-center">
    <h5 class="card-header">{{$attributes->get('name')}}</h5>

    <div>
        {{$slot}}
    </div>

    @if($attributes->get('can-create'))
        <a href="{{$attributes->get('url')}}" type="button" class="btn btn-sm btn-primary">
            {{$attributes->get('url-name')}}
        </a>
    @endif


</div>
<hr class="m-0">
