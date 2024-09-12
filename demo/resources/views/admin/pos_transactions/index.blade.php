@extends('layouts.app')

@section('title')
    {{ __('Cash Register Close') }}
@endsection

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-flag"></i>
                        {{ __('Cash Register Close') }}
                    </h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Cash Register Close') }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-9 table-responsive">
                        <div class="card">
                            <div class="card-title alert alert-primary" role="alert">
                                {{ __('Cash Register Close') }}
                            </div>
                            <div class="card-body table-responsive">

                                <div class="row no-print">
                                    <div class="col-12">
                                        <a href="{{ route('admin.pos_transactions.pdf_transactions') }}"
                                            class="btn btn-success" target="_blank ">Generate PDF</a>
                                        <button id="checkAllBtn" class="btn btn-warning">{{ __('Check All') }}</button>
                                        <button id="bulkUpdateBtn"
                                            class="btn btn-danger">{{ __('Mark Selected as Closed') }}</button>
                                    </div>
                                </div>
                                <h6></h6>
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

                    <div class="col-md-3">
                        <form action="{{ route('admin.pos-transactions.storecashflow') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-title alert alert-primary" role="alert">
                                    {{ __('Cash Disbursement') }}
                                </div>
                                <div class="card-body">
                                    <label class="badge badge-warning" for="cashInHand">
                                        {{ __('Cash in Hand: ') }}{{ $posname }}
                                    </label>
                                    <input style="border-color: #FFC107 !important" class="form-control price"
                                        id="cashInHand" name="" value="{{ $cashInHand }}" disabled>
                                </div>
                                <div class="card-body">
                                    <label class="badge badge-primary" for="disbursement">
                                        {{ __('Disbursement: ') }}
                                    </label>
                                    <input style="border-color: #7367F0 !important" class="form-control price"
                                        id="cashOut" name="cash_out" value="">
                                </div>
                                @can('view_cash_in')
                                    <div class="card-body">
                                        <label class="badge badge-primary" for="cash_in">
                                            {{ __('Cash In: ') }}
                                        </label>
                                        <input style="border-color: #7367F0 !important" class="form-control price"
                                            id="" name="cash_in" value="0">
                                    </div>
                                @endcan
                                <div class="card-body">
                                    <label for="dropdown">{{ __('Description') }}</label>
                                    <select class="form-control" id="dropdown" name="description">
                                        <option value="option1">Option 1</option>
                                        <option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option>
                                    </select>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">{{ __('Comment') }}</label>
                                        <textarea name="comment" id="" cols="" rows="" class="form-control"></textarea>
                                    </div>
                                </div>
                                <input class="form-control" name="created_by" value="{{ $userId }}" hidden>
                                <button id="" class="btn btn-success">{{ __('Save') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="container">
                <!-- ... previous content ... -->
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
                                    <th>{{ __('Cash Out') }}</th>
                                    <th>{{ __('Cash In') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Comment') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cashFlowEntries as $entry)
                                    <tr>
                                        <td>{{ $entry->created_at }}</td>
                                        <td>{{ $entry->createdBy->name }}</td>
                                        <td>{{ $entry->pointOfSale->pos_name }}</td>
                                        <td>{{ $entry->cash_out }}</td>
                                        <td>{{ $entry->cash_in }}</td>
                                        <td>{{ $entry->description }}</td>
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

    {{-- RAPORTET --}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Cash Register Managment') }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                        class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body collapse">
            {{-- aaaaa --}}
        </div>
    </div>
    {{-- RAPORTET --}}
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#cashfllow').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            // Event handler for bulk update button
            $('#bulkUpdateBtn').click(function() {
                var selectedIds = [];
                $('.transaction-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    toastr.error(trans('Please select transactions to mark as closed.'), trans('Failed'));
                    return;
                }

                if (confirm('Are you sure you want to mark the selected transactions as closed?')) {
                    $.ajax({
                        url: '{{ route('admin.pos-transactions.bulk-update') }}',
                        method: 'POST',
                        data: {
                            transaction_ids: selectedIds,
                            _token: '{{ csrf_token() }}'
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success('Selected transactions marked as closed', 'Success');
                            location.reload(); // Refresh the page after update
                        },
                        error: function(error) {
                            toastr.error(trans('Something went wrong'), trans('Failed'));
                        }
                    });
                }
            });

            // Event delegation for checkbox click event
            $('#postransactionTable').on('click', '.transaction-checkbox', function() {
                // Handle checkbox selection here
            });

            // Initialize DataTables
            $('#postransactionTable').DataTable({
                // Add your DataTables configuration options here
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
            var dataTable = $('#postransactionTable').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, 500, 1000, -1],
                    [10, 25, 50, 100, 500, 1000, "All"]
                ],
                "pageLength": 10 // Default records per page
            });

            $('#checkAllBtn').click(function() {
                $('input[type="checkbox"]', dataTable.rows().nodes()).prop('checked', true);

                // Change DataTables page length to "All"
                dataTable.page.len(-1).draw();
            });

            $('#bulkUpdateBtn').click(function() {
                // ... existing code for bulk update ...
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#cashOut').on('input', function() {
                var cashInHand = {{ $cashInHand }}; // Initial cash in hand value
                var cashOut = parseFloat($(this).val()) || 0; // Entered cash out value
                var updatedCashInHand = cashInHand - cashOut;

                $('#cashInHand').val(updatedCashInHand.toFixed(2));
            });
        });
    </script>

@endsection
