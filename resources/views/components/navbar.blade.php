<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar"
>
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                />
            </div>
        </div>
        <!-- /Search -->





        <div class="ms-auto d-flex align-items-center">
            <div  class="btn-group lang-btn d-inline me-3">
                <button type="button" class="btn btn-outline-primary rounded-0 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(app()->getLocale() == 'en')
                        <img height="15px"  class="me-2 d-inline-block" src="{{asset('/assets/us.jpg')}}"/>
                        <span>ENGLISH</span>
                    @elseif(app()->getLocale() == 'ar')
                        <img height="15px" class="mr-2 me-2" src="{{asset('/assets/ar.png')}}"/>
                        <span>ARABIC</span>
                    @endif
                </button>
                <ul class="dropdown-menu" style="">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('lang.change', 'en')}}">
                            <img height="15px"  class="me-2 d-inline-block" src="{{asset('/assets/us.jpg')}}"/>
                            <span>ENGLISH</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('lang.change', 'ar')}}">
                            <img height="15px" class="mr-2 me-2" src="{{asset('/assets/ar.png')}}"/>
                            <span>ARABIC</span>
                        </a>
                    </li>

                </ul>
            </div>


            <div class="nav-item dropdown-style-switcher dropdown me-3">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(session('theme') == \App\Enums\Theme::LIGHT->value)
                        <i class="bx bx-sm bx-sun"></i>
                    @else
                        <i class="bx bx-sm bx-moon"></i>
                    @endif

                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="{{route('theme.change', \App\Enums\Theme::LIGHT->value)}}" data-theme="light">
                            <span class="align-middle"><i class="bx bx-sun me-2"></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('theme.change', \App\Enums\Theme::DARK->value)}}" data-theme="dark">
                            <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
                        </a>
                    </li>
{{--                    <li>--}}
{{--                        <a class="dropdown-item" href="{{route('theme.change', \App\Enums\Theme::SYSTEM->value)}}" data-theme="system">--}}
{{--                            <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
            </div>

            <ul class="navbar-nav  flex-row align-items-center">
                <!-- Place this tag where you want the button to render. -->


                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{asset('assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{asset('assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">John Doe</span>
                                        <small class="text-muted">Admin</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('logout')}}">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!--/ User -->
            </ul>
        </div>


    </div>
</nav>
