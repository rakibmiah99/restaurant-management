
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
                    'url' => route('company.index'),
                    'name' => __('menu.company')
                ]
            ]
        "/>
        <x-menu-item-dropdown
            :name="__('menu.meal_management')"
            :active="request()->segment(1) == 'meal-price'"
            :child="[
                [
                    'active' => request()->segment(1) == 'meal-price',
                    'url' => route('meal_price.index'),
                    'name' => __('menu.meal_price')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('menu.hotel_management')"
            :active="request()->segment(1) == 'hotel' || request()->segment(1) == 'hall'"
            :child="[
                [
                    'active' => request()->segment(1) == 'hotel',
                    'url' => route('hotel.index'),
                    'name' => __('menu.hotel')
                ],
                [
                    'active' => request()->segment(1) == 'hall',
                    'url' => route('hall.index'),
                    'name' => __('menu.hall')
                ],
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('menu.order_management')"
            :active="request()->segment(1) == 'order'"
            :child="[
                [
                    'active' => request()->segment(1) == 'order',
                    'url' => route('order.index'),
                    'name' => __('menu.orders')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.order_monitoring')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.complete_order')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.invoice')
                ],
            ]
        "/>


        <x-menu-item-dropdown
            :name="__('menu.reports')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('menu.hotel_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.hall_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.kitchen_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.revenue_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.order_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.invoice_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.packaging_report')
                ],
            ]
        "/>


        <x-menu-item-dropdown
            :name="__('menu.settings')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('menu.company_settings')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('menu.roles_management')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('menu.permission')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.roles')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('menu.user_activity')"
            :child="[
                [
                    'url' => 'd',
                    'name' => __('menu.user_activity')
                ],
            ]
        "/>




    </ul>
</aside>
<!-- / Menu -->
