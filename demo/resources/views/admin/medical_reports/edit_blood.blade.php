@extends('layouts.app-mr')

@section('title')
    {{ __('Edit medical report') }}
@endsection

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-flag"></i>
                        {{ __('Blood reports') }}

                        <li>{{ __('Patient Name') }} - {{ $group['patient']['name'] }}</li>
                        <li>{{ __('Gender') }} - {{ $group['patient']['gender'] }}</li>
                        <li>{{ __('Date of Birth') }} - {{ $group['patient']['dob'] }}</li>
                        <li>{{ __('Age') }} - {{ $group['patient']['age'] }}</li>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.medical_reports.index') }}">{{ __('Medical reports') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Edit medical report') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    @can('view_medical_report')
        <div class="row">
            <div class="col-lg-12">

                <a href="{{ route('admin.medical_reports.show', $group['id']) }}" class="btn btn-danger float-right mb-3">
                    <i class="fa fa-file-pdf"></i> {{ __('Print Report') }}
                </a>

                <button type="button" class="btn btn-info float-right mb-3 mr-1" data-toggle="modal"
                    data-target="#patient_modal">
                    <i class="fas fa-user-injured"></i> {{ __('Patient info') }}
                </button>

                @can('sign_medical_report')
                    <a class="btn btn-success float-right mb-3 mr-1" id="butonis"
                        href="{{ route('admin.medical_reports.sign', $group['id']) }}">
                        <i class="fas fa-signature" aria-hidden="true"></i>
                        {{ __('Sign Report') }}
                    </a>
                    <button id="btninterrupt" type="submit"class="btn btn-primary" data-dismiss="modal" hidden>
                        <iclass="fa fa-check"></i> Close
                    </button>
                @endcan

                <a @if (isset($previous)) href="{{ route('admin.medical_reports.edit', $previous['id']) }}" @endif
                    class="btn btn-info @if (!isset($previous)) disabled @endif">
                    <i class="fa fa-backward mr-2"></i>
                    {{ __('Previous') }}
                </a>
                <a @if (isset($next)) href="{{ route('admin.medical_reports.edit', $next['id']) }}" @endif
                    class="btn btn-success @if (!isset($next)) disabled @endif">
                    {{ __('Next') }}
                    <i class="fa fa-forward ml-2"></i>
                </a>

            </div>
        </div>
    @endcan

    <form action="{{ route('admin.biochemistrys.upload_report', $group['id']) }}" method="POST"
        enctype="multipart/form-data">
        <div class="card card-primary card-outline collapsed-card">
            <div class="card-header">
                <h5 class="card-title">
                    @if ($group['uploaded_report'])
                        <i class="fa fa-check-double text-success"></i>
                    @endif
                    {{ __('Upload report') }}
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label>
                            {{ __('You can upload a pdf file as the report') }}
                        </label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="report" accept="application/pdf" class="custom-file-input"
                                        id="report" required>
                                    <label class="custom-file-label" for="report">{{ __('Report') }}</label>
                                </div>
                                @if ($group['uploaded_report'])
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">
                                            <a href="{{ $group['report_pdf'] }}" target="_blank">
                                                <i class="fa fa-file-pdf"></i>
                                            </a>
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-check"></i>
                    {{ __('Upload') }}
                </button>
            </div>
        </div>
    </form>

    <!-- tests -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Tests') }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if (count($group['all_tests']))
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="taps">
                            @foreach ($group['all_tests'] as $test)
                                @if ($test['test_id'] == 405)
                                    <li class="nav-item">
                                        <a class="nav-link text-capitalize" href="#test_{{ $test['id'] }}"
                                            data-toggle="tab">
                                            @if ($test['done'])
                                                <i class="fa fa-check text-success"></i>
                                            @endif {{ $test['test']['name'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div><!-- /.card-header -->
                    <!--alert sign-->
                    <div style="display:none;" class="alert alert-success" id="success-alert">
                        <button type="button" class="close" data-dismiss="alert" onclick="show();">x</button>
                        <strong>Success! </strong> Report signed successfully.
                    </div>
                    <!--alert sign-->

                    <!--alert update-->
                    <div style="display:none;" class="alert alert-success" id="success-alertup">
                        <button type="button" class="close" data-dismiss="alert" onclick="show();">x</button>
                        <strong>Success! </strong> Test update successfully.
                    </div>
                    <!--alert update-->
                    <div class="card-body p-0">
                        <div class="tab-content">
                            @foreach ($group['all_tests'] as $key => $test)
                                @if ($test['test_id'] == 405)
                                    <div class="tab-pane {{ $key + 1 }} " id="test_{{ $test['id'] }}">
                                        <form action="{{ route('admin.medical_reports.update', $test['id']) }}"
                                            method="POST">
                                            @csrf
                                            @method('put')
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="200px">{{ __('Name') }}</th>
                                                        <th width="100px" class="text-center">{{ __('Unit') }}</th>
                                                        <th width="400px" class="text-center">
                                                            {{ __('Reference Range') }}
                                                        </th>
                                                        <th class="text-center" style="width:100px">{{ __('Status') }}
                                                        </th>
                                                        <th width="90px" class="text-center">{{ __('Result') }}</th>
                                                        <th width="200px" class="text-center">{{ __('ResultLab') }}
                                                            <br>
                                                            <h5>Edito këtu</h5>
                                                            @can('edit_medical_report')
                                                                <div class="form-checkbox">
                                                                    <label>Get results</label>
                                                                    <input type="checkbox" id="checkbox" name="copy" />
                                                                </div>
                                                            @endcan
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($test['results'] as $result)
                                                        @if (isset($result['component']))
                                                            @if ($result['component']['title'])
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <b>{{ $result['component']['name'] }}</b>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td>{{ $result['component']['name'] }}</td>
                                                                    <td class="text-center">
                                                                        {{ $result['component']['unit'] }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if (isset($result['component']) && count($result['component']['reference_ranges']))
                                                                        @endif
                                                                        {!! $result['component']['reference_range'] !!}
                                                                    </td>
                                                                    <td style="width:10px" class="text-center">
                                                                        @if ($result['component']['status'])
                                                                            <select
                                                                                name="result[{{ $result['id'] }}][status]"
                                                                                class="form-control select_result status">
                                                                                <option value="High"
                                                                                    @if ($result['status'] == 'High') selected @endif>
                                                                                    {{ __('High') }}</option>
                                                                                <option value="High"
                                                                                    @if ($result['status'] == 'High') selected @endif>
                                                                                    {{ __('High') }}</option>
                                                                                <option value=""
                                                                                    @if ($result['status'] == '') selected @endif>
                                                                                    {{ __('') }}</option>
                                                                                <option value="Low"
                                                                                    @if ($result['status'] == 'Low') selected @endif>
                                                                                    {{ __('Low') }}</option>
                                                                                <option value="Low"
                                                                                    @if ($result['status'] == 'Low') selected @endif>
                                                                                    {{ __('Low') }}</option>
                                                                                <!-- New status -->
                                                                                @if (!empty($result['status']) && !in_array($result['status'], ['High', '', 'Low', 'High', 'Low']))
                                                                                    <option
                                                                                        value="{{ $result['status'] }}"
                                                                                        selected>{{ $result['status'] }}
                                                                                    </option>
                                                                                @endif
                                                                                <!-- \New status -->
                                                                            </select>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($result['component']['type'] == 'text')
                                                                            <input tabindex="1" type="text"
                                                                                name="result[{{ $result['id'] }}][result]"
                                                                                class="form-control test_result text-center"
                                                                                value="{{ $result->result }}"
                                                                                @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                            normal_to="{{ $result->reference_range()->normal_to }}"
                                            critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                            critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>
                                                                        @else
                                                                            <select
                                                                                name="result[{{ $result['id'] }}][result]"
                                                                                class="form-control select_result test_result"
                                                                                @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                                normal_to="{{ $result->reference_range()->normal_to }}"
                                                critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                                critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>
                                                                                <option value="" value=""
                                                                                    disabled selected>
                                                                                    {{ __('Select result') }}</option>
                                                                                @foreach ($result['component']['options'] as $option)
                                                                                    <option value="{{ $option['name'] }}"
                                                                                        @if ($option['name'] == $result['result']) selected @endif>
                                                                                        {{ $option['name'] }}</option>
                                                                                @endforeach
                                                                                <!-- Deleted option -->
                                                                                @if (!$result['component']['options']->contains('name', $result['result']))
                                                                                    <option
                                                                                        value="{{ $result['result'] }}"
                                                                                        selected>{{ $result['result'] }}
                                                                                    </option>
                                                                                @endif
                                                                                <!-- \Deleted option -->
                                                                            </select>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if ($result['component']['status'])
                                                                            @foreach ($laboratories as $laboratory)
                                                                                @if ($laboratory['LIMSTestParam'] == $result['test_id'])
                                                                                    <div id="box2">
                                                                                        <div class="form-item">
                                                                                            <input tabindex="2"
                                                                                                type="text"
                                                                                                id="textbox21"
                                                                                                name="result[{{ $result['id'] }}][result] "
                                                                                                class="form-control test_result text-center"
                                                                                                value="{{ $result['result'] }}"
                                                                                                @if (!empty($result->reference_range())) normal_from="{{ $result->reference_range()->normal_from }}"
                                            normal_to="{{ $result->reference_range()->normal_to }}"
                                            critical_high_from="{{ $result->reference_range()->critical_high_from }}"
                                            critical_low_from="{{ $result->reference_range()->critical_low_from }}" @endif>
                                                                                            <label>{{ $laboratory->ResultTransferDtTm }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="box1">
                                                                                        <div class="form-item">
                                                                                            <input autocomplete="off"
                                                                                                type="text"
                                                                                                id="textbox11"
                                                                                                value="{{ $laboratory['ResultValue'] }}"
                                                                                                hidden />
                                                                                        @break

                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <tr>

                                                    <td colspan="6">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label
                                                                    for="">{{ __('Eritrocitet: ') }}</label>
                                                                <div class="input-group form-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="eritrocitet"
                                                                        value="{{ $test['eritrocitet'] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label for="">{{ __('Leukocitet: ') }}</label>
                                                                <div class="input-group form-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="leukocitet"
                                                                        value="{{ $test['leukocitet'] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label
                                                                    for="">{{ __('Trombocitet: ') }}</label>
                                                                <div class="input-group form-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="trombocitet"
                                                                        value="{{ $test['trombocitet'] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label for="">{{ __('Comment ') }}</label>
                                                                <textarea name="comment" id="" cols="30" rows="3" placeholder="{{ __('Comment') }}"
                                                                    class="form-control comment">{{ $test['comment'] }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label
                                                                    for="">{{ __('Select comment ') }}</label>
                                                                <select id="select_comment_test_{{ $test['id'] }}"
                                                                    class="form-control select_comment">
                                                                    <option value="" disabled selected>
                                                                        {{ __('Select comment') }}</option>
                                                                    @foreach ($test['test']['comments'] as $comment)
                                                                        <option value="{{ $comment['comment'] }}">
                                                                            {{ $comment['comment'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <?php
                                            $current_date_time = Carbon\Carbon::now()->toDateTimeString();
                                            ?>
                                            <tfoot>
                                                <tr>
                                                <tr>

                                                    <td colspan="5">
                                                        <input name="pdf_update" type="text"
                                                            value="{{ $current_date_time }}" hidden>
                                                        <button id="butonOne" type="submit"class="btn btn-primary">
                                                            <iclass="fa fa-check"></i>Save
                                                        </button>
                                                        <button id="butonTwo" type="submit"class="btn btn-primary"
                                                            data-dismiss="modal" hidden>
                                                            <iclass="fa fa-check"></i> Close
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </form>
                                </div>
                            @endif
                        @endforeach
                        <!-- /.tab-pane -->

                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
        @else
            <!-- check  tests selected -->
            <h6 class="text-center">
                {{ __('No data available') }}
            </h6>
            <!-- End check  tests selected -->
        @endif

    </div>
    <!-- /.card-body -->
</div>
<!-- End tests -->



<input type="hidden" id="patient_id" value="{{ $group['patient_id'] }}">


@can('view_medical_report')
    <div class="row">
        <div class="col-lg-12">

            <a href="{{ route('admin.medical_reports.show', $group['id']) }}" class="btn btn-danger float-right mb-3">
                <i class="fa fa-file-pdf"></i> {{ __('Print Report') }}
            </a>

            <button type="button" class="btn btn-info float-right mb-3 mr-1" data-toggle="modal"
                data-target="#patient_modal">
                <i class="fas fa-user-injured"></i> {{ __('Patient info') }}
            </button>

            @can('sign_medical_report')
                <a class="btn btn-success float-right mb-3 mr-1" id="butonis"
                    href="{{ route('admin.medical_reports.sign', $group['id']) }}">
                    <i class="fas fa-signature" aria-hidden="true"></i>
                    {{ __('Sign Report') }}
                </a>
                <button id="btninterrupt" type="submit"class="btn btn-primary" data-dismiss="modal" hidden>
                    <iclass="fa fa-check"></i> Close
                </button>
            @endcan

            <a @if (isset($previous)) href="{{ route('admin.medical_reports.edit', $previous['id']) }}" @endif
                class="btn btn-info @if (!isset($previous)) disabled @endif">
                <i class="fa fa-backward mr-2"></i>
                {{ __('Previous') }}
            </a>
            <a @if (isset($next)) href="{{ route('admin.medical_reports.edit', $next['id']) }}" @endif
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
<script src="{{ url('js/admin/medical_reports.js') }}"></script>

<script>
    document.getElementById("checkbox").checked = false;
    $('[name="copy"]').click(function() {
        // get a list of all text fields in the first div 
        var ins = $('#box1 input[type="text"]');

        // get a matching list of all text fields in the second div 
        var outs = $('#box2 input[type="text"]');

        // look at each item in the list(s) (they're the same length)
        for (var i = 0; i < ins.length; ++i)
            // for each one, if the checkbox is checked, set the second box's 
            // input value to the matching value from the first
            //
            // if it's unchecked, empty out the second box's input's value
            //
            outs[i].value = this.checked ? ins[i].value : '';
    });
</script>

<!--test update btninterrupt-->
<script>
    $(document).ready(function() {
        function fn1() {
            $('[id="butonTwo"]').click();
        }

        function fn2() {
            window.stop();
        }
        $(document).ready(function fn3() {
            $('[id="success-alertup"]').hide();
            $('[id="butonTwo"]').click(function showAlert() {
                $('[id="success-alertup"]').fadeTo(2000, 500).slideUp(500, function() {
                    $('[id="success-alertup"]').slideUp(500);
                });
            });
        });
        $('[id="butonOne"]').click(function() {
            setTimeout(function() {
                fn1();
                fn2();
                fn3();
            }, 2000);
        });
    });
</script>
<!--test update btninterrupt-->

<!--culture update btninterrupt-->
<script>
    $(document).ready(function() {
        function fn1() {
            $('[id="butonTwoC"]').click();
        }

        function fn2() {
            window.stop();
        }
        $(document).ready(function fn3() {
            $('[id="success-alertup-c"]').hide();
            $('[id="butonTwoC"]').click(function showAlert() {
                $('[id="success-alertup-c"]').fadeTo(2000, 500).slideUp(500, function() {
                    $('[id="success-alertup-c"]').slideUp(500);
                });
            });
        });
        $('[id="butonOneC"]').click(function() {
            setTimeout(function() {
                fn1();
                fn2();
                fn3();
            }, 2000);
        });
    });
</script>
<!--culture update btninterrupt-->

<!--sign-->
<script>
    $(document).ready(function() {
        function fn1() {
            $('[id="btninterrupt"]').click();
        }

        function fn2() {
            window.stop();
        }
        $(document).ready(function fn3() {
            $('[id="success-alert"]').hide();
            $('[id="btninterrupt"]').click(function showAlert() {
                $('[id="success-alert"]').fadeTo(2000, 500).slideUp(500, function() {
                    $('[id="success-alert"]').slideUp(500);
                });
            });
        });
        $('[id="butonis"]').click(function() {
            setTimeout(function() {
                fn1();
                fn2();
                fn3();
            }, 1000);
        });
    });
</script>
<!--sign-->
<script>
    var categories = @json($categories);
    var antibiotic_count = 0;
</script>
@endsection
