<form class="d-flex px-2 justify-content-between" id="search-form">
    <div class="d-flex align-items-center">
        <select name="perpage" onchange="$('#search-form').trigger('submit')" style="width: 150px" class="form-select form-select-sm">
            <option @if(request()->perpage == 10) selected @endif value="10">10</option>
            <option @if(request()->perpage == 30) selected @endif value="30">30</option>
            <option @if(request()->perpage == 50) selected @endif value="50">50</option>
            <option @if(request()->perpage == 100) selected @endif value="100">100</option>
        </select>
        <a
            href="{{route($attributes->get('export-url'), array_merge(request()->all(), ['export-type' => 'pdf']))}}"
            type="button"
            class="btn btn-sm btn-icon ms-2 btn-outline-danger "
        >
            <i class='bx bxs-file-pdf'></i>
        </a>
        <a
            href="{{route($attributes->get('export-url'), array_merge(request()->all(), ['export-type' => 'excel']))}}"
            type="button" class="btn btn-icon btn-sm ms-2 btn-outline-success "
        >
            <i class='bx bx-spreadsheet' ></i>
        </a>


        <div class="dropdown">
            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary ms-2 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-data'></i>
            </button>
            <ul class="dropdown-menu" style="">
                @foreach($attributes->get('columns') as $column)
                    <li>
                        <div class="dropdown-item">
                            <input name="columns[]" @if(in_array($column, request()->columns ?? $attributes->get('columns'))) checked @endif class="form-check-input" value="{{$column}}" type="checkbox" id="{{$column}}">
                            <label class="form-check-label" for="{{$column}}"> {{__($attributes->get('translate-from').".".$column)}} </label>
                        </div>
                    </li>
                @endforeach
                <li class="dropdown-item">
                    <input type="submit" value="filter" class="btn d-block btn-sm btn-primary"/>
                </li>
            </ul>
        </div>



    </div>

    <!-- searchData function in main layout script -->
    <input value="{{request()->q}}" name="q" onkeyup="searchData()" style="width: 150px" id="searchInput" class="form-control d-inline form-control-sm" type="text" placeholder="search">

    @foreach(request()->except(['perpage', 'columns', 'q']) as $input_name=>$value)
        <input type="hidden" name="{{$input_name}}" value="{{$value}}"/>
    @endforeach

</form>
