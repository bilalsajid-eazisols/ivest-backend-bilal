<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ms-n1"><a href="#" class="nk-nav-toggle nk-quick-nav-icon"
                    data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a></div>
            <div class="nk-header-brand d-xl-none"><a href="index.html" class="logo-link"><img class="logo-light logo-img"
                        src="{{ asset('images/HeaderLogo.png') }}" srcset="{{ asset('images/HeaderLogo.png') }} 2x"
                        alt="logo">
                    <img class="logo-dark logo-img" src="{{ asset('images/HeaderLogo.png') }}"
                        srcset="{{ asset('images/HeaderLogo.png') }} 2x" alt="logo-dark"></a></div>

            <div class="nk-header-tools">
                <ul class="nk-quick-nav">

                    <li class="dropdown user-dropdown"><a href="#" class="dropdown-toggle"
                            data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm"><img src="{{ Auth::user()->profileImage() }}"
                                        alt="Profile">
                                </div>
                                <div class="user-info d-none d-md-block">
                                    <div class="user-status">{{ Auth::user()->username }}</div>
                                    <div class="user-name dropdown-indicator">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar"><img src="{{ Auth::user()->profileImage() }}"
                                            alt="profile"></div>
                                    <div class="user-info"><span
                                            class="lead-text">{{ Auth::user()->username }}</span><span
                                            class="sub-text">{{ Auth::user()->email }}</span></div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{route('profile')}}"><em
                                                class="icon ni ni-user-alt"></em><span>View
                                                Profile</span></a></li>
                                                <li><a href="{{route('changepassword')}}"><em class="icon ni ni-security"></em><span>Update Password</span></a></li>

                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>

                                        <form action="{{ route('adminlogout') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                style="display: flex;
                                                     align-items: center;
                                                       color: #526484;
                                                       font-size: 13px;
                                                          line-height: 1.4rem;
                                                         font-weight: 500;
                                                          padding: .575rem 0;
                                                           position: relative;
                                                          background:none;
                                                         border:none;
                                                       justify-content:space-around
                                                           ">
                                                <em class="icon ni ni-signout me-2"></em>
                                                Sign Out</button>
                                        </form>


                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown notification-dropdown me-n1">
                        <a href="#"
                            class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                            @if(Auth::user()->unreadNotifications()->exists())
                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em>
                            </div>
                            @else
                            <em class="icon ni ni-bell"></em>
                            @endif

                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                            <div class="dropdown-head"><span class="sub-title nk-dropdown-title">Notifications</span><a
                                    href="{{route('markasread')}}">Mark All as Read</a></div>
                            <div class="dropdown-body">
                                <div class="nk-notification">

                                        @foreach (Auth::user()->notifications as $notification)
                                       @if ($notification->read_at == null)
                                       <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon"><em
                                                class="icon icon-circle  ni ni-curve-down-right"></em>
                                        </div>

                                             <div class="nk-notification-content">
                                                <div class="nk-notification-text">{{ $notification->data['message'] }}</span>
                                                </div>
                                                <div class="nk-notification-time">{{$notification->created_at->diffForHumans()}}</div>
                                            </div>
                                        </div>
                                       @endif

                                                @endforeach



                                </div>
                            </div>
                            {{-- <div class="dropdown-foot center"><a href="#">View All</a></div> --}}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
