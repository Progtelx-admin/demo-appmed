@extends('layouts.visits_pdfs_recepsion')
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
        
         .data3{
            /*color:{{$reports_settings['patient_data']['color']}}!important;*/
                     font-family:{{$reports_settings['patient_data']['font-family']}}!important;
         font-size: 15px !important;
            /*font-family:{{$reports_settings['patient_data']['font-family']}}!important;*/
            font-weight:bold;
        }
    </style>

    @if (isset($visit['patient']))
        <table class="table test2 beak-page">
            <tr>
                <th class="data2">
                    <h5>{{ __('SPECIALIST VISIT REPORT') }}</h5>
                </th>
            </tr>
        </table>

        <p></p>
        <table class="table   pdf-header">
           @extends('layouts.visits_pdfs_recepsion')
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
           .new-page-table {
             page-break-inside: avoid;
        }
    </style>



    @if (isset($visit['patient']))
        <table class="table test2 beak-page">
            <tr>
                <th class="data2">
                    <h5>{{ __('SPECIALIST VISIT REPORT') }}</h5>
                </th>
            </tr>
        </table>

        <p></p>
        <!--<table class="table   pdf-header">-->
        <!--    <tr>-->
        <!--        <td>-->
                    <!--<h4 class="data">{{ __('Anamneza') }}</h4><br>-->
        <!--            <h4 class="data">{{ __('Anamneza') }}</h4>-->
        <!--            <span class="title">-->
        <!--                {!! str_replace("\n", '<br />', $visit['anamnesis']) !!}-->
        <!--            </span>-->
        <!--        </td>-->
        <!--    </tr><br></br><br></br>-->
        <!--    <tr>-->
        <!--        <td>-->
        <!--            <h4 class="data">{{ __('Examination') }}</h4>-->
        <!--            <span class="title">-->
        <!--                {!! str_replace("\n", '<br />', $visit['examination']) !!}-->
        <!--            </span>-->
        <!--        </td>-->
        <!--    </tr>-->
        <!--    <br></br><br></br>-->
        <!--    <tr>-->
        <!--        <td>-->
        <!--            <h4 class="data">{{ __('Diagnosis') }}</h4>-->
        <!--            <span class="title">-->
        <!--                {!! str_replace("\n", '<br />', $visit['diagnosis']) !!}-->
        <!--            </span>-->
        <!--        </td>-->
        <!--    </tr>-->
        <!--    <br></br><br></br>-->
        <!--    <tr>-->
        <!--        <td>-->
        <!--            <h4 class="data">{{ __('Therapy') }}</h4>-->
        <!--            <span class="title">-->
        <!--                {!! str_replace("\n", '<br />', $visit['therapy']) !!}-->
        <!--            </span>-->
        <!--        </td>-->
        <!--    </tr><br></br><br></br>-->
        <!--    <tr>-->
        <!--        <td>-->
        <!--            <h4 class="data">{{ __('Recommendation') }}</h4>-->
        <!--            <span class="title">-->
        <!--                {!! str_replace("\n", '<br />', $visit['recommendation']) !!}-->
        <!--            </span>-->
        <!--        </td>-->
        <!--    </tr><br></br><br></br>-->

        <!--    <tr>-->
        <!--        <td>-->
        <!--            <h4 class="data">{{ __('Recommended laboratory tests') }}</h4><br>-->
        <!--            <span>-->
        <!--                @foreach ($visit['tests'] as $test)-->
        <!--                    <span class="title">-->
        <!--                        {{ $test['test']['name'] }}-->
        <!--                    </span><br>-->
        <!--                @endforeach-->
        <!--                @foreach ($visit['cultures'] as $culture)-->
        <!--                    <span class="title">-->
        <!--                        {{ $culture['culture']['name'] }}-->
        <!--                    </span><br>-->
        <!--                @endforeach-->
        <!--                @foreach ($visit['packages'] as $package)-->
        <!--                    <span class="title">-->
        <!--                        {{ $package['package']['name'] }}-->
        <!--                        <span><br>-->
        <!--                            @foreach ($package['tests'] as $test)-->
        <!--                                <span class="title">-->
        <!--                                    {{ $test['test']['name'] }}-->
        <!--                                </span><br>-->
        <!--                            @endforeach-->
        <!--                            @foreach ($package['cultures'] as $culture)-->
        <!--                                <span class="title">-->
        <!--                                    {{ $culture['culture']['name'] }}-->
        <!--                                </span><br>-->
        <!--                            @endforeach-->
        <!--                        </span>-->
        <!--                    </span>-->
        <!--                @endforeach-->
        <!--            </span>-->
        <!--        </td>-->
        <!--    </tr>-->
        <!--</table>-->
              
