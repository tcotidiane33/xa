{{-- use App\Http\Controllers\ConventionCollectiveController; --}}
<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left " id="cbp-spmenu-s1">
    <aside class="sidebar-left">
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse"
                    aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h1><a class="navbar-brand" href="{{ route('dashboard') }}"><span class="fa fa-area-chart"></span>
                        Admin<span class="dashboard_text">Dashboard</span></a></h1>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="sidebar-menu">
                    <li class="header">EXTERNAILLIANCE</li>
                    <li class="treeview">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <!-- Add more menu items here -->
                    <li class="{{ request()->routeIs('clients.index') ? 'active' : '' }}">
                        <a href="{{ route('clients.index') }}">
                            <i class="fa fa-users"></i> <span>{{ __('Clients') }}</span>
                        </a>
                    </li>
                   
                        <li class="{{ request()->routeIs('materials.index') ? 'active' : '' }}">
                            <a href="{{ route('materials.index') }}">
                                <i class="fa fa-file"></i>
                                <span>{{ __('Tous les Materials') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('convention-collectives.index') ? 'active' : '' }}">
                            <a href="{{ route('convention-collectives.index') }}">
                                <i class="fa fa-square"></i>
                                <span>{{ __('Conventions Collectives') }}</span>
                            </a>
                        </li>
                    <li class="{{ request()->routeIs('admin.gestionnaire-client.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.gestionnaire-client.index') }}">
                            <i class="fa fa-link"></i> <span>{{ __('Relation Client Gestionnaire') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('periodes-paie.index') ? 'active' : '' }}">
                        <a href="{{ route('periodes-paie.index') }}">
                            <i class="fa fa-calendar"></i> <span>{{ __('Periode Paie') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('traitements-paie.index') ? 'active' : '' }}">
                        <a href="{{ route('traitements-paie.index') }}">
                            <i class="fa fa-money"></i> <span>{{ __('Traitement Paie') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('tickets.index') ? 'active' : '' }}">
                        <a href="{{ route('tickets.index') }}">
                            <i class="fa fa-ticket"></i> <span>{{ __('Tickets') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-user"></i> <span>{{ __('Utilisateurs') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-lock"></i> <span>{{ __('Rôles et permissions') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.index') }}">
                            <i class="fa fa-cogs"></i> <span>{{ __('Panneau de configuration') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
</div>
