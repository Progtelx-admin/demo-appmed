@extends('layouts.app')

@section('title')
    {{ __('Reports') }}
@endsection
<style>
/* Custom style for the Excel button */
.dt-buttons .buttons-excel {
    background-color: green; /* Change to your desired shade of green */
    color: white; /* Change text color if needed */
    border-color: green; /* Optional: change border color */
}

/* Change hover state color if desired */
.dt-buttons .buttons-excel:hover {
    background-color: darkgreen; /* Darker green on hover */
    border-color: darkgreen; /* Optional: change border color on hover */
}
</style>

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        {{ __('Reports') }}
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Reports') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <div class="card card-primary">
        <!-- card-header -->
        <div class="card-header">
            <h3 class="card-title">{{ __('General Report') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- card-body -->
        <div class="card-body">

            <!-- Filtering Form -->
            <div id="accordion">
                <div class="card card-info">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed"
                        aria-expanded="false">
                        <i class="fas fa-filter"></i> {{ __('Filters') }}
                    </a>
                    <form method="get" action="{{ route('admin.reports.accounting') }}">
                        <div id="collapseOne" class="panel-collapse in collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <!-- date range -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>{{ __('Date range') }}:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="date"
                                                class="form-control float-right datepickerrange"
                                                @if (request()->has('date')) value="{{ request()->get('date') }}" @endif
                                                id="date" required>
                                        </div>
                                    </div>
                                    <!-- \date range -->

                                    <!-- doctors -->
                                    <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label>{{ __('Doctor') }}</label>-->
                                    <!--        <select class="form-control" name="doctors[]" id="doctor" multiple>-->
                                    <!--            @if (isset($doctors))-->
                                    <!--                @foreach ($doctors as $doctor)-->
                                    <!--                    <option value="{{ $doctor['id'] }}" selected>{{ $doctor['name'] }}-->
                                    <!--                    </option>-->
                                    <!--                @endforeach-->
                                    <!--            @endif-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <!-- \doctors -->

                                    <!-- tests -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Test') }}</label>
                                            <select class="form-control" name="tests[]" id="test" multiple>
                                                @if (isset($tests))
                                                    @foreach ($tests as $test)
                                                        <option value="{{ $test['id'] }}" selected>{{ $test['name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \tests -->

                                    <!-- cultures -->
                                    <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label>{{ __('Culture') }}</label>-->
                                    <!--        <select class="form-control" name="cultures[]" id="culture" multiple>-->
                                    <!--            @if (isset($cultures))-->
                                    <!--                @foreach ($cultures as $culture)-->
                                    <!--                    <option value="{{ $culture['id'] }}" selected>-->
                                    <!--                        {{ $culture['name'] }}</option>-->
                                    <!--                @endforeach-->
                                    <!--            @endif-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <!-- \cultures -->

                                    <!-- packages -->
                                    <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label>{{ __('Package') }}</label>-->
                                    <!--        <select class="form-control" name="packages[]" id="package" multiple>-->
                                    <!--            @if (isset($packages))-->
                                    <!--                @foreach ($packages as $package)-->
                                    <!--                    <option value="{{ $package['id'] }}" selected>-->
                                    <!--                        {{ $package['name'] }}</option>-->
                                    <!--                @endforeach-->
                                    <!--            @endif-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <!-- \packages -->

                                    <!-- contracts -->
                                    <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label>{{ __('Contract') }}</label>-->
                                    <!--        <select class="form-control" name="contracts[]" id="contract" multiple>-->
                                    <!--            @if (isset($contracts))-->
                                    <!--                @foreach ($contracts as $contract)-->
                                    <!--                    <option value="{{ $contract['id'] }}" selected>-->
                                    <!--                        {{ $contract['title'] }}</option>-->
                                    <!--                @endforeach-->
                                    <!--            @endif-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <!-- \contracts -->

                                    <!-- contracts -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Branch') }}</label>
                                            <select class="form-control" name="branches[]" id="branch" multiple>
                                                @if (isset($branches))
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch['id'] }}" selected>{{ $branch['name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \contracts -->
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cog"></i>
                                    {{ __('Generate') }}
                                </button>
<a href="{{ route('admin.reports.accounting', ['export' => 'excel'] + request()->except('export')) }}" class="btn btn-success">
    Export to Excel
</a>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Filtering Form -->
            @if (request()->has('date') || request()->has('doctors') || request()->has('tests') || request()->has('cultures'))
    <div class="card card-primary card-tabs">
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-one-invoices" role="tabpanel"
                     aria-labelledby="custom-tabs-one-invoices-tab">
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table id="buttonTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Row</th>
                                        <th>#</th>
                                        <th>Patient Name</th>
                                        <th>Date of Birth</th>
                                        <th>Phone</th>
                                        <th>Tests</th>
                                        <th>Subtotal</th>
                                        <th>Discount %</th>
                                        <th>Total</th>
                                        <th>Comment</th>
                                        <th>Reference</th>
                                        <th>Contract</th>
                                        <!-- Add other headers as needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via DataTables AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            @endif
        </div>
        <!-- /.card-body -->

        <!-- card-footer -->
        <!--@if (request()->has('date'))
    -->
        <!--          <div class="card-footer">-->
        <!--              <a href="{{ request()->fullUrl() }}&pdf=true" class="btn btn-danger" target="_blank">-->
        <!--                  <i class="fas fa-file-pdf"></i> {{ __('PDF') }}-->
        <!--              </a>-->

        <!--          </div>-->

        <!--
    @endif-->
        <!-- /.card-footer -->
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    



<script>
$(document).ready(function() {
    var table = $('#buttonTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.reports.accounting') }}",
            data: function (d) {
                d.date = $('#date').val();
                // Add other parameters here if needed
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'id', name: 'id' },
            { data: 'patient.name', name: 'patient.name' },
            { data: 'patient.dob', name: 'patient.dob' },
            { data: 'patient.phone', name: 'patient.phone' },
            { data: 'merged_items', name: 'merged_items' },
            { data: 'subtotal', name: 'subtotal' },
            { data: 'discount', name: 'discount' },
            { data: 'total', name: 'total' },
            { data: 'comment', name: 'comment' },
            { data: 'reference', name: 'reference' },
            { data: 'contract.title', name: 'contract.title' },
            // Add more columns as needed
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['excel'],
        dom: 
            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
            "<'row'<'col-sm-12'B>>", // This adds the buttons in a new row at the bottom
    });

    // Reload the table data as per the filter changes
    $('#date').on('change', function () {
        table.draw();
    });
});
</script>





