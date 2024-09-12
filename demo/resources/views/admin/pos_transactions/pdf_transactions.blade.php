<!DOCTYPE html>
<html>
<head>
    <title>POS Transactions Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media (max-width: 768px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body>
    <h1>POS Transactions Report</h1>

    <table id="postransactionTable" class="table table-striped table-bordered" width="100%">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
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
                        <td>{{ $group->id }}</td>
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
    </table>
    <div class="container">
        <!-- ... previous content ... -->
    </div>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tfoot>
                                <tr>
                                    <th>{{ __('Method') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @php
                                    $grandTotal = 0;
                                @endphp
                                @foreach ($totalByMethod as $method => $totalAmount)
                                    @php
                                        $grandTotal += $totalAmount;
                                    @endphp
                                    <tr>
                                        <td>{{ $method }}</td>
                                        <td>{{ $totalAmount }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>{{ __('Grand Total') }}</th>
                                    <th>{{ $grandTotal }}</th>
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
</body>
</html>
