<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('admin.home')}}" class="brand-link">
    <img src="{{asset('images/kennel-logo.png')}}" alt="Premium kennel Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Premium Kennel</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{route('admin.home')}}" class="nav-link">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <p> Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('reservations')}}" class="nav-link">
            <i class="fas fa-calendar-alt nav-icon"></i>
            <p>Reservation
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('appointments')}}" class="nav-link">
            <i class="fas fa-calendar-check nav-icon"></i>
            <p>Appointment
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('pets.index')}}" class="nav-link">
            <i class="fas fa-paw nav-icon"></i>
            <p>Pets
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('breed.index')}}" class="nav-link">
            <i class="fas fa-border-all nav-icon"></i>
            <p>Breed
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('type.index')}}" class="nav-link">
            <i class="fas fa-list nav-icon"></i>
            <p>Type
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
