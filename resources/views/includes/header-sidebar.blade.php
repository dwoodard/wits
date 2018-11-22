<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="{{ url ('/app') }}"  style="padding:0;" >
        {{-- config('app.name', 'Laravel') --}}
        <img src="/images/logo.png" height="51"/>
        </a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">

        @if (Auth::guest())

        <li>
            <a href="/login">Login</a>
        </li>

        @else

        {{-- <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> New Comment
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                            <span class="pull-right text-muted small">12 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-envelope fa-fw"></i> Message Sent
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-tasks fa-fw"></i> New Task
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li> --}}
        <!-- /.dropdown -->

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>
                <i class="fa fa-angle-down fa-fw"></i>

            </a>

            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="#">{{Auth::user()->email}}</a>
                </li>
                @if(Auth::check())
                    <li>
                        <a href="#">{{ Auth::user()->departments()->pluck('name')->implode(',') }}</a>
                    </li>
                @endif

                <li class="divider"></li>
                <li>
                    <router-link to="/settings">
                        <i class="fa fa-sliders-h fa-fw"></i> Settings</router-link>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt"></i> Logout </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->

        @endif

    </ul>
    <!-- /.navbar-top-links -->


    @if (Auth::check())
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">

                <li {{ (Request::is( '/dashboard') ? 'class="active"' : '') }}
                    v-show="/admin|user|department_admin|department_user|auditor|financial|room_support/.test($store.getters.roles.join())"
                >
                    <router-link to="/dashboard">
                        <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</router-link>
                </li>

                <li {{ (Request::is( '/inventory') ? 'class="active"' : '') }}
                    v-show="/admin|department_admin|department_user/.test($store.getters.roles.join())"
                >
                    <router-link to="/inventory">
                        <i class="fa fa-th-list fa-fw"></i> Inventory</router-link>
                </li>


                <li {{ (Request::is( '/departments') ? 'class="active"' : '') }}
                    v-show="/admin|department_admin|auditor|financial/.test($store.getters.roles.join())"
                >
                    <router-link to="/departments">
                        <i class="fa fa-sitemap fa-fw"></i> Departments</router-link>
                </li>

                <li {{ (Request::is( '/locations') ? 'class="active"' : '') }}>
                    <router-link to="/locations">
                        <i class="fa fa-map-marker-alt fa-fw"></i> Locations</router-link>
                </li>

                <li {{ (Request::is( '/users') ? 'class="active"' : '') }}
                    v-show="/admin|department_admin|department_user|auditor|financial/.test($store.getters.roles.join())"
                >
                    <a href="#">
                        <i class="fas fa-users fa-fw"></i> Users
                        <span class="fas fa-caret-down">
                    </a>

                    <ul class="nav nav-second-level">
                        <li {{ (Request::is( '/users') ? 'class="active"' : '') }}
                        v-show="/admin/.test($store.getters.roles.join())"

                        >
                            <router-link to="/users">Users List</router-link>
                        </li>

                        <li {{ (Request::is( '*roles-permissions') ? 'class="active"' : '') }}
                            v-show="/admin/.test($store.getters.roles.join())"
                        >
                            <router-link to="/users/roles-permissions">Roles / Permissions</router-link>
                        </li>


                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                {{-- <li {{ (Request::is( '/reports') ? 'class="active"' : '') }}
                    v-show="/admin|department_admin|department_user|auditor|financial/.test($store.getters.roles.join())"

                >
                    <router-link to="/reports">
                        <i class="fa fa-file-alt fa-fw"></i> Reports</router-link>
                </li> --}}
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
    @endif

</nav>
