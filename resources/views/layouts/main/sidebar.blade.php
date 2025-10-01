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
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="https://api.dicebear.com/9.x/thumbs/svg?seed={{ auth()->user()->empInfo->name }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ auth()->user()->empInfo->name }}</a>
          </div>
        </div>
      @endauth


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @guest
            <li class="nav-item ">
              <a href="{{ route('timein', ['division' => request('division')])}}" class="nav-link ">
                <i class="far fa-clock"></i>
                <p>
                  Log In
                </p>
              </a>
            </li>
          @endguest
            <li class="nav-item ">
              <a href="{{ route('userGuides', ['division' => request('division')])}}" class="nav-link ">
                <i class="far fa-question-circle"></i>
                <p>
                  User Guides
                </p>
              </a>
            </li>
          @auth 
            <li class="nav-item ">
              <a href="{{ route('timein.show', ['division' => request('division')])}}" class="nav-link ">
                <i class="far fa-clock"></i>
                <p>
                  Time In
                </p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="{{ route('settings.index', ['division' => request('division')])}}" class="nav-link ">
                <i class="fas fa-user-cog"></i>
                <p>
                  Settings
                </p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="{{ route('logout')}}" class="nav-link ">
                <i class="fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>
          @endauth
          {{-- <li class="nav-item ">
            <a href="#" class="nav-link ">
              <i class="fas fa-tasks"></i>
              <p>
                Tasks
              </p>
            </a>
          </li> --}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>