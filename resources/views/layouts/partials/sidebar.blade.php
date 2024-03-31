<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{route("invoices")}}" class="brand-link">
        <span class="brand-text font-weight-light">Syscore</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->first_name}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{route("invoices")}}" class="nav-link">
                        <i class="fas fa-file-invoice"></i>
                        <p> Invoices</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout.perform') }}" class="nav-link">
                        <i class="fas fa-sign-out"></i>
                        <p> Logout</p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

</aside>
