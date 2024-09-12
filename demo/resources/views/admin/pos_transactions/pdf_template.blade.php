@extends('layouts.invoice')

@section('title')
    {{ __('Report') }}
@endsection

@section('content')


            <div class="invoice-container">
                <div class="invoice-header">
                    <div class="invoice-title date-range">Invoice</div>
                    <div class="date-range">Date Range From: {{ $startDate }} </div>
                    <div class="date-range">Date Range To: {{ $endDate }} </div>
                </div>
                <div class="invoice-details">
                    <div class="details-section">
                        <div class="date-range">Selected Payment Methods:</div>
                        <ul>
                            @php
                                $uniqueFilterNames = [];
                                $uniquePOSNames = [];
                            @endphp

                            @foreach ($transactions as $group)
                                @foreach ($group->payments->whereIn('payment_method_id', $selectedPaymentMethods) as $transaction)
                                    @php
                                        $filterName = $transaction->payment_method->name;
                                    @endphp

                                    @if (!in_array($filterName, $uniqueFilterNames))
                                        <li class="date-range">{{ $filterName }}</li>
                                        @php
                                            $uniqueFilterNames[] = $filterName;
                                        @endphp
                                    @endif
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                    <div class="details-section">
                        <div class="date-range">Point of Sale Names:</div>
                        <ul>
                            @php
                                $uniqueFilterNames = [];
                                $uniquePOSNames = [];
                            @endphp

                            @foreach ($transactions as $group)
                                @php
                                    $posName = $group->pointOfSale->pos_name;
                                @endphp

                                @if (!in_array($posName, $uniquePOSNames))
                                    <li class="date-range">{{ $posName }}</li>
                                    @php
                                        $uniquePOSNames[] = $posName;
                                    @endphp
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>



                @php
                    $rowNumber = 0;
                    $totalAmounts = [];
                    $grandTotal = 0;
                @endphp
                @foreach ($transactions as $group)
                    @foreach ($group->payments as $transaction)
                        @php
                            $showTransaction = true;
                            if ($request->has('payments') && !in_array($transaction->payment_method_id, $request->input('payments'))) {
                                $showTransaction = false;
                            }
                        @endphp
                        @if ($showTransaction)
                            @php
                                $paymentMethodName = $transaction->payment_method->name;
                                if (!isset($totalAmounts[$paymentMethodName])) {
                                    $totalAmounts[$paymentMethodName] = 0;
                                }
                                $totalAmounts[$paymentMethodName] += $transaction->amount;
                                $grandTotal += $transaction->amount;
                            @endphp
                        @endif
                    @endforeach
                @endforeach
                <div class="invoice-table">
                    <div class="date-range">Total Amounts</div>
                    <table>
                        <tr>
                            <th>Method</th>
                            <th>Total Amount</th>
                        </tr>
                        @foreach ($totalAmounts as $method => $totalAmount)
                            <tr>
                                <td>{{ $method }}</td>
                                <td>{{ $totalAmount }} {{ get_currency() }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="invoice-total">
                    <h3>Grand Total</h3>
                    <p>{{ $grandTotal }} {{ get_currency() }}</p>
                </div>
            </div>

    @endsection
