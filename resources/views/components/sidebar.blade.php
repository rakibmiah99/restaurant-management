
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img height="50px" src="{{asset('assets/logo.png')}}"/>
              </span>
{{--            <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span>--}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <x-menu-item url="" name="Dashboard"/>
        <x-menu-item-dropdown
            name="Company Management"
            :active="request()->segment(1) == 'company'"
            :child="[
                [
                    'active' => request()->segment(1) == 'company',
                    'url' => route('company'),
                    'name' => 'company'
                ]
            ]
        "/>
        <x-menu-item-dropdown
            name="Meal Management"
            :child="[
                [
                    'url' => 'd',
                    'name' => 'Meal Price'
                ]
            ]
        "/>

        <x-menu-item-dropdown
            name="Hotel Management"
            :child="[
                [
                    'url' => 'd',
                    'name' => 'Hotel'
                ],
                [
                    'url' => 'd',
                    'name' => 'Hall'
                ],
            ]
        "/>

        <x-menu-item-dropdown
            name="Order Management"
            :child="[
                [
                    'url' => 'd',
                    'name' => 'Orders'
                ],
                [
                    'url' => 'd',
                    'name' => 'Order Monitoring'
                ],
                [
                    'url' => 'd',
                    'name' => 'Complete Order'
                ],
                [
                    'url' => 'd',
                    'name' => 'Invoice'
                ],
            ]
        "/>


        <x-menu-item-dropdown
            name="Reports"
            :child="[
                [
                    'url' => 'd',
                    'name' => 'Hotel Report'
                ],
                [
                    'url' => 'd',
                    'name' => 'Hall Report'
                ],
                [
                    'url' => 'd',
                    'name' => 'Kitchen Report'
                ],
                [
                    'url' => 'd',
                    'name' => 'Revenue Report'
                ],
                [
                    'url' => 'd',
                    'name' => 'Order Report'
                ],
                [
                    'url' => 'd',
                    'name' => 'Invoice Report'
                ],
                [
                    'url' => 'd',
                    'name' => 'Packaging Report'
                ],
            ]
        "/>


        <x-menu-item-dropdown
            name="Settings"
            :child="[
                [
                    'url' => 'd',
                    'name' => 'Company Settings'
                ]
            ]
        "/>

        <x-menu-item-dropdown
            name="Roles Management"
            :child="[
                [
                    'url' => 'd',
                    'name' => 'Permission'
                ],
                [
                    'url' => 'd',
                    'name' => 'Roles'
                ]
            ]
        "/>

        <x-menu-item-dropdown
            name="Users Activity"
            :child="[
                [
                    'url' => 'd',
                    'name' => 'User Activity'
                ],
            ]
        "/>













        {{--<!-- Dashboard -->
        <li class="menu-item active">
            <a href="index.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Layouts</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-without-menu.html" class="menu-link">
                        <div data-i18n="Without menu">Without menu</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-without-navbar.html" class="menu-link">
                        <div data-i18n="Without navbar">Without navbar</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-container.html" class="menu-link">
                        <div data-i18n="Container">Container</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-fluid.html" class="menu-link">
                        <div data-i18n="Fluid">Fluid</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="layouts-blank.html" class="menu-link">
                        <div data-i18n="Blank">Blank</div>
                    </a>
                </li>
            </ul>
        </li>--}}




    </ul>
</aside>
<!-- / Menu -->
