@extends('layouts.pdf2')
@section('title')
    {{ __('Report') }}-#{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')
    <style>
    
        .transparent-table {
            background-color: transparent;
        }


        .page-break {
            page-break-after: always !important;

        }

        .beak-page {
            page-break-inside: always !important;
        }


        .test_title {
            font-size: 100px;
            border: 1px solid white !important;
        }


        .subtitle {
            font-size: 15px;
        }

        .test {
            margin-top: 3px;
        }

        .test2 {
            margin-top: 30px;
        }

        .transparent {
            border-color: white;
        }

        .transparent th {
            border-color: white;
        }

        .test_head td,
        th {
            border: 1px solid #dee2e6;
        }

        .test_head2 td,
        th {
            border-bottom: 1px solid #dee2e6;
        }

        .no-border {
            border-color: white;
        }

        .comment tr th,
        .comment tr td {
            border-color: white !important;
            vertical-align: top !important;
            text-align: left;
            padding: 0px !important;
        }

        .sensitivity {
            margin-top: 30px;
        }

        .test_title {
            color: {{ $reports_settings['test_title']['color'] }} !important;
            font-size: {{ $reports_settings['test_title']['font-size'] }}px !important;
            font-family: {{ $reports_settings['test_title']['font-family'] }} !important;
        }

        .test_name {
            color: {{ $reports_settings['test_name']['color'] }} !important;
            font-size: {{ $reports_settings['test_name']['font-size'] }}px !important;
            font-family: {{ $reports_settings['test_name']['font-family'] }} !important;
        }

        .test_head th {
            color: {{ $reports_settings['test_head']['color'] }} !important;
            font-size: {{ $reports_settings['test_head']['font-size'] }}px !important;
            font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
        }

        .test_head2 th {
            color: {{ $reports_settings['test_head']['color'] }} !important;
            font-size: {{ $reports_settings['test_head']['font-size'] }}px !important;
            font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
        }

        .unit {
            color: {{ $reports_settings['unit']['color'] }} !important;
            font-size: {{ $reports_settings['unit']['font-size'] }}px !important;
            font-family: {{ $reports_settings['unit']['font-family'] }} !important;
        }

        .reference_range {
            color: {{ $reports_settings['reference_range']['color'] }} !important;
            font-size: {{ $reports_settings['reference_range']['font-size'] }}px !important;
            font-family: {{ $reports_settings['reference_range']['font-family'] }} !important;
        }

        .result {
            color: {{ $reports_settings['result']['color'] }} !important;
            font-size: {{ $reports_settings['result']['font-size'] }}px !important;
            font-family: {{ $reports_settings['result']['font-family'] }} !important;
        }

        .status {
            color: {{ $reports_settings['status']['color'] }} !important;
            font-size: {{ $reports_settings['status']['font-size'] }}px !important;
            font-family: {{ $reports_settings['status']['font-family'] }} !important;
        }

        .comment th,
        .comment td {
            color: {{ $reports_settings['comment']['color'] }} !important;
            font-size: {{ $reports_settings['comment']['font-size'] }}px !important;
            font-family: {{ $reports_settings['comment']['font-family'] }} !important;
        }

        .antibiotic_name {
            color: {{ $reports_settings['antibiotic_name']['color'] }} !important;
            font-size: {{ $reports_settings['antibiotic_name']['font-size'] }}px !important;
            font-family: {{ $reports_settings['antibiotic_name']['font-family'] }} !important;
        }

        .sensitivity {
            color: {{ $reports_settings['sensitivity']['color'] }} !important;
            font-size: {{ $reports_settings['sensitivity']['font-size'] }}px !important;
            font-family: {{ $reports_settings['sensitivity']['font-family'] }} !important;
        }

        .commercial_name {
            color: {{ $reports_settings['commercial_name']['color'] }} !important;
            font-size: {{ $reports_settings['commercial_name']['font-size'] }}px !important;
            font-family: {{ $reports_settings['commercial_name']['font-family'] }} !important;
        }
        
        
        td.text-captitalize.test_name {
          padding-left: 5px;
        }

    </style>
    
    <?php
        // Get all the category names,position,id and their count
    $categoryCounts = $group->all_tests
        ->flatMap(function ($test) {
            return $test->results->groupBy('test.category.name')->map(function ($results, $categoryName) {
                $position = $results->first()->test->category->position;
                $catid = $results->first()->test->category->id;
                return [$categoryName, $position,$catid, count($results)];
            });
        })
        ->reduce(function ($carry, $count) {
            [$categoryName, $position,$catid, $categoryCount] = $count;
            $carry[$categoryName] = [
                'count' => ($carry[$categoryName]['count'] ?? 0) + $categoryCount,
                'position' => $position,
                'id' => $catid,
            ];
            return $carry;
        }, []);
    
    uasort($categoryCounts, function ($a, $b) {
        return $a['position'] <=> $b['position'];
    });
    ?>
    
    
    <div class="printable">
        @php
            $count_categories = 0;
        @endphp

        @foreach ($categoryCounts as $categoryName => $categoryCount)
            @php
                $count_categories++;
                $count = 0;
                $catid = $categoryCount['id'];
            @endphp

            @if ($count_categories > 1 && ($last_category_count == 10 || $last_category_count == 24) && ($catid != 10 && $catid != 24))
                <pagebreak></pagebreak>
            @endif
        
            @if ($count_categories > 1 && ($catid == 10 || $catid == 24))
                <pagebreak></pagebreak>
            @endif
            <div class="table test2 beak-page">
                <table class="table test2 beak-page">
                    <tr>
                        <!--<th class="data2">-->
                        <!--  <h5>{{ __('LABORATORY ANALYSIS REPORT') }}</h5>-->
                        <!--</th>-->
                        <th class="data2">
                          <h5>{{ strtoupper($categoryName) }}</h5>
                        </th>
                    </tr>
                </table>
                <table class="table-bordered transparent-table">
                    <tbody>
                        @if ($categoryName != 'Biokimi-2' && $categoryName != 'Mikrobiologji')
                            <tr class="test_head">
                                <th width="30%" class="text-left">{{ __('Test') }}</th>
                                <th width="30%">{{ __('Result') }}</th>
                                <th width="17.5%">{{ __('Normal Range') }}</th>
                                <th width="17.5%">{{ __('Unit') }}</th>
                            </tr>
                        @endif

                        @foreach ($group->all_tests as $test)
                            <?php
                            $results = $test->results->where('test.category.name', $categoryName);
                            $shown_titles = [];
                            $shown_comment = [];
                            ?>
                            @if ($results->count() > 0)
                                @foreach ($results as $result)
                                    @if (
                                        ($categoryName == 'Biokimi-2' || $categoryName == 'Mikrobiologji') &&
                                            $test->test->id == $result->test->parent_id &&
                                            !in_array($test->test->name, $shown_titles))
                                        <tr>
                                            <th class="test_title" align="center" colspan="5">
                                                <h5>{{ $test->test->name }}</h5>
                                            </th>
                                        </tr>
                                        <tr class="test_head">
                                            <th width="30%" class="text-left">{{ __('Test') }}</th>
                                            <th width="30%">{{ __('Result') }}</th>
                                            <th width="17.5%">{{ __('Normal Range') }}</th>
                                            <th width="17.5%">{{ __('Unit') }}</th>
                                        </tr>
                                        <?php $shown_titles[] = $test->test->name; ?>
                                    @endif
                                @endforeach
                                @foreach ($results as $result)
                                    <tr>
                                        @if ($result->test->name == 'Sendimenti i urines')
                                            <td class="text-captitalize test_name" style="padding-left: 5px;">
                                                {{ $result->test->name }}
                                            </td>
                                            <td colspan="3" align="center">
                                                <span>{{ $result->result }}</span>
                                            </td>
                                        @else
                                            <td class="text-captitalize test_name" style="padding-left: 5px;">{{ $result->test->name }}</td>
                                            <td align="center">
                                                <span>{{ $result->result }}</span>
                                                @if ($result['status'] == 'High')
                                                    <span>{{ __('H') }}</span>
                                                @elseif($result['status'] == 'Low')
                                                    <span>{{ __('L') }}</span>
                                                @else
                                                    <span>{{ __('') }}</span>
                                                @endif
                                            </td>
                                            <td align="center" class="reference_range">{!! $result->test->reference_range !!}</td>
                                            <td align="center" class="unit">{{ $result->test->unit }}</td>
                                        @endif
                                    </tr>
                                @endforeach


                                @if (isset($test->comment) && !in_array($test->comment, $shown_comment))
                                    <tr class="comment">
                                        <td colspan="4">
                                            <table class="comment">
                                                <tbody>
                                                    <tr>
                                                        <th width="80px">
                                                            <b>{{ __('Interpretimi Mjekësor') }} :</b>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="comment">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            {!! str_replace("\n", '<br />', $test->comment) !!}
                                                        </td>
                                                    </tr>
                                                    <?php $shown_comment[] = $test->comment; ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="test_title" align="center" colspan="4">
                                            <h5> </h5>
                                        </th>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
            @php
                $last_category_count = $catid;
            @endphp
        @endforeach
    </div>
@endsection
