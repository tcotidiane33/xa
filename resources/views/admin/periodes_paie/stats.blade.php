@extends('admin::index')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Statistiques des périodes de paie</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total des périodes</span>
                            <span class="info-box-number">{{ $stats->total }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Périodes validées</span>
                            <span class="info-box-number">{{ $stats->validees }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Durée moyenne (jours)</span>
                            <span class="info-box-number">{{ number_format($stats->duree_moyenne, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