<div class="new-page-table">
    
<table class="table  pdf-header">
    <tr>
        <td><h4 class="data3">{{ __('Anamneza') }}</h4></td>
    </tr>
   <br>
    <tr>
        <td>
            <span class="title">
                {!! str_replace("\n", '<br />', $visit['anamnesis']) !!}
            </span>
        </td>
    </tr>
</table><br>
</div>
<div class="new-page-table">
    
<table class="table  pdf-header">
    <tr>
        <td><h4 class="data3">{{ __('Examination') }}</h4></td>
    </tr>
    <br>
    <tr>
        <td>
            <span class="title">
                {!! str_replace("\n", '<br />', $visit['examination']) !!}
            </span>
        </td>
    </tr>
</table><br>
</div>
<div class="new-page-table">
    
<table class="table  pdf-header">
    <tr>
        <td><h4 class="data3">{{ __('Diagnosis') }}</h4></td>
    </tr>
    <br>
    <tr>
        <td>
            <span class="title">
                {!! str_replace("\n", '<br />', $visit['diagnosis']) !!}
            </span>
        </td>
    </tr>
</table><br>
</div>
<div class="new-page-table">
    
<table class="table  pdf-header">
    <tr>
        <td><h4 class="data3">{{ __('Therapy') }}</h4></td>
    </tr>
    <br>
    <tr>
        <td>
            <span class="title">
                {!! str_replace("\n", '<br />', $visit['therapy']) !!}
            </span>
        </td>
    </tr>
</table><br>
</div>
<div class="new-page-table">
    
<table class="table  pdf-header">
    <tr>
        <td><h4 class="data3">{{ __('Recommendation') }}</h4></td>
    </tr>
    <br>
    <tr>
        <td>
            <span class="title">
                {!! str_replace("\n", '<br />', $visit['recommendation']) !!}
            </span>
        </td>
    </tr>
</table><br>
</div>
<!--<div class="new-page-table">-->
    
<!--<table class="table   pdf-header">-->
<!--    <tr>-->
<!--        <td><h4 class="data">{{ __('Recommended laboratory tests') }}</h4></td>-->
<!--    </tr>-->
<!--    <br>-->
<!--    <tr>-->
<!--        <td>-->
<!--            <span>-->
<!--                @foreach ($visit['tests'] as $test)-->
<!--                    <span class="title">{{ $test['test']['name'] }}</span><br>-->
<!--                @endforeach-->
<!--                @foreach ($visit['cultures'] as $culture)-->
<!--                    <span class="title">{{ $culture['culture']['name'] }}</span><br>-->
<!--                @endforeach-->
<!--                @foreach ($visit['packages'] as $package)-->
<!--                    <span class="title">-->
<!--                        {{ $package['package']['name'] }}<br>-->
<!--                        @foreach ($package['tests'] as $test)-->
<!--                            <span class="title">{{ $test['test']['name'] }}</span><br>-->
<!--                        @endforeach-->
<!--                        @foreach ($package['cultures'] as $culture)-->
<!--                            <span class="title">{{ $culture['culture']['name'] }}</span><br>-->
<!--                        @endforeach-->
<!--                    </span>-->
<!--                @endforeach-->
<!--            </span>-->
<!--        </td>-->
<!--    </tr>-->
<!--</table>-->
<!--</div>-->


    @endif


@endsection

            <tr>
                <td>
                    <h4 class="data">{{ __('Recommended laboratory tests') }}</h4><br>
                    <span>
                        @foreach ($visit['tests'] as $test)
                            <span class="title">
                                {{ $test['test']['name'] }}
                            </span><br>
                        @endforeach
                        @foreach ($visit['cultures'] as $culture)
                            <span class="title">
                                {{ $culture['culture']['name'] }}
                            </span><br>
                        @endforeach
                        @foreach ($visit['packages'] as $package)
                            <span class="title">
                                {{ $package['package']['name'] }}
                                <span><br>
                                    @foreach ($package['tests'] as $test)
                                        <span class="title">
                                            {{ $test['test']['name'] }}
                                        </span><br>
                                    @endforeach
                                    @foreach ($package['cultures'] as $culture)
                                        <span class="title">
                                            {{ $culture['culture']['name'] }}
                                        </span><br>
                                    @endforeach
                                </span>
                            </span>
                        @endforeach
                    </span>
                </td>
            </tr>
        </table>
    @endif


@endsection
