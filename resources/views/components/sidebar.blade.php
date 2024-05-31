
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

        <x-menu-item url="" :name="__('dashboard')"/>
        <x-menu-item-dropdown
            :name="__('menu.company_management')"
            :active="request()->segment(1) == 'company'"
            :child="[
                [
                    'active' => request()->segment(1) == 'company',
                    'url' => route('company'),
                    'name' => __('company')
                ]
            ]
        "/>
        <x-menu-item-dropdown
            :name="__('meal_management')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('meal_price')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('hotel_management')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('hotel')
                ],
                [
                    'url' => 'd',
                    'name' => __('hall')
                ],
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('order_management')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('orders')
                ],
                [
                    'url' => 'd',
                    'name' => __('order_monitoring')
                ],
                [
                    'url' => 'd',
                    'name' => __('complete_order')
                ],
                [
                    'url' => 'd',
                    'name' => __('invoice')
                ],
            ]
        "/>


        <x-menu-item-dropdown
            :name="__('reports')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('hotel_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('hall_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('kitchen_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('revenue_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('order_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('invoice_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('packaging_report')
                ],
            ]
        "/>


        <x-menu-item-dropdown
            :name="__('settings')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('company_settings')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('roles_management')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('permission')
                ],
                [
                    'url' => 'd',
                    'name' => __('roles')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('user_activity')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('user_activity')
                ],
            ]
        "/>




    </ul>
</aside>
<!-- / Menu -->
