<ul class="nav flex-column sidebar-menu">

    {{-- Dashboard --}}
    <li class="nav-item">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- Document Management --}}
    <li class="sidebar-section">
        DOCUMENT MANAGEMENT
    </li>

    <li class="nav-item">
        <a href="{{ route('documents.index') }}"
           class="nav-link {{ request()->routeIs('documents.index') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Documents</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('documents.create') }}"
           class="nav-link {{ request()->routeIs('documents.create') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-plus"></i>
            <span>Register Document</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('inbox.index') }}"
           class="nav-link {{ request()->routeIs('inbox.*') ? 'active' : '' }}">
            <i class="bi bi-inbox"></i>
            <span>My Inbox</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('outbox.index') }}"
           class="nav-link {{ request()->routeIs('outbox.*') ? 'active' : '' }}">
            <i class="bi bi-send"></i>
            <span>My Outbox</span>
        </a>
    </li>

    {{-- Reports --}}
    <li class="sidebar-section">
        REPORTS
    </li>

    <li class="nav-item">
        <a href="{{ route('reports.index') }}"
        class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i>
            <span>Reports</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('reports.tracking') }}"
        class="nav-link {{ request()->routeIs('reports.tracking') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Tracking Reports</span>
        </a>
    </li>

    {{-- Administration --}}
    <li class="sidebar-section">
        ADMINISTRATION
    </li>

    <li class="nav-item">
        <a href="{{ route('offices.index') }}"
           class="nav-link {{ request()->routeIs('offices.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Offices</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('users.index') }}"
           class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>User Management</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('roles.index') }}"
           class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i>
            <span>Roles & Permissions</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a href="{{ route('permissions.index') }}"
           class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i>
            <span>Permissions</span>
        </a>
    </li> --}}

</ul>