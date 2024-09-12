@extends('layouts.pdf_doc_lab_mikro')
@section('title')
    {{ __('Report') }}-#{{ $group['id'] }}-{{ date('Y-m-d') }}
@endsection
@section('content')
   <style>
        .test_title {
            font-size: 25px;
            border: 1px solid white !important;
        }

        .beak-page {
            page-break-inside: always !important;
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
        
        .sensitivityTable {
            /* margin-bottom: 30px; */
            margin-top: 20px;
            margin-left: 5px
        }
        .sensitivityTable table tr td {
            padding: 5px;
            font-family: {{ $reports_settings['patient_data']['font-family'] }} !important;
            /* font-size: {{ $reports_settings['test_head']['font-size'] }}px !important; */
            /* font-family: {{ $reports_settings['test_head']['font-family'] }} !important; */

        }
        
        .explanation {
            margin-top: 5px;
            color: {{ $reports_settings['unit']['color'] }} !important;
            font-size: {{ $reports_settings['unit']['font-size'] }}px !important;
            font-family: {{ $reports_settings['unit']['font-family'] }} !important;
            margin-left: 100px;

        }
        
        .results table tr td {
            /* padding-left: 7px !important; */
            /* font-size: {{ $reports_settings['test_head']['font-size'] }}px !important; */
            padding: 5px;
            color: {{ $reports_settings['unit']['color'] }} !important;
            font-size: {{ $reports_settings['unit']['font-size'] }}px !important;
            font-family: {{ $reports_settings['unit']['font-family'] }} !important;
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
            font-weight: bold;
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
    </style>

    <div class="printable">
        @php
            $count_categories = 0;
        @endphp
        @foreach ($categories as $category)
            @if (count($category['cultures']))
                @php
                $categoryId = $category['id'];
                    $count_categories++;
                    $count = 0;
                @endphp
                @if ($count_categories > 1)
                    <pagebreak>
                    </pagebreak>
                @endif






                @if (count($category['cultures']))
                    @foreach ($category['cultures'] as $culture)
                        @php
                            $count++;
                        @endphp
                        @if ($count > 1)
                            <pagebreak>
                        @endif
                        
                <table>
                    <tr>
                        <th class="data2">
                            <h5>{{ __('RAPORT I EKZAMINIMIT MIKROBIOLOGJIK') }}</h5>
                        </th>
                    </tr>
                </table>
                <!--<div class=" data2">-->
                <!--    RAPORT I EKZAMINIMIT MIKROBIOLOGJIK-->
                <!--</div>-->
                        <div class="results">
                            
                            <table class="table table-bordered sensitivity" width="100%">
                                <tr>
                                    <td>
                                        {{ __('Clinic Culture') }}
                                    </td>
                                    <td style ="width: 0;">
                                        {{ $culture['culture']['sample_type'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ __('Microbiology Examination') }}
                                    </td>
                                    <td style ="width: 0;">
                                        {{ $culture['culture']['name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ __('Result') }}
                                    </td>
                                    <td style ="width: 0;">
                                        <strong>
                                            {!! str_replace("\n", '<br />', $culture['result']) !!}
                                        </strong>
                                        <br>
                                    @if ($categoryId != 77)
                                        {!! str_replace("\n", '<br />', $culture['comment']) !!}
                                    @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
  @php
                            $totalAntibiotics = count($culture['high_antibiotics']) + count($culture['moderate_antibiotics']) + count($culture['resident_antibiotics']);
                        @endphp

                        @if ($totalAntibiotics > 0)
                        <div class="sensitivityTable">
                            <!--     <div class=" antibiogram">-->
                            <!--    <strong>-->
                            <!--       ANTIBIOGRAMI-->
                            <!--    </strong>-->
                            <!--</div>-->
                            <table>
                                <tr>
                                    <th class="data3 transparent">
                                        <h5>{{ __('ANTIBIOGRAMI') }}</h5>
                                    </th>
                                </tr>
                            </table>
                            <table class="table table-bordered sensitivity" width="100%">

                                <tr class="test_head">
                                    <td>
                                        <strong>
                                            {{ __('Antibiotics') }}
                                        </strong>
                                    </td>
                                    <td style ="width: 20%; text-align:center">
                                        <strong>
                                            Ndjeshmeria
                                        </strong>
                                    </td>
                                </tr>



                                @foreach ($culture['high_antibiotics'] as $antibiotic)
                                    <tr>
                                        <td>
                                            {{ $antibiotic['antibiotic']['name'] }}
                                        </td>
                                        <td style ="width: 20%; text-align:center">
                                            @if ($antibiotic['sensitivity'] === 'Rezistent')
                                                R
                                            @elseif($antibiotic['sensitivity'] === 'Sensitiv')
                                                S
                                            @elseif($antibiotic['sensitivity'] === 'Intermediar')
                                                I
                                            @else
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                                @foreach ($culture['moderate_antibiotics'] as $antibiotic)
                                    <tr>
                                        <td>
                                            {{ $antibiotic['antibiotic']['name'] }}
                                        </td>
                                        <td style ="width: 20%; text-align:center">
                                            @if ($antibiotic['sensitivity'] === 'Rezistent')
                                                R
                                            @elseif($antibiotic['sensitivity'] === 'Sensitiv')
                                                S
                                            @elseif($antibiotic['sensitivity'] === 'Intermediar')
                                                I
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                @foreach ($culture['resident_antibiotics'] as $antibiotic)
                                    <tr>
                                        <td>
                                            {{ $antibiotic['antibiotic']['name'] }}
                                        </td>
                                        <td style ="width: 20%; text-align:center">
                                            @if ($antibiotic['sensitivity'] === 'Rezistent')
                                                R
                                            @elseif($antibiotic['sensitivity'] === 'Sensitiv')
                                                S
                                            @elseif($antibiotic['sensitivity'] === 'Intermediar')
                                                I
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach

                            </table>
                            <!--<div class="explanation">-->
                            <!--    <table>-->
                            <!--        <tr>-->
                            <!--            <td><strong>-->
                            <!--                    S - Sensitiv-->
                            <!--                </strong>-->
                            <!--            </td>-->
                            <!--            <td>-->
                            <!--                <strong>-->

                            <!--                    I - Intermediar-->
                            <!--                </strong>-->
                            <!--            </td>-->
                            <!--            <td>-->
                            <!--                <strong>-->

                            <!--                    R - Rezistent-->
                            <!--                </strong>-->
                            <!--            </td>-->

                            <!--        </tr>-->
                            <!--    </table>-->
                            <!--</div>-->
                            <br>
                            <table style="width: 100%;">
                                <tr>
                                    <th class="data3 transparent" style="width: 33.33%;">
                                        <h5>{{ __('S-Sensitiv ') }}</h5>
                                    </th>
                                    <th class="data3 transparent" style="width: 33.33%;">
                                        <h5>{{ __(' I-Intermediar ') }}</h5>
                                    </th>
                                    <th class="data3 transparent" style="width: 33.33%;">
                                        <h5>{{ __('R-Rezistent ') }}</h5>
                                    </th>
                                </tr>
                            </table>

                        </div>
                           @endif
                           <br>
                           <div class="commentOfRapid" >

                                    @if ($categoryId == 77)
                                    <table>
                                        <tr>
                                            <td>
                                                    {!! str_replace("\n", '<br />', $culture['comment']) !!}
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    @endif

                            </div>
                    @endforeach
                @endif
            @endif
        @endforeach
    </div>



@endsection
