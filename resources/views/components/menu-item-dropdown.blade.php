@if($attributes->get('visibility'))
    <!-- Layouts -->
    <li class="menu-item {{$attributes->get('active') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bi {{$attributes->get('bi-icon')}}"></i>
            <div data-i18n="Layouts">{{$attributes->get('name')}}</div>
        </a>

        <ul class="menu-sub">
            @foreach($attributes->get('child') as $item)
                @if(key_exists('visibility', $item) && $item['visibility'])
                    <li class="menu-item {{ array_key_exists('active', $item) && $item['active'] ? 'active' : ''}}">
                        <a href="{{$item['url']}}" class="menu-link">
                            <div data-i18n="Without menu">{{$item['name']}}</div>
                        </a>
                    </li>
                @endif

            @endforeach
        </ul>
    </li>
@endif
