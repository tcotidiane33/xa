<?php

use OpenAdmin\Admin\Admin;
use OpenAdmin\Admin\Grid\Column;
use App\Admin\Extensions\Popover;


/**
 * Open-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * OpenAdmin\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * OpenAdmin\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
OpenAdmin\Admin\Form::forget(['map', 'editor']);
Column::extend('popover', Popover::class);

// OpenAdmin\Admin\Form::forget(['editor']);

Admin::navbar(function (\OpenAdmin\Admin\Widgets\Navbar $navbar) {

    $navbar->left('<button type="button" class="btn btn-secondary m-1"><a href="/dashboard" class="btn text-warning">Dashboard</a></button>');
    $navbar->right('<button type="button" class="btn btn-outline-warning m-1"><a href="/admin/periodes-paie" class="btn text-warning"><b>Definir une periode de paie</b></a></button>');
    $navbar->right('<button type="button" class="btn btn-outline-danger m-1"><a href="/admin/traitements-paie" class="btn text-danger"><b>Traiter une fiche de paie</b></a></button>');
    $navbar->right('<button type="button" class="btn btn-outline-infos m-1"><i class="fa fa-bell" style="font-size:18px;color:yellow"></i><span class="badge bg-info"><b>11</b></span></button>');

    // adds fullscreen option
    $navbar->right(new OpenAdmin\Admin\Widgets\Navbar\Fullscreen());

    // adds ajax refresh button
    $navbar->right(new OpenAdmin\Admin\Widgets\Navbar\RefreshButton());

});
