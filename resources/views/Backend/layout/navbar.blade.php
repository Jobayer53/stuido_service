@php
    $notifications = \App\Models\Order::where('notified',0)->count();
@endphp
  <!--  Header Start -->
  <header class="app-header">
      <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
              <li class="nav-item d-block d-xl-none">
                  <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                      <i class="ti ti-menu-2"></i>
                  </a>
              </li>

          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
             <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

    {{-- Notification Dropdown --}}
    <li class="nav-item dropdown">
        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="notificationDropdown"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ti ti-bell-ringing"></i>
            @if($notifications > 0)
            <div class="notification bg-primary rounded-circle"></div>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up p-0"
             aria-labelledby="notificationDropdown" style="min-width: 300px; max-width: 400px;">
            <div class="p-3 border-bottom">
                <h6 class="mb-0">Notifications</h6>
            </div>
            <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                {{-- Example notifications --}}
                <a href="{{route('admin_order')}}" class="list-group-item list-group-item-action d-flex gap-3 align-items-start">
                    <i class="ti ti-file-info text-primary fs-4"></i>
                    <div>
                        @if($notifications > 0)
                        <h6 class="mb-0">New {{ $notifications }} Orders Received</h6>
                        <small class="text-muted">2 minutes ago</small>
                        @else
                        <h6 class="mb-0">No New Notifications</h6>
                        @endif
                    </div>
                </a>
                {{-- <a href="#" class="list-group-item list-group-item-action d-flex gap-3 align-items-start">
                    <i class="ti ti-checklist text-success fs-4"></i>
                    <div>
                        <h6 class="mb-0">Service Completed</h6>
                        <small class="text-muted">10 minutes ago</small>
                    </div>
                </a> --}}
                {{-- You can loop through dynamic notifications here --}}
            </div>
            <div class="p-2 border-top text-center">
                <a href="{{route('admin_order')}}" class="text-primary">View All</a>
            </div>
        </div>
    </li>

    {{-- Profile Dropdown --}}
    <li class="nav-item dropdown">
        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('backend/images/profile/user-1.jpg') }}" alt="" width="35"
                height="35" class="rounded-circle">
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
                <a href="{{ route('admin_profile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-user fs-6"></i>
                    <p class="mb-0 fs-3">My Profile</p>
                </a>
                <form id="logout-form" action="{{ route('admin_logout') }}" method="POST">
                    @csrf
                </form>
                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
            </div>
        </div>
    </li>

</ul>

          </div>
      </nav>
  </header>
  <!--  Header End -->
