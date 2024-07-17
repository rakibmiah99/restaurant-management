@php
    $size = $attributes->get('size');
    $title = $attributes->get('title');
@endphp

<div class="modal" id="viewModal">
    <div class="modal-dialog {{$size ?? 'modal-md'}}">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{$title ?? __('page.details')}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="modal-loader" class="text-center">
                    <div class="spinner-border spinner-border-md text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                {{$slot}}
            </div>

        </div>
    </div>
</div>
