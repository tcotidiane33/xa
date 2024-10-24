@extends('layouts.admin')

@section('title', 'Assigner des rôles aux utilisateurs')

@section('content')
<div class="main-content">
   
    <div class="cbp-spmenu-push">
        <div class="main-content">
            <div id="page-wrapper">
                <div class="breadcrumb">

                    <h1 class="title1">Assigner des rôles aux utilisateurs</h1>
                    </div>
                <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                    <div class="form-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Rôles actuels</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                        <td>
                                            <button onclick="openModal({{ $user->id }})" class="btn btn-primary">
                                                Modifier les rôles
                                            </button>
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-{{ $user->is_active ? 'danger' : 'success' }}">
                                                    {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="roleModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="roleForm" method="POST" action="{{ route('admin.roles.assign.store') }}">
                @csrf
                <input type="hidden" name="user_id" id="modalUserId">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier les rôles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($roles as $role)
                    <div>
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}">
                        <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                    </div>
                @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(userId) {
        $('#modalUserId').val(userId);
        $('#roleModal').modal('show');
    }
</script>
@endpush