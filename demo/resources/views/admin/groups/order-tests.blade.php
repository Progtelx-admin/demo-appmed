@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Tests for Group {{ $group->id }}</h1>
    <p>Drag and drop the tests to reorder them. Click "Save Order" to update the order in the database.</p>

    <div id="sortable-tests">
        @foreach ($tests as $test)
            <div class="test-item" data-test-id="{{ $test->id }}">
                {{$test['test']['name']}}
            </div>
        @endforeach
    </div>

    <button id="save-order-btn" class="btn btn-primary">Save Order</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    var sortableTests = Sortable.create(document.getElementById('sortable-tests'), {
        animation: 150,
        handle: '.test-item',
        onEnd: function(evt) {
            // Update the order data attribute for each test item
            $('#sortable-tests .test-item').each(function(i) {
                $(this).attr('data-order', i + 1);
            });
        }
    });

    $('#save-order-btn').click(function() {
        // Get the new order of the tests
        var testOrder = [];
        $('#sortable-tests .test-item').each(function() {
            testOrder.push({
                id: $(this).data('test-id'),
                order: $(this).data('order')
            });
        });

        // Send an AJAX request to update the order in the database
        $.ajax({
            url: "{{ route('admin.groups.updateTestOrder',$group->id) }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                testOrder: testOrder
            },
            success: function(response) {
                // Reload the page to show the updated order
                window.location.reload();
            },
            error: function(xhr, status, error) {
                alert('Failed to update test order: ' + error);
            }
        });
    });
});
</script>
@endsection
