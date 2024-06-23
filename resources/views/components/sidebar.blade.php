@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
    $segment3 = request()->segment(3);
@endphp
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
            :active="$segment1 == 'company'"
            :child="[
                [
                    'active' => $segment1 == 'company',
                    'url' => route('company.index'),
                    'name' => __('menu.company')
                ]
            ]
        "/>
        <x-menu-item-dropdown
            :name="__('menu.meal_management')"
            :active="$segment1 == 'meal-price'"
            :child="[
                [
                    'active' => $segment1 == 'meal-price',
                    'url' => route('meal_price.index'),
                    'name' => __('menu.meal_price')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('menu.hotel_management')"
            :active="$segment1 == 'hotel' || $segment1 == 'hall'"
            :child="[
                [
                    'active' => $segment1 == 'hotel',
                    'url' => route('hotel.index'),
                    'name' => __('menu.hotel')
                ],
                [
                    'active' => $segment1 == 'hall',
                    'url' => route('hall.index'),
                    'name' => __('menu.hall')
                ],
            ]
        "/>

        <x-menu-item-dropdown
            :name="__('menu.order_management')"
            :active="$segment1 == 'order' || $segment1 == 'order-monitoring' || $segment1 == 'complete-orders' "
            :child="[
                [
                    'active' => $segment1 == 'order',
                    'url' => route('order.index'),
                    'name' => __('menu.orders')
                ],
                [
                    'active' => $segment1 == 'order-monitoring',
                    'url' => route('order_monitoring.index'),
                    'name' => __('menu.order_monitoring')
                ],
                [
                    'active' => $segment1 == 'complete-orders',
                    'url' => route('order.complete'),
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
            :active="$segment1 == 'report'"
            :child="[
                [
                    'url' => route('report.hotel'),
                    'active' => $segment2 == 'hotel',
                    'name' => __('menu.hotel_report')
                ],
                [
                    'url' => route('report.hall'),
                    'active' => $segment2 == 'hall',
                    'name' => __('menu.hall_report')
                ],
                [
                    'url' => route('report.kitchen'),
                    'active' => $segment2 == 'kitchen',
                    'name' => __('menu.kitchen_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.revenue_report')
                ],
                [
                    'url' => route('report.order'),
                    'active' => $segment2 == 'order',
                    'name' => __('menu.order_report')
                ],
                [
                    'url' => 'd',
                    'name' => __('menu.invoice_report')
                ],
                [
                    'url' => route('report.packaging'),
                    'active' => $segment2 == 'packaging',
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
