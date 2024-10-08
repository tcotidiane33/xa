@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="main-page ml-1">
    <div class="container-fluid">
        <br><br><br>
    </div>
    <div class="col_3">
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-dollar icon-rounded"></i>
                <div class="stats">
                  <h5><strong>$452</strong></h5>
                  <span>Total Revenue</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-laptop user1 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>$1019</strong></h5>
                  <span>Online Revenue</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-money user2 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>$1012</strong></h5>
                  <span>Expenses</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>$450</strong></h5>
                  <span>Expenditure</span>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>

    <!-- Add more dashboard content here -->

</div>
@endsection

@push('scripts')
<script src="{{ asset('web/js/SimpleChart.js') }}"></script>
<script>
    // Add any dashboard-specific JavaScript here
</script>
@endpush
