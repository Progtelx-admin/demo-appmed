@extends('layouts.app')

@section('breadcrumb')

<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered "  width="100%">
                <thead>
                    <tr>
                        <th>
                            {{__('ID')}}
                        </th>
                        <th>
                            {{__('name') }}
                        </th>
                        <th>
                            {{__('category') }}
                        </th>
                        <th>
                            {{__('price') }}
                        </th>
                        <th>
                            {{__('position') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                @foreach($categories as $category)
                    <tbody data-id="{{ $category->id }}" class="sortable">
                        <tr>
                            <td colspan="8" style="background-color:#ddd;">{{ $category->name }}</td>
                        </tr>
                        @foreach($category->cultureso as $culture)
                            <tr data-id="{{ $culture->id }}" class="culture">
                                <td>
                                    {{ $culture->id ?? '' }}
                                </td>
                                <td>
                                    {{ $culture->name ?? '' }}
                                </td>
                                <td class="category-name">
                                    {{ $culture->category->name ?? '' }}
                                </td>
                                <td>
                                    {{ $culture->price ?? '' }}
                                </td>
                                <td class="position">
                                    {{ $culture->position ?? '' }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="empty-message" @if($category->cultures->count()) style="display:none;"@endif>
                            <td colspan="8" class="text-center">
                                There are no culture in this category
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>



@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function sendReorderTestsRequest($category) {
        var _token = $('meta[name="csrf-token"]').attr('content');
        var items = $category.sortable('toArray', {attribute: 'data-id'});
        var ids = $.grep(items, (item) => item !== "");

        if ($category.find('tr.culture').length) {
            $category.find('.empty-message').hide();
        }
        $category.find('.category-name').text($category.find('tr:first td').text());

        $.post('{{ route('admin.cultures.reorder') }}', {
                _token,
                ids,
                category_id: $category.data('id')
            })
            .done(function (response) {
                $category.children('tr.culture').each(function (index, culture) {
                    $(culture).children('.position').text(response.positions[$(culture).data('id')])
                });
            })
            .fail(function (response) {
                alert('Error occured while sending reorder request');
                location.reload();
            });
    }

    $(document).ready(function () {
        var $categories = $('table');
        var $cultures = $('.sortable');

        $categories.sortable({
            cancel: 'thead',
            stop: () => {
                var _token = $('meta[name="csrf-token"]').attr('content');
                var items = $categories.sortable('toArray', {attribute: 'data-id'});
                var ids = $.grep(items, (item) => item !== "");
                $.post('{{ route('admin.cultures.cultures_category') }}', {
                        _token,
                        ids
                    })
                    .fail(function (response) {
                        alert('Error occured while sending reorder request');
                        location.reload();
                    });
            }
        });

        $cultures.sortable({
            connectWith: '.sortable',
            items: 'tr.culture',
            stop: (event, ui) => {
                sendReorderTestsRequest($(ui.item).parent());

                if ($(event.target).data('id') != $(ui.item).parent().data('id')) {
                    if ($(event.target).find('tr.culture').length) {
                        sendReorderTestsRequest($(event.target));
                    } else {
                        $(event.target).find('.empty-message').show();
                    }
                }
            }
        });
        $('table, .sortable').disableSelection();
    });
</script>


