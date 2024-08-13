<div class="modal fade" id="edit-traitement-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Éditer le traitement de paie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-traitement-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nb_bulletins">Nombre de bulletins</label>
                        <input type="number" class="form-control" id="nb_bulletins" name="nb_bulletins">
                        <input type="file" class="form-control-file mt-2" id="nb_bulletins_file" name="nb_bulletins_file">
                    </div>

                    <div class="form-group">
                        <label for="maj_fiche_para">Mise à jour fiche paramétrage</label>
                        <input type="date" class="form-control" id="maj_fiche_para" name="maj_fiche_para">
                        <input type="file" class="form-control-file mt-2" id="maj_fiche_para_file" name="maj_fiche_para_file">
                    </div>

                    <div class="form-group">
                        <label for="reception_variables">Réception variables</label>
                        <input type="date" class="form-control" id="reception_variables" name="reception_variables">
                        <input type="file" class="form-control-file mt-2" id="reception_variables_file" name="reception_variables_file">
                    </div>

                    <div class="form-group">
                        <label for="preparation_bp">Préparation BP</label>
                        <input type="date" class="form-control" id="preparation_bp" name="preparation_bp">
                        <input type="file" class="form-control-file mt-2" id="preparation_bp_file" name="preparation_bp_file">
                    </div>

                    <div class="form-group">
                        <label for="validation_bp_client">Validation BP client</label>
                        <input type="date" class="form-control" id="validation_bp_client" name="validation_bp_client">
                        <input type="file" class="form-control-file mt-2" id="validation_bp_client_file" name="validation_bp_client_file">
                    </div>

                    <div class="form-group">
                        <label for="preparation_envoi_dsn">Préparation et envoi DSN</label>
                        <input type="date" class="form-control" id="preparation_envoi_dsn" name="preparation_envoi_dsn">
                        <input type="file" class="form-control-file mt-2" id="preparation_envoi_dsn_file" name="preparation_envoi_dsn_file">
                    </div>

                    <div class="form-group">
                        <label for="accuses_dsn">Accusés DSN</label>
                        <input type="date" class="form-control" id="accuses_dsn" name="accuses_dsn">
                        <input type="file" class="form-control-file mt-2" id="accuses_dsn_file" name="accuses_dsn_file">
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="save-traitement">Enregistrer</button>
            </div>
        </div>
    </div>
</div>