<div class="left-side-bar">
    <div class="brand-logo">
        <a href="#">
            <img src="{{ asset('backoffice/vendors/images/deskapp-logo.svg') }}" alt="" class="dark-logo" />
            <img src="{{ asset('backoffice/vendors/images/deskapp-logo-white.svg') }}" alt="" class="light-logo" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <!-- Dashboard -->
                <li class="dropdown">
                    <a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-house"></span><span class="mtext">Tableau de bord</span>
                    </a>
                </li>
        
                <!-- Clients -->
                <li>
                    <a href="{{ route('clients.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-people-fill"></span><span class="mtext">Clients</span>
                    </a>
                </li>
        
                <!-- Utilisateurs -->
                <li>
                    <a href="{{ route('users.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person"></span><span class="mtext">Utilisateurs</span>
                    </a>
                </li>
        
                <!-- Tickets -->
                <li>
                    <a href="{{ route('tickets.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-ticket"></span><span class="mtext">Tickets</span>
                    </a>
                </li>
        
                <!-- Matériels -->
                <li>
                    <a href="{{ route('materials.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-box-seam"></span><span class="mtext">Matériels</span>
                    </a>
                </li>
        
                <!-- Périodes de Paie -->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-calendar"></span><span class="mtext">Périodes de Paie</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('periodes-paie.index') }}">Toutes les Périodes</a></li>
                        <li><a href="{{ route('periodes-paie.create') }}">Créer une Période</a></li>
                    </ul>
                </li>
        
                <!-- Traitement des Paies -->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-cash"></span><span class="mtext">Traitements de Paie</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('traitements-paie.index') }}">Tous les Traitements</a></li>
                        <li><a href="{{ route('traitements-paie.create') }}">Nouveau Traitement</a></li>
                    </ul>
                </li>
        
                <!-- Conventions Collectives -->
                <li>
                    <a href="{{ route('convention-collectives.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-file-earmark-text"></span><span class="mtext">Conventions Collectives</span>
                    </a>
                </li>
        
                <!-- Notifications -->
                <li>
                    <a href="{{ route('notifications.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-bell"></span><span class="mtext">Notifications</span>
                    </a>
                </li>
        
                <!-- Admin - Gestionnaire de clients -->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-gear"></span><span class="mtext">Admin</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('admin.index') }}">Panneau Admin</a></li>
                        <li><a href="{{ route('admin.gestionnaire-client.index') }}">Gestionnaires de Clients</a></li>
                        {{-- <li><a href="{{ route('settings.index') }}">Paramètres</a></li> --}}
                    </ul>
                </li>
            </ul>
        </div>
        
    </div>
</div>
