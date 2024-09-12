@extends('layouts.app')

@section('title')
    {{ __('Print medical report') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ url('css/print.css') }}">
@endsection

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-flag"></i>
                        {{ __('Medical reports') }}
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.medical_reports.index') }}">{{ __('Medical reports') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Print medical report') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
@can('view_medical_report')
    <div class="row mb-3">
        <div class="col-lg-12">
            <a class="btn btn-secondary float-right" href="{{ route('admin.medical_reports.test-pdf', $group['id']) }}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{ __('Tests PDF') }}
            </a>
            <button type="button" class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#patient_modal">
                <i class="fas fa-user-injured"></i> {{ __('Patient info') }}
            </button>
            <a @if (isset($previous)) href="{{ route('admin.medical_reports.show2', $previous['id']) }}" @endif
                class="btn btn-info @if (!isset($previous)) disabled @endif">
                <i class="fa fa-backward mr-2"></i>
                {{ __('Previous') }}
            </a>
            <a @if (isset($next)) href="{{ route('admin.medical_reports.show2', $next['id']) }}" @endif
                class="btn btn-success @if (!isset($next)) disabled @endif">
                {{ __('Next') }}
                <i class="fa fa-forward ml-2"></i>
            </a>
        </div>
    </div>
@endcan


    @csrf
    <!-- patient code -->
    <input type="hidden" id="patient_code"
        @if (isset($group['patient'])) value="{{ $group['patient']['code'] }}" @endif>
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="text-dark">
                        <tr>
                            <th>{{ __('Test') }}</th>
                            <th>{{ __('Toggle Show') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group->all_tests as $test)
                            <tr>
                                <td class="text-dark">{{ $test->test->name }}</td>
                                <td>
                                    <div id="showBtnContainer_{{ $test['id'] }}">
                                        @if ($test['show'] == 1)
                                            <!-- Show success button -->
                                            <button type="button" class="btn btn-success" onclick="updateShow({{ $test['id'] }}, 0)">Show in reports</button>
                                        @else
                                            <!-- Show danger button -->
                                            <button type="button" class="btn btn-danger" onclick="updateShow({{ $test['id'] }}, 1)">Do not show in reports</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="text-dark">
                        <tr>
                            <th>{{ __('Test') }}</th>
                            <th>{{ __('Toggle Show') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group->all_cultures as $culture)
                            <tr>
                                <td class="text-dark">{{ $culture->culture->name }}</td>
                                <td>
                                    <div id="showBtnContainer_{{ $culture['id'] }}">
                                        @if ($culture['show'] == 1)
                                            <!-- Show success button -->
                                            <button type="button" class="btn btn-success" onclick="updateShowc({{ $culture['id'] }}, 0)">Show in reports</button>
                                        @else
                                            <!-- Show danger button -->
                                            <button type="button" class="btn btn-danger" onclick="updateShowc({{ $culture['id'] }}, 1)">Do not show in reports</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



    @can('view_medical_report')
    <div class="row mb-3">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#patient_modal">
                <i class="fas fa-user-injured"></i> {{ __('Patient info') }}
            </button>
            <a class="btn btn-secondary" href="{{ route('admin.medical_reports.test-pdf', $group['id']) }}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{ __('Tests PDF') }}
            </a>
            <a @if (isset($previous)) href="{{ route('admin.medical_reports.show2', $previous['id']) }}" @endif
                class="btn btn-info @if (!isset($previous)) disabled @endif">
                <i class="fa fa-backward mr-2"></i>
                {{ __('Previous') }}
            </a>
            <a @if (isset($next)) href="{{ route('admin.medical_reports.show2', $next['id']) }}" @endif
                class="btn btn-success @if (!isset($next)) disabled @endif">
                {{ __('Next') }}
                <i class="fa fa-forward ml-2"></i>
            </a>
        </div>
    </div>
@endcan


    @include('admin.medical_reports._patient_modal')
@endsection

@section('scripts')
    <!-- Include the CSRF token in the head section -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ url('plugins/ekko-lightbox/ekko-lightbox.js') }}"></script>
    <!-- jQuery should be included only once in the head section -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateShow(testId, newValue) {
        $.ajax({
            url: '{{ url("admin/medical_reports/update_show/") }}/' + testId,
            type: 'PUT',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            data: {
                show: newValue
            },
            success: function(response) {
                // Update the button text and class based on the new value
                const showBtn = $(`#showBtnContainer_${testId} button`);
                if (newValue === 1) {
                    showBtn.text("Show in reports");
                    showBtn.removeClass("btn-danger").addClass("btn-success");
                } else {
                    showBtn.text("Do not show in reports");
                    showBtn.removeClass("btn-success").addClass("btn-danger");
                }
            },
            error: function(xhr, status, error) {
                console.error("Failed to update 'show' attribute:", error);
            }
        });
    }
</script>
<script>
    function updateShowc(cultureId, newValue) {
        $.ajax({
             url: '{{ url("admin/medical_reports/update_showc/") }}/' + cultureId,
            type: 'PUT',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            data: {
                show: newValue
            },
            success: function(response) {
                // Update the button text and class based on the new value
                const showBtn = $(`#showBtnContainer_${cultureId} button`);
                if (newValue === 1) {
                    showBtn.text("Show in reports");
                    showBtn.removeClass("btn-danger").addClass("btn-success");
                } else {
                    showBtn.text("Do not show in reports");
                    showBtn.removeClass("btn-success").addClass("btn-danger");
                }
            },
            error: function(xhr, status, error) {
                console.error("Failed to update 'show' attribute:", error);
            }
        });
    }
</script>
@endsection