@if($attributes->get('data-length') === 0)
    <div class="h-100 w-100 text-center mt-5">
        <i class="bi bi-database me-1 d-inline-block"></i>
        <b>{{__('page.no_data_found')}}</b>
    </div>
@endif
