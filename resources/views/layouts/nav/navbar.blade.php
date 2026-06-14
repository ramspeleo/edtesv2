<nav class="navbar navbar-expand-lg navbar-dark gov-navbar">

    <div class="container-fluid">

        <div class="d-flex align-items-center">

            <button class="btn gov-menu-btn d-md-none me-2"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i>
            </button>

            <div class="gov-navbar-brand">
                <div class="gov-navbar-title">
                    National Conciliation and Mediation Board
                </div>
                <div class="gov-navbar-subtitle">
                    Electronic Document Tracking and Exchange System
                </div>
            </div>

        </div>

        <div class="dropdown ms-auto">

            <button class="btn gov-profile-btn dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/default-user.png') }}"
                     alt="Profile"
                     class="gov-profile-img">

                <span class="gov-profile-name">
                    {{ Auth::user()->name }}
                </span>

            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm gov-profile-menu">
                <li class="dropdown-header text-start">
                    <small class="text-muted">Signed in as</small><br>
                    <strong>{{ Auth::user()->email }}</strong><br>
                    <small class="text-primary">
                        {{ Auth::user()->office->office_name ?? 'No Office Assigned' }}
                    </small>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-person-circle me-2"></i>
                        My Profile
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>

        </div>

    </div>

</nav>