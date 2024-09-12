@extends('layouts.app')

@section('title')
    {{ __('Sales Reports') }}
@endsection

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        {{ __('Sales Reports') }}
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Sales Reports') }}</li>
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
            <h3 class="card-title">{{ __('Sales Reports') }}</h3>
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
                    <form method="get" action="{{ route('admin.pos_transactions.sales_report') }}">
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
                                    <!-- payments -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Payment Method') }}</label>
                                            <select class="form-control" name="payments[]" id="payment">
                                                @if (isset($payments))
                                                    @foreach ($payments as $payment)
                                                        <option value="{{ $payment['id'] }}" selected>{{ $payment['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \payments -->
                                    <!-- pos -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Point of Sale') }}</label>
                                            <select class="form-control" name="pos" id="pos">
                                                @if (isset($pos))
                                                    @foreach ($pos as $p)
                                                        <option value="{{ $p['id'] }}" selected>{{ $p['pos_name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <!-- \pos -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label>{{ __('Created By User') }}</label>
                                            <select class="form-control user_id" name="created_by_user[]" multiple="multiple"></select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cog"></i>
                                    {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Filtering Form -->
            @if (request()->has('date') || request()->has('payments') || request()->has('pos'))
                <!-- Report Details -->
                <div class="card card-primary card-tabs">
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-one-invoices" role="tabpanel" aria-labelledby="custom-tabs-one-invoices-tab">
                                <div class="row">
                                    <div class="col-lg-12 table-responsive">
                                        <table id="buttonTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20px">#</th>
                                                    <th width="10px">{{ __('Date') }}</th>
                                                    <th width="10px">{{ __('Created By') }}</th>
                                                    <th width="10px">{{ __('Pos') }}</th>
                                                    <th width="10px">{{ __('Fiscal') }}</th>
                                                    <th width="10px">{{ __('Due') }}</th>
                                                    <th width="10px">{{ __('Closed') }}</th>
                                                    <th width="10px">{{ __('Payment Amount') }}</th>
                                                    <th width="10px">{{ __('Payment Method') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($groups as $group)
                                                @foreach ($group['payments'] as $payment)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('admin.groups.show', $group->id) }}" class="btn btn-primary btn-sm">
                                                                {{ $group->id }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $group['created_at'] }}
                                                        </td>
                                                        <td>
                                                            {{ $group['created_by_user']['name'] }}
                                                        </td>
                                                        <td>
                                                            {{ $group['pointOfSale']['pos_name'] }}
                                                        </td>
                                                        <td>
                                                            @if ($group->fiscalized)
                                                                <i class="fas fa-check text-success"></i>
                                                            @else
                                                                <i class="fas fa-times text-danger"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $group['due'] }}
                                                        </td>
                                                        <td>
                                                            @if ($payment->closed)
                                                                <i class="fas fa-check text-success"></i>
                                                            @else
                                                                <i class="fas fa-times text-danger"></i>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            {{ $payment->amount }} {{get_currency()}}
                                                        </td>
                                                        <td>
                                                            {{ $payment->payment_method->name }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            <tr>
                                                <td colspan="9">&nbsp;</td>
                                            </tr>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td colspan="2">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#summaryModal">
                                                            View Summary
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="summaryModalLabel">Sales Summary</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h4>Point of Sale Summary</h4>
                                                                        <ul>
                                                                            @foreach ($posTotals as $posName => $posTotal)
                                                                                <li>
                                                                                    <strong>{{ $posName }}</strong>
                                                                                    <ul>
                                                                                        @foreach ($posTotal as $paymentMethodName => $totalAmount)
                                                                                            <li>{{ $paymentMethodName }}: {{ $totalAmount }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                        <h4>Total by Payment Method</h4>
                                                                        <ul>
                                                                            @foreach ($totalByPaymentMethod as $paymentMethodName => $totalAmount)
                                                                                <li>{{ $paymentMethodName }}: {{ $totalAmount }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>

    <tfoot>
        <tr>
            <td colspan="12"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td colspan="6">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="border: 1px solid #ccc; padding: 10px; border-radius: 5px;">
                                <h4>Point of Sale Summary</h4>
                                <ul>
                                    @foreach ($posTotals as $posName => $posTotal)
                                        <li>
                                            <strong>{{ $posName }}</strong>
                                            <ul>
                                                @foreach ($posTotal as $paymentMethodName => $totalAmount)
                                                    <li>{{ $paymentMethodName }}: {{ $totalAmount }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                                <h4>Total by Payment Method</h4>
                                <ul>
                                    @foreach ($totalByPaymentMethod as $paymentMethodName => $totalAmount)
                                        <li>{{ $paymentMethodName }}: {{ $totalAmount }}</li>
                                    @endforeach
                                </ul>
                                <h4>Cash In/Out Summary</h4>
                                <ul>
                                    @foreach ($cashInOutflows as $cashInOutflow)
                                        <li>
                                            {{ $cashInOutflow->description }} - {{ $cashInOutflow->pointOfSale->pos_name }} :
                                            @if ($cashInOutflow->cash_in > 0)
                                                Cash In: {{ $cashInOutflow->cash_in }}
                                            @endif
                                            @if ($cashInOutflow->cash_out > 0)
                                                Cash Out: {{ $cashInOutflow->cash_out }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tfoot>









                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                {{ __('Cash Flow Transactions') }}
                                            </div>
                                            <div class="card-body">
                                                <table id="cashfllow" class="table table-hover" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Date') }}</th>
                                                            <th>{{ __('Created By') }}</th>
                                                            <th>{{ __('Pos Name') }}</th>
                                                            <th>{{ __('Description') }}</th>
                                                            <th>{{ __('Cash Out') }}</th>
                                                            <th>{{ __('Cash In') }}</th>
                                                            <th>{{ __('Comment') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($cashFlowEntries as $entry)
                                                            <tr>
                                                                <td>{{ $entry->created_at }}</td>
                                                                <td>{{ $entry->createdBy->name }}</td>
                                                                <td>{{ $entry->pointOfSale->pos_name }}</td>
                                                                <td>{{ $entry->description }}</td>
                                                                <td>{{ $entry->cash_out }}</td>
                                                                <td>{{ $entry->cash_in }}</td>
                                                                <td>{{ $entry->comment }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ url('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ url('plugins/print/jQuery.print.min.js') }}"></script>
    <script src="{{ url('js/admin/accounting_report.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#buttonTable').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, 500, 1000, -1],
                    [10, 25, 50, 100, 500, 1000, "All"]
                ],
                dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-8'p>>",
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });

        });


    $('#payment').select2({
   width: "100%",
   placeholder: trans("Payment Method"),
   multiple: true,
   ajax: {
      beforeSend: function () {
         $('.preloader').show();
         $('.loader').show();
      },

      url: "/ajax/get_payment_methods",
      processResults: function (data) {
         return {
            results: $.map(data, function (item) {
               return {
                  text: item.name,
                  id: item.id
               };
            })
         };
      },
      complete: function () {
         $('.preloader').hide();
         $('.loader').hide();
      }
   }
});



$('#pos').select2({
   width: "100%",
   placeholder: trans("POS Name"),
   ajax: {
      beforeSend: function () {
         $('.preloader').show();
         $('.loader').show();
      },
      url: "/ajax/get_pos",
      processResults: function (data) {
         return {
            results: $.map(data, function (item) {
               return {
                  text: item.pos_name,
                  id: item.id
               };
            })
         };
      },
      complete: function () {
         $('.preloader').hide();
         $('.loader').hide();
      }
   }
});



$('.user_id').select2({
    allowClear: true,
    multiple: true,
    width: "100%",
    placeholder: "Select User",
    ajax: {
        url: '/ajax/get_users',
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
        }
    }
});



    </script>
@endsection
