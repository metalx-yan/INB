<aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- User profile -->
            <div class="user-profile">
                <!-- User profile image -->
                <div class="profile-img"> <img src=" /images/profile/{{ Auth::user()->avatar }}" alt="user" /> </div>
                <!-- User profile text-->
                <br>
                <div class="profile-text"> <a href="#"  role="button" aria-haspopup="true" aria-expanded="true">{{ ucfirst(Auth::user()->name) }}<span class="caret"></span></a>
                    <br>
                    {!! Auth::user()->isOnline() ? '<li class="text-success" style="margin-right: 10px;"> Online </li>' : '' !!}
                    {{-- <div class="dropdown-menu animated flipInY">
                        <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                        <a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                        <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                        <div class="dropdown-divider"></div> <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                    </div> --}}
                </div>
            </div>
            <!-- End User profile text-->
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    @if (Auth::user()->level->name == 'admin')
                    <li class="nav-small-cap">PERSONAL</li>
                        <li>
                        <a class="" href="{{ route('home.admin') }}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                    
                    <li>
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-account-outline"></i><span class="hide-menu">User Management</span></a>
                        <ul aria-expanded="false" class="collapse">
                            {{-- <li><a href=" {{ route('joblevel.index') }} ">Job Level</a></li> --}}
                            {{-- <li><a href=" {{ route('managementunit.index') }} ">Management Unit</a></li> --}}
                            <li><a href=" {{ route('user.index') }} ">Add Account</a></li>
                            <li><a href=" {{ route('region.index') }} ">Region</a></li>
                            <li><a href=" {{ route('level.index') }} ">Level</a></li>
                            <li><a href=" {{ route('application.index') }} ">Application</a></li>
                            <li><a href=" {{ route('menus.index') }} ">Menu</a></li>
                            <li><a href=" {{ route('submenus.index') }} ">Sub Menu</a></li>
                        </ul>
                    </li>
                    
                    @foreach (Auth::user()->permissions as $parent)
                    <li>
                        @if ($parent->permission_id == null)
                        <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">{{ $parent->name }}</span></a>
                        @endif
                        <ul aria-expanded="false" class="collapse">
                            @foreach ($parent->permissions as $menu)
                            <li><a href="{{ 'admin' . $menu->slug }}">{{ $menu->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                    
                   
                    @endif
                    

                    @if (Auth::user()->level->name == 'user')
                    <li class="nav-small-cap">PERSONAL</li>
                        <li>
                        <a class="" href="{{ route('home.user') }}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>

                    @foreach (Auth::user()->permissions->where('permission_id', null) as $parent)
                    <li>
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">{{ ucwords($parent->name) }}</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @foreach (Auth::user()->permissions->where('permission_id', '!=', null) as $menu)
                                <li>
                                    @if ($menu->slug == "key-performance-matrix")
                                        <a href="{{ route($menu->slug) }}">{{ ucwords($menu->name) }}</a>
                                    @elseif($menu->slug == "funding-topbottom-nasabah")
                                        <a href="{{ route($menu->slug) }}">{{ ucwords($menu->name) }}</a>
                                    @else
                                        <a class="has-arrow" href="#" aria-expanded="false"><span class="hide-menu">{{ ucwords($menu->name) }}</span></a>
                                    @endif
                                    @foreach ($menu->sub_menus as $sub)
                                    <ul>
                                        <a href=" {{ route($sub->slug) }} ">{{ ucwords($sub->name) }}</a>
                                    </ul>
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                    
                    @endif
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
    </aside>
        
        {{-- <li>
            <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu">Widgets</span></a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="widget-apps.html">Widget Apps</a></li>
                <li><a href="widget-data.html">Widget Data</a></li>
                <li><a href="widget-charts.html">Widget Charts</a></li>
            </ul>
        </li> --}}
        
        {{-- <li>
            <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Page Layout</span></a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="layout-single-column.html">1 Column</a></li>
                <li><a href="layout-fix-header.html">Fix header</a></li>
                <li><a href="layout-fix-sidebar.html">Fix sidebar</a></li>
                <li><a href="layout-fix-header-sidebar.html">Fixe header &amp; Sidebar</a></li>
                <li><a href="layout-boxed.html">Boxed Layout</a></li>
                <li><a href="layout-logo-center.html">Logo in Center</a></li>
            </ul>
        </li> --}}
        