<!-- Aside -->
<aside class="bsb-sidebar-1 offcanvas offcanvas-start" tabindex="-1" id="bsbSidebar1" aria-labelledby="bsbSidebarLabel1">
    <div class="offcanvas-header">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/img/branding/console-logo.svg') }}" id="bsbSidebarLabel1" class="bsb-tpl-logo" alt="BootstrapBrain Logo">
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-0">
        <hr class="sidebar-divider mb-3">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link p-3" href="{{ route('admin.dashboard') }}">
                    <div class="nav-link-icon text-primary">
                        <i class="bi bi-grid"></i>
                    </div>
                    <span class="nav-link-text fw-bold">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-3" href="{{ route('users.index') }}">
                    <div class="nav-link-icon text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span class="nav-link-text fw-bold">User Management</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
