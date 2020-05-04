<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/images/u72gvw.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Mega Project</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @can('isAdmin')
                <img src="/images/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">
                @endcan
                @can('isUser')
                <img src="/images/userlogo.png" class="img-circle elevation-2" alt="User Image">
                @endcan
            </div>
            <div class="info">
                <a class="d-block" href="#">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <router-link tag="a" to="/dashboard" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </router-link>
                </li>
                @can('isAdmin')
                <li class="nav-item">
                    <router-link tag="a" to="/clients" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Parques (Clients)</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" to="/users" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Users</p>
                    </router-link>
                </li>
                @endcan
                @can('isUser')
                <li class="nav-item">
                    <router-link tag="a" to="/matriculas" class="nav-link">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Matriculas</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" to="/logs" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Logs</p>
                    </router-link>
                </li>
                @endcan
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
</aside>
