<?php

namespace App\Admin\Controllers;

use App\Models\PeriodePaie;
use App\Models\TraitementPaie;
use App\Models\User;
use App\Models\Client;
// use Encore\Admin\Facades\Admin;
// use Encore\Admin\Form;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\GestionnaireClient; // Assurez-vous d'inclure ce modèle
use OpenAdmin\Admin\Controllers\AdminController;

class TraitementPaieController extends AdminController
{
    protected $title = 'Traitements paie';

    protected function grid()
    {
        $grid = new Grid(new TraitementPaie());

        $grid->column('id', __('Id'))->hide();
        // $grid->desciption()->popover('right');
        // $grid->title()->color('#ccc');
        // $grid->setSortColumns(false); // disable sorting for all columns

        // $grid->tags()->pluck('name')->map('ucwords');
        // $grid->images();
        // // chain method calls to display multiple images
        // $grid->images()->display(function ($images) {

        //     return json_decode($images, true);

        // })->map(function ($path) {

        //     return 'http://localhost/images/'. $path;

        // })->image();
        $grid->column('reference', __('Référence'));
        // $grid->column('gestionnaire_id', __('GESTIONNAIRE'))->display(function ($ges_id) {
        //     return User::find($ges_id)->name ?? 'N/A';
        // });
        $grid->column('client_id', __('CLIENT'))->display(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });
        $grid->column('periode_paie_id', __('PERIODE DE PAIE 1/0'))->display(function ($period_id) {
            $periodePaie = PeriodePaie::find($period_id);
            $color = $periodePaie->validee ? 'success' : 'danger';
            return "<span class='badge p-2 bg-{$color}'>{$periodePaie->reference}</span>";
        });
        $grid->column('nbr_bull', __('NOMBRE DE BULLETINS'))->label('primary');
        $grid->column('maj_fiche_para', __('MAJ FICHE PARA'))->label('info');
        $grid->column('reception_variable', __('RECEPTION VARIABLES'))->label('info');
        $grid->column('preparation_bp', __('PREPARATION BP'))->label('info');
        $grid->column('validation_bp_client', __('VALIDATION BP CLIENT'))->label('info');
        $grid->column('preparation_envoie_dsn', __('PREPARATION ENVOIE DSN'))->label('info');
        $grid->column('accuses_dsn', __('ACCUSES DSN'))->label('info');
        // $grid->column('teledec_urssaf', __('TELEDEC URSSAF'));
        $grid->column('notes', __('NOTES'));
        $grid->column('pj_nbr_bull', __('PJ NOMBRE DE BULLETINS'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_maj_fiche_para', __('PJ MAJ FICHE PARA'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_reception_variable', __('PJ RECEPTION VARIABLES'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_preparation_bp', __('PJ PREPARATION BP'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_validation_bp_client', __('PJ VALIDATION BP CLIENT'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_preparation_envoie_dsn', __('PJ PREPARATION ENVOIE DSN'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('link_preparation_envoie_dsn', __('LINK PREPARATION ENVOIE DSN'))->link();
        $grid->column('pj_accuses_dsn', __('PJ ACCUSES DSN'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('link_accuses_dsn', __('LINK ACCUSES DSN'))->link();
        $grid->column('listBoxIsEmpty', __('LISTE VIDE'))->display(function ($isEmpty) {
            return $isEmpty ? 'Oui' : 'Non';
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(TraitementPaie::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('reference', __('Référence'));
        // $show->field('gestionnaire_id', __('GESTIONNAIRE'))->as(function ($ges_id) {
        //     return User::find($ges_id)->name ?? 'N/A';
        // });
        $show->field('client_id', __('CLIENT'))->as(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });
        $show->field('periode_paie_id', __('PERIODE DE PAIE 1/0'))->as(function ($period_id) {
            $periodePaie = PeriodePaie::find($period_id);
            $color = $periodePaie->validee ? 'success' : 'danger';
            return "<span class='badge p-2 bg-{$color}'>{$periodePaie->reference}</span>";
        });
        $show->field('nbr_bull', __('NOMBRE DE BULLETINS'));
        $show->field('maj_fiche_para', __('MAJ FICHE PARA'));
        $show->field('reception_variable', __('RECEPTION VARIABLES'));
        $show->field('preparation_bp', __('PREPARATION BP'));
        $show->field('validation_bp_client', __('VALIDATION BP CLIENT'));
        $show->field('preparation_envoie_dsn', __('PREPARATION ENVOIE DSN'));
        $show->field('accuses_dsn', __('ACCUSES DSN'));
        // $show->field('teledec_urssaf', __('TELEDEC URSSAF'));
        $show->field('notes', __('NOTES'));
        $show->field('pj_nbr_bull', __('PJ NOMBRE DE BULLETINS'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_maj_fiche_para', __('PJ MAJ FICHE PARA'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_reception_variable', __('PJ RECEPTION VARIABLES'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_preparation_bp', __('PJ PREPARATION BP'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_validation_bp_client', __('PJ VALIDATION BP CLIENT'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_preparation_envoie_dsn', __('PJ PREPARATION ENVOIE DSN'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('link_preparation_envoie_dsn', __('LINK PREPARATION ENVOIE DSN'))->link();
        $show->field('pj_accuses_dsn', __('PJ ACCUSES DSN'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('link_accuses_dsn', __('LINK ACCUSES DSN'))->link();
        $show->field('listBoxIsEmpty', __('LISTE VIDE'))->as(function ($isEmpty) {
            return $isEmpty ? 'Oui' : 'Non';
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }


    protected function form()
    {
        $form = new Form(new TraitementPaie());

        $form->tab('Étape 1: Informations de base', function ($form) {
            $form->select('client_id', __('CLIENT'))
                ->options(Client::pluck('name', 'id'))
                ->required();

            $form->display('gestionnaire_id', __('GESTIONNAIRE'))->with(function ($value) {
                return "<span class='gestionnaire_id'>N/A</span><input type='hidden' name='gestionnaire_id' value=''>";
            });

            $form->display('responsable_id', __('RESPONSABLE'))->with(function ($value) {
                return "<span class='responsable_id'>N/A</span><input type='hidden' name='responsable_id' value=''>";
            });

            $form->display('superviseur_id', __('SUPERVISEUR'))->with(function ($value) {
                return "<span class='superviseur_id'>N/A</span><input type='hidden' name='superviseur_id' value=''>";
            });

            $form->display('gestionnaires_ids', __('Gestionnaires supplémentaires'))->with(function ($value) {
                return "<span class='gestionnaires_ids'>N/A</span><input type='hidden' name='gestionnaires_ids' value='[]'>";
            });

            // Ajouter un script JavaScript pour gérer le remplissage automatique
            $form->html('<script>
                $(document).ready(function() {
                    $("select[name=\'client_id\']").on("change", function() {
                        var clientId = $(this).val();
                        if (clientId) {
                            $.ajax({
                                url: "/api/getClientInfo",
                                type: "GET",
                                data: {"q": clientId},
                                dataType: "json",
                                success: function(data) {
                                    if(data) {
                                        $(".gestionnaire_id").text(data.gestionnaire ? data.gestionnaire.name : "N/A");
                                        $(".responsable_id").text(data.responsable ? data.responsable.name : "N/A");
                                        $(".superviseur_id").text(data.superviseur ? data.superviseur.name : "N/A");
                                        $(".gestionnaires_ids").text(data.gestionnaires ? Object.values(data.gestionnaires).join(", ") : "N/A");

                                        // Mise à jour des champs cachés pour la soumission du formulaire
                                        $("input[name=\'gestionnaire_id\']").val(data.gestionnaire ? data.gestionnaire.id : "");
                                        $("input[name=\'responsable_id\']").val(data.responsable ? data.responsable.id : "");
                                        $("input[name=\'superviseur_id\']").val(data.superviseur ? data.superviseur.id : "");
                                        $("input[name=\'gestionnaires_ids\']").val(data.gestionnaires ? JSON.stringify(data.gestionnaires) : "[]");
                                    } else {
                                        $(".gestionnaire_id, .responsable_id, .superviseur_id, .gestionnaires_ids").text("N/A");
                                        $("input[name=\'gestionnaire_id\'], input[name=\'responsable_id\'], input[name=\'superviseur_id\']").val("");
                                        $("input[name=\'gestionnaires_ids\']").val("[]");
                                    }
                                },
                                error: function() {
                                    alert("Une erreur s\'est produite lors de la récupération des informations du client.");
                                }
                            });
                        } else {
                            $(".gestionnaire_id, .responsable_id, .superviseur_id, .gestionnaires_ids").text("N/A");
                            $("input[name=\'gestionnaire_id\'], input[name=\'responsable_id\'], input[name=\'superviseur_id\']").val("");
                            $("input[name=\'gestionnaires_ids\']").val("[]");
                        }
                    });
                });
            </script>');

            $form->select('periode_paie_id', __('PERIODE DE PAIE'))
                ->options(PeriodePaie::pluck('reference', 'id'))
                ->required();
        })->submitted(function (Form $form) {
            // Validation de l'étape 1
            $form->validate([
                'client_id' => 'required',
                'periode_paie_id' => 'required',
            ]);
        });

        $form->tab('Étape 2: Détails du traitement', function ($form) {
            $form->number('nbr_bull', __('NOMBRE DE BULLETINS'))->required();
            $form->multipleImage('pj_nbr_bull', __('PJ NOMBRE DE BULLETINS'))->removable();
            $form->date('maj_fiche_para', __('MAJ FICHE PARA'))->required();
            $form->multipleImage('pj_maj_fiche_para', __('PJ MAJ FICHE PARA'))->removable();
            $form->date('reception_variable', __('RECEPTION VARIABLES'))->required();
            $form->multipleImage('pj_reception_variable', __('PJ RECEPTION VARIABLES'))->removable();
            $form->date('preparation_bp', __('PREPARATION BP'))->required();
            $form->multipleImage('pj_preparation_bp', __('PJ PREPARATION BP'))->removable();
            $form->date('validation_bp_client', __('VALIDATION BP CLIENT'))->required();
            $form->multipleImage('pj_validation_bp_client', __('PJ VALIDATION BP CLIENT'))->removable();
        })->submitted(function (Form $form) {
            // Validation de l'étape 2
            $form->validate([
                'nbr_bull' => 'required|numeric',
                'maj_fiche_para' => 'required|date',
                'reception_variable' => 'required|date',
                'preparation_bp' => 'required|date',
                'validation_bp_client' => 'required|date',
            ]);
        });

        $form->tab('Étape 3: Finalisation', function ($form) {
            $form->date('preparation_envoie_dsn', __('PREPARATION ENVOIE DSN'))->required();
            $form->multipleImage('pj_preparation_envoie_dsn', __('PJ PREPARATION ENVOIE DSN'))->removable();
            $form->text('link_preparation_envoie_dsn', __('LINK PREPARATION ENVOIE DSN'));
            $form->date('accuses_dsn', __('ACCUSES DSN'))->required();
            $form->multipleImage('pj_accuses_dsn', __('PJ ACCUSES DSN'))->removable();
            $form->text('link_accuses_dsn', __('LINK ACCUSES DSN'));
            $form->textarea('notes', __('NOTES'));
        })->submitted(function (Form $form) {
            // Validation de l'étape 3
            $form->validate([
                'preparation_envoie_dsn' => 'required|date',
                'accuses_dsn' => 'required|date',
            ]);
        });

        // Barre de progression
        $form->saving(function (Form $form) {
            $totalSteps = 10;
            $completedSteps = 0;

            $fields = [
                'client_id', 'periode_paie_id', 'nbr_bull', 'maj_fiche_para',
                'reception_variable', 'preparation_bp', 'validation_bp_client',
                'preparation_envoie_dsn', 'accuses_dsn', 'notes'
            ];

            foreach ($fields as $field) {
                if (!empty($form->model()->$field)) {
                    $completedSteps++;
                }
            }

            $form->model()->progress = ($completedSteps / $totalSteps) * 100;
        });

        $form->display('progress', __('Progression'))->with(function ($value) {
            return "{$value}%";
        });

        return $form;
    }
}
