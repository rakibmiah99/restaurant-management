@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
    $segment3 = request()->segment(3);
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{route('home')}}" class="app-brand-link">
          <span class="app-brand-logo demo">
            <img height="50px" src="{{\App\Models\CompanySetting::first()?->image ?? asset('assets/logo.png')}}"/>
          </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <x-menu-item icon="bx bx-grid-alt bx-sm" :url="route('home')" :name="__('menu.dashboard')"/>
        <x-menu-item-dropdown
            bi-icon="bi-window"
            :visibility="\App\Helper::HasPermissionMenu('company')"
            :name="__('menu.company_management')"
            :active="$segment1 == 'company'"
            :child="[
                [
                    'visibility' => \App\Helper::HasPermissionMenu('company', 'view'),
                    'active' => $segment1 == 'company',
                    'url' => route('company.index'),
                    'name' => __('menu.company')
                ]
            ]
        "/>
        <x-menu-item-dropdown
            bi-icon="bi-cookie"
            :visibility="\App\Helper::HasPermissionMenu('meal_price')"
            :name="__('menu.meal_management')"
            :active="$segment1 == 'meal-price'"
            :child="[
                [
                    'visibility' => \App\Helper::HasPermissionMenu('meal_price', 'view'),
                    'active' => $segment1 == 'meal-price',
                    'url' => route('meal_price.index'),
                    'name' => __('menu.meal_price')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            bi-icon="bi-building-gear"
            :name="__('menu.hotel_management')"
            :active="$segment1 == 'hotel' || $segment1 == 'hall'"
            :visibility="\App\Helper::HasPermissionMenu('hotel') || \App\Helper::HasPermissionMenu('hall')"
            :child="[
                [
                    'visibility' => \App\Helper::HasPermissionMenu('hotel', 'view'),
                    'active' => $segment1 == 'hotel',
                    'url' => route('hotel.index'),
                    'name' => __('menu.hotel')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('hall', 'view'),
                    'active' => $segment1 == 'hall',
                    'url' => route('hall.index'),
                    'name' => __('menu.hall')
                ],
            ]
        "/>

        <x-menu-item-dropdown
            bi-icon="bi-list-check"
            :name="__('menu.order_management')"
            :visibility="\App\Helper::HasPermissionMenu('order') || \App\Helper::HasPermissionMenu('invoice')"
            :active="$segment1 == 'order' || $segment1 == 'order-monitoring' || $segment1 == 'complete-orders' || $segment1 == 'invoice' "
            :child="[
                [
                    'visibility' => \App\Helper::HasPermissionMenu('order', 'view'),
                    'active' => $segment1 == 'order',
                    'url' => route('order.index'),
                    'name' => __('menu.orders')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('order', 'monitoring'),
                    'active' => $segment1 == 'order-monitoring',
                    'url' => route('order_monitoring.index'),
                    'name' => __('menu.order_monitoring')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('order', 'complete_order'),
                    'active' => $segment1 == 'complete-orders',
                    'url' => route('order.complete'),
                    'name' => __('menu.complete_order')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('invoice', 'view'),
                    'active' => $segment1 == 'invoice',
                    'url' => route('invoice.index'),
                    'name' => __('menu.invoice')
                ],
            ]
        "/>


        <x-menu-item-dropdown
            bi-icon="bi-graph-up-arrow"
            :name="__('menu.reports')"
            :active="$segment1 == 'report'"
            :visibility="\App\Helper::HasPermissionMenu('report')"
            :child="[
                [
                    'visibility' => \App\Helper::HasPermissionMenu('report', 'hotel'),
                    'url' => route('report.hotel'),
                    'active' => $segment2 == 'hotel',
                    'name' => __('menu.hotel_report')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('report', 'hall'),
                    'url' => route('report.hall'),
                    'active' => $segment2 == 'hall',
                    'name' => __('menu.hall_report')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('report', 'kitchen'),
                    'url' => route('report.kitchen'),
                    'active' => $segment2 == 'kitchen',
                    'name' => __('menu.kitchen_report')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('report', 'revenue'),
                    'url' => route('report.revenue'),
                    'active' => $segment2 == 'revenue',
                    'name' => __('menu.revenue_report')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('report', 'order'),
                    'url' => route('report.order'),
                    'active' => $segment2 == 'order',
                    'name' => __('menu.order_report')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('report', 'invoice'),
                    'url' => route('report.invoice'),
                    'active' => $segment2 == 'invoice',
                    'name' => __('menu.invoice_report')
                ],
                [
                    'visibility' => \App\Helper::HasPermissionMenu('report', 'packaging'),
                    'url' => route('report.packaging'),
                    'active' => $segment2 == 'packaging',
                    'name' => __('menu.packaging_report')
                ],
            ]
        "/>


        <x-menu-item-dropdown
            bi-icon="bi-gear"
            :visibility="\App\Helper::HasPermissionMenu('settings')"
            :name="__('menu.settings')"
            :active="$segment1 == 'company-settings'"
            :child="[
                [
                    'visibility' => \App\Helper::HasPermissionMenu('settings', 'update'),
                    'url' => route('settings.company'),
                    'active' => $segment1 == 'company-settings',
                    'name' => __('menu.company_settings')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            bi-icon="bi-braces-asterisk"
            :visibility="\App\Helper::HasPermissionMenu('role')"
            :name="__('menu.roles_management')"
            :active="$segment1 == 'roles'"
            :child="[
               /* [
                    'url' => 'd',
                    'name' => __('menu.permission')
                ],*/
                [
                    'visibility' => \App\Helper::HasPermissionMenu('role', 'view'),
                    'url' => route('role.index'),
                    'active' => $segment1 == 'roles',
                    'name' => __('menu.roles')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            bi-icon="bi-people"
            :visibility="\App\Helper::HasPermissionMenu('user')"
            :name="__('menu.users_management')"
            :active="$segment1 == 'users'"
            :child="[
               /* [
                    'url' => 'd',
                    'name' => __('menu.permission')
                ],*/
                [
                    'visibility' => \App\Helper::HasPermissionMenu('user', 'view'),
                    'url' => route('user.index'),
                    'active' => $segment1 == 'users',
                    'name' => __('menu.users')
                ]
            ]
        "/>

        <x-menu-item-dropdown
            bi-icon="bi-activity"
            :visibility="\App\Helper::HasPermissionMenu('vvv')"
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
