<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('favico.ico')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light ">
        PENRO Marinduque
      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      @auth
      @endauth


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @auth 
            <li class="nav-item ">
              <a href="{{ route('admin.suppliers.index') }}" class="nav-link ">
                <i class="fas fa-users"></i>
                <p>
                  Suppliers
                </p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="{{ route('auth.logout')}}" class="nav-link ">
                <i class="fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>
          @endauth
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>