@extends('layouts.admin')

@section('content')

    @include('admin.traitements-paie._edit_popup')

    <!-- Contenu principal -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Traitements de paie</h3>
                    {{ $grid->render() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            $('.grid-row-checkbox').on('change', function() {
                var $this = $(this);
                var id = $this.data('id');
                var checked = $this.prop('checked');

                $.ajax({
                    url: '/admin/traitements-paie/' + id,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        checked: checked
                    },
                    success: function(data) {
                        toastr.success('Mise à jour réussie');
                    }
                });
            });

            $('.edit-traitement').on('click', function() {
                var id = $(this).data('id');
                // Charger les données du traitement via AJAX et remplir le formulaire
                $('#edit-traitement-modal').modal('show');
            });

            $('#save-traitement').on('click', function() {
                var form = $('#edit-traitement-form');
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        // Mettre à jour la ligne dans le tableau
                        $('#edit-traitement-modal').modal('hide');
                    },
                    error: function(xhr) {
                        // Gérer les erreurs
                    }
                });
            });

            // Logique pour activer/désactiver les champs en fonction de l'état précédent
            $('#edit-traitement-form input[type="date"]').on('change', function() {
                var $this = $(this);
                var $next = $this.closest('.form-group').next().find('input[type="date"]');
                if ($this.val()) {
                    $next.prop('disabled', false);
                } else {
                    $next.prop('disabled', true).val('');
                }
            });
        });
    </script>
    @endpush

    @endsection
