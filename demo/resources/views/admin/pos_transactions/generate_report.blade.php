@extends('layouts.app')

@section('title')
    {{ __('Reports') }}
@endsection

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
                    <form method="get" action="{{ route('admin.pos_transactions.generate_report') }}">

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group">
                                <label>{{ __('Payment Method') }}</label>
                                <select class="form-control select2" name="payments[]" id="payment" multiple>
                                    @foreach ($allPaymentMethods as $payment)
                                        <option value="{{ $payment->id }}"
                                            {{ $selectedPaymentMethods == $payment->id ? 'selected' : '' }}>
                                            {{ $payment->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group">
                                <label>{{ __('Select Point of Sale') }}</label>
                                <select class="form-control select2" name="pos[]" id="pos" multiple>
                                    @foreach ($allPOS as $pos)
                                        <option value="{{ $pos->id }}"
                                            {{ $selectedPOS == $pos->id ? 'selected' : '' }}>
                                            {{ $pos->pos_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                    class="form-control">
                            </div>
                        </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Apply Filters</button>
                        <a href="{{ route('admin.pos_transactions.generate_report', ['generate_pdf' => 1]) }}" class="btn btn-secondary mt-2">Generate PDF</a>
                        <a href="{{ route('admin.pos_transactions.generate_report', array_merge(request()->all(), ['generate_pdf' => 1])) }}" class="btn btn-secondary mt-2">Generate PDF2 </a>

                    </form>
                </div>
            </div>
            <!-- Filtering Form -->
            <!-- Report Details -->
            <div class="card card-primary card-tabs">
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-one-invoices" role="tabpanel"
                            aria-labelledby="custom-tabs-one-invoices-tab">
                            <div class="row">
                                <div class="col-lg-12 table-responsive">
                                    <table id="postransactionTable" class="table table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('ID') }}</th>
                                                <th>{{ __('Created Time') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                <th>{{ __('Method') }}</th>
                                                <th>{{ __('Created By') }}</th>
                                                <th>{{ __('POS Name') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalByMethod = [];
                                            @endphp
                                            @foreach ($transactions as $group)
                                                @foreach ($group->payments as $transaction)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="transaction-checkbox"
                                                                value="{{ $transaction->id }}">
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.groups.show', $group->id) }}">
                                                                {{ $group->id }}
                                                            </a>
                                                        </td>

                                                        <td>{{ $transaction->created_at }}</td>
                                                        <td>{{ $transaction->amount }}</td>
                                                        <td>{{ $transaction->payment_method->name }}</td>
                                                        <td>{{ $group->created_by_user->name }}</td>
                                                        <td>{{ $group->pointOfSale->pos_name }}</td>
                                                    </tr>
                                                    @php
                                                        $paymentMethodName = $transaction->payment_method->name;
                                                        if (!isset($totalByMethod[$paymentMethodName])) {
                                                            $totalByMethod[$paymentMethodName] = 0;
                                                        }
                                                        $totalByMethod[$paymentMethodName] += $transaction->amount;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="alert alert-secondary" role="alert">
                                                <th colspan="7">
                                                    {{ __('Summary') }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Method') }}</th>
                                                <th>{{ __('Total') }}</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            @php
                                                $grandTotal = 0;
                                                $totalsByUser = [];
                                            @endphp
                                            @foreach ($transactions as $group)
                                                @foreach ($group->payments as $transaction)
                                                    @php
                                                        $paymentMethodName = $transaction->payment_method->name;
                                                        $createdByUser = $group->created_by_user->name;
                                                        if (!isset($totalsByUser[$createdByUser])) {
                                                            $totalsByUser[$createdByUser] = [];
                                                        }
                                                        if (!isset($totalsByUser[$createdByUser][$paymentMethodName])) {
                                                            $totalsByUser[$createdByUser][$paymentMethodName] = 0;
                                                        }
                                                        $totalsByUser[$createdByUser][$paymentMethodName] += $transaction->amount;
                                                        $grandTotal += $transaction->amount;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            @foreach ($totalsByUser as $user => $userTotals)
                                                <tr class="alert alert-secondary" role="alert">
                                                    <th colspan="7">
                                                        {{ __('Created by') }}: {{ $user }}
                                                    </th>
                                                </tr>
                                                @foreach ($userTotals as $method => $totalAmount)
                                                    <tr>
                                                        <td>{{ $method }}</td>
                                                        <td>${{ number_format($totalAmount, 2) }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            <tr>
                                                <th>{{ __('Grand Total') }}</th>
                                                <th>${{ number_format($grandTotal, 2) }}</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            var dataTable = $('#postransactionTable').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, 500, 1000, -1],
                    [10, 25, 50, 100, 500, 1000, "All"]
                ],
                "pageLength": 10 // Default records per page
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endsection
