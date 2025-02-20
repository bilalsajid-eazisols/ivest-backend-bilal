<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head py-0 d-flex justify-content-center">
        <div class="nk-sidebar-brand">
            <a href="{{ route('dashboard') }}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('images/HeaderLogo.png') }}"
                    srcset="{{ asset('images/HeaderLogo.png') }} 2x" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('images/HeaderLogo.png') }}"
                    srcset="{{ asset('images/HeaderLogo.png') }} 2x" alt="logo-dark">
            </a>
        </div>
        <div class="nk-menu-trigger me-n2"><a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none"
                data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a></div>
    </div>
    <div class="nk-sidebar-element ">
        <div class="nk-sidebar-body" data-simplebar>
            <div class="nk-sidebar-content">
                <div class="nk-sidebar-menu pt-2">
                    <ul class="nk-menu">
                        <li class="nk-menu-item"><a href="{{ route('dashboard') }}" class="nk-menu-link"><span
                                    class="nk-menu-icon"><em class="icon ni ni-cc-new"></em></span><span
                                    class="nk-menu-text">Dashboard</span></a></li>

                        <li class="nk-menu-item has-sub"><a href="#" class="nk-menu-link nk-menu-toggle"><span
                                    class="nk-menu-icon"><em class="icon ni ni-user"></em></span><span
                                    class="nk-menu-text">User Managment</span></a>
                            <ul class="nk-menu-sub">

                                @can('user_view')
                                    <li class="nk-menu-item"><a href="{{ route('users') }}" class="nk-menu-link"><span
                                                class="nk-menu-text">
                                                Customers
                                            </span></a></li>
                                    <li class="nk-menu-item"><a href="{{ route('uscitizen') }}" class="nk-menu-link"><span
                                                class="nk-menu-text">
                                                USA Citizen
                                            </span></a></li>
                                @endcan





                                @can('staff_view')
                                    <li class="nk-menu-item"><a href="{{ route('staff') }}" class="nk-menu-link"><span
                                                class="nk-menu-text">
                                                Staff
                                            </span></a></li>
                                @endcan

                                @can('role_view')
                                    <li class="nk-menu-item"><a href="{{ url('admin/roles') }}" class="nk-menu-link"><span
                                                class="nk-menu-text">
                                                Roles & Permission
                                            </span></a></li>
                                @endcan
                                @can('kyc_view')
                                    <li class="nk-menu-item"><a href="{{ route('kyc') }}" class="nk-menu-link"><span
                                                class="nk-menu-text">
                                                Kyc
                                            </span></a></li>
                                @endcan

                            </ul>
                        </li>
                        @can('membershipclub_view')
                            <li class="nk-menu-item"><a href="{{ route('membershipclubs') }}"
                                    class="nk-menu-link"><span class="nk-menu-icon"><em
                                            class="icon ni ni-view-grid-fill"></em></span><span
                                        class="nk-menu-text">Membership Club</span></a></li>
                        @endcan
                        @can('blog_view')
                            <li class="nk-menu-item"><a href="{{ route('blogs') }}" class="nk-menu-link"><span
                                        class="nk-menu-icon"><em class="icon ni ni-text-rich"></em></span><span
                                        class="nk-menu-text">Blogs</span></a></li>
                            <li class="nk-menu-item"><a href="{{ route('news') }}" class="nk-menu-link"><span
                                        class="nk-menu-icon"><em class="icon ni ni-article"></em></span><span
                                        class="nk-menu-text">News</span></a></li>
                        @endcan


                        @can('category_view')
                            <li class="nk-menu-item"><a href="{{ route('newscategories') }}" class="nk-menu-link"><span
                                        class="nk-menu-icon"><em class="icon ni ni-layer-fill"></em></span><span
                                        class="nk-menu-text">Categories</span></a></li>
                        @endcan

                        @can('setting_view')
                            <li class="nk-menu-item"><a href="{{ route('adminsetting') }}" class="nk-menu-link"><span
                                        class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span><span
                                        class="nk-menu-text">Setting</span></a></li>
                        @endcan

                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
