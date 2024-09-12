@extends('layouts.app')

@section('title')
    {{__('Point Of Sales')}}
@endsection

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-flag"></i>
                        {{ __('Point Of Sale') }}
                    </h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Point of Sale List') }}
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.pointofsales.create') }}" class="btn btn-primary mb-3">{{ __('Create Point of Sale') }}</a>

                        <table id="posTable" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('POS Name') }}</th>
                                <th>{{ __('POS Location') }}</th>
                                <th>{{ __('Cash in Hand') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through POS entries and populate the table rows -->
                            @foreach($posList as $pos)
                            <tr>
                                <td>{{ $pos->id }}</td>
                                <td>{{ $pos->pos_name }}</td>
                                <td>{{ $pos->pos_location }}</td>
                                <td>{{ $pos->cash_in_hand }}</td>
                                <td>
                                    <!-- Add edit and delete buttons -->
                                    <a href="{{ route('admin.pointofsales.edit', $pos->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.pointofsales.destroy', $pos->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <strong>{{ __('Total Cash in Hand') }}:</strong> {{ $cashInHandSum }}
                    </div>
                    <div id="totalCashInHand" class="mt-3">
                        <strong>{{ __('Total Cash in Hand Filter') }}:</strong> Calculating...
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
        $('#posTable').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#posTable').DataTable();

        // Function to recalculate and update the total cash in hand
        function updateTotalCashInHand() {
            var total = 0;
            table.rows({ search: 'applied' }).data().each(function(rowData) {
                total += parseFloat(rowData[3]);
            });
            $('#totalCashInHand').html('<strong>{{ __('Total Cash in Hand Filter') }}:</strong> ' + total.toFixed(2));
        }

        // Initial calculation and update
        updateTotalCashInHand();

        // Update when the search event is triggered
        table.on('search.dt', function() {
            updateTotalCashInHand();
        });
    });
</script>


@endsection
