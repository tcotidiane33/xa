<div class="header-right">
    <div class="dashboard-setting user-notification">
        <div class="dropdown">
            <!-- Icones des uploads, downloads, et chats -->
            <a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-upload"></span>
                <span class="micon bi bi-download"></span>
            </a>
            @auth
            <!-- Accès aux Chats -->
            <a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-chat-text"></span>
                <span class="mtext">Chats</span>
            </a>
            @endauth
        </div>
    </div>

    @auth
    <!-- Section des notifications -->
    <div class="user-notifications">
        <ul class="nofitications-dropdown">
            <!-- Tickets -->
            <li class="dropdown head-dpdn">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-ticket"></i>
                    <span class="badge">{{ $tickets->count() }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <h3>Vous avez {{ $tickets->count() }} nouveaux tickets</h3>
                    </li>
                    @foreach ($tickets->take(4) as $ticket)
                        <li>
                            <a href="{{ route('tickets.show', $ticket) }}">
                                <div class="notification_desc">
                                    <p>{{ Str::limit($ticket->title, 30) }}</p>
                                    <p><span>{{ $ticket->created_at->diffForHumans() }}</span></p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('tickets.index') }}">Voir tous les tickets</a>
                    </li>
                </ul>
            </li>

            <!-- Notifications générales -->
            <li class="dropdown head-dpdn">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="badge blue">{{ auth()->user()->unreadNotifications->count() }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <h3>Vous avez {{ auth()->user()->unreadNotifications->count() }} nouvelles notifications</h3>
                    </li>
                    @foreach (auth()->user()->unreadNotifications->take(4) as $notification)
                        <li>
                            <a href="{{ route('notifications.show', $notification->id) }}">
                                <p>{{ Str::limit($notification->data['message'], 30) }}</p>
                                <p><span>{{ $notification->created_at->diffForHumans() }}</span></p>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('notifications.index') }}">Voir toutes les notifications</a>
                    </li>
                </ul>
            </li>

            <!-- Posts -->
            <li class="dropdown head-dpdn">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-tasks"></i>
                    <span class="badge blue1">{{ $posts->count() }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <h3>Il y a {{ $posts->count() }} nouveaux posts</h3>
                    </li>
                    @foreach ($posts->take(4) as $post)
                        <li>
                            <a href="{{ route('posts.show', $post) }}">
                                <div class="task-info">
                                    <span class="task-desc">{{ Str::limit($post->title, 20) }}</span>
                                    <span class="percentage">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('posts.index') }}">Voir tous les posts</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Profil de l'utilisateur -->
    <div class="user-info-dropdown">
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                <span class="user-icon">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" />
                    @else
                        <img src="{{ asset('backoffice/vendors/images/photo1.jpg') }}" alt="Default Avatar" />
                    @endif
                </span>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="dw dw-user1"></i> Profile</a>
                <a class="dropdown-item" href="{{ route('profile.update-settings') }}"><i class="dw dw-settings2"></i> Settings</a>
                <a class="dropdown-item" href="{{ route('tickets.index') }}"><i class="dw dw-help"></i> Help</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="dw dw-logout"></i> Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    @endauth
</div>
