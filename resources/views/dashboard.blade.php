@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="main-page">
    <div class="container-fluid">
        <br><br><br>
    </div>
    <div class="col_3 ml-1">
        <div class="col-md-1">
            <span></span>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-users icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $totalUsers }}</strong></h5>
                  <span>Total Utilisateurs</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-building user1 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $totalClients }}</strong></h5>
                  <span>Total Clients</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-calendar user2 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $totalPeriodesPaie }}</strong></h5>
                  <span>Périodes de paie</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $successPercentage }}%</strong></h5>
                  <span>Taux de réussite</span>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Traitements de paie</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <div class="mini-stat clearfix bg-info">
                            <span class="mini-stat-icon"><i class="fa fa-clock-o"></i></span>
                            <div class="mini-stat-info">
                                <span>{{ $traitementsPaieEnCours }}</span>
                                En cours
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mini-stat clearfix bg-success">
                            <span class="mini-stat-icon"><i class="fa fa-check-circle-o"></i></span>
                            <div class="mini-stat-info">
                                <span>{{ $traitementsPaieTerminer }}</span>
                                Terminés
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mini-stat clearfix bg-danger">
                            <span class="mini-stat-icon"><i class="fa fa-pause-circle-o"></i></span>
                            <div class="mini-stat-info">
                                <span>{{ $traitementsPaieInterrompu }}</span>
                                Interrompus
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Derniers clients ajoutés</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($latestClients as $client)
                            <li class="list-group-item">{{ $client->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('web/js/SimpleChart.js') }}"></script>
<script>
    // Add any dashboard-specific JavaScript here
</script>
@endpush
