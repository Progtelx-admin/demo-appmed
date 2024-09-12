@extends('layouts.visits_pdfs')
@section('content')
<style>
    .test_title{
        font-size: 25px;
        border: 1px solid white!important;
    }
   .beak-page{
    page-break-after: always!important;
}

    .subtitle{
        font-size: 15px;
    }
   .test{
       margin-top: 3px;
    }
    /*.test2{*/
    /*   margin-top: 10px;*/
    /*}*/
    .transparent{
        border-color: white;
    }
    .transparent th{
        border-color: white;
    }
    .test_head td,th{
        border: 1px solid #dee2e6;
    }
    .test_head2 td,th{
        border-bottom: 1px solid #dee2e6;
    }
    .no-border{
        border-color: white;
    }
    .comment tr th,.comment tr td{
        border-color: white!important;
        vertical-align: top!important;
        text-align: left;
        padding:0px!important;
    }
    .sensitivity{
        margin-top: 30px;
    }
    .test_title{
        color:{{$reports_settings['test_title']['color']}}!important;
        font-size:{{$reports_settings['test_title']['font-size']}}px!important;
        font-family:{{$reports_settings['test_title']['font-family']}}!important;
    }
    .test_name{
        color:{{$reports_settings['test_name']['color']}}!important;
        font-size:{{$reports_settings['test_name']['font-size']}}px!important;
        font-family:{{$reports_settings['test_name']['font-family']}}!important;
    }
    .test_head th{
        color:{{$reports_settings['test_head']['color']}}!important;
        font-size:{{$reports_settings['test_head']['font-size']}}px!important;
        font-family:{{$reports_settings['test_head']['font-family']}}!important;
    }
    .test_head2 th{
        color:{{$reports_settings['test_head']['color']}}!important;
        font-size:{{$reports_settings['test_head']['font-size']}}px!important;
        font-family:{{$reports_settings['test_head']['font-family']}}!important;
    }
    .unit{
        color:{{$reports_settings['unit']['color']}}!important;
        font-size:{{$reports_settings['unit']['font-size']}}px!important;
        font-family:{{$reports_settings['unit']['font-family']}}!important;
    }
    .reference_range{
        color:{{$reports_settings['reference_range']['color']}}!important;
        font-size:{{$reports_settings['reference_range']['font-size']}}px!important;
        font-family:{{$reports_settings['reference_range']['font-family']}}!important;
    }
    .result{
        color:{{$reports_settings['result']['color']}}!important;
        font-size:{{$reports_settings['result']['font-size']}}px!important;
        font-family:{{$reports_settings['result']['font-family']}}!important;
    }
    .status{
        color:{{$reports_settings['status']['color']}}!important;
        font-size:{{$reports_settings['status']['font-size']}}px!important;
        font-family:{{$reports_settings['status']['font-family']}}!important;
        font-weight: bold;
    }
    .comment th,.comment td{
        color:{{$reports_settings['comment']['color']}}!important;
        font-size:{{$reports_settings['comment']['font-size']}}px!important;
        font-family:{{$reports_settings['comment']['font-family']}}!important;
    }
    .antibiotic_name{
        color:{{$reports_settings['antibiotic_name']['color']}}!important;
        font-size:{{$reports_settings['antibiotic_name']['font-size']}}px!important;
        font-family:{{$reports_settings['antibiotic_name']['font-family']}}!important;
    }
    .sensitivity{
        color:{{$reports_settings['sensitivity']['color']}}!important;
        font-size:{{$reports_settings['sensitivity']['font-size']}}px!important;
        font-family:{{$reports_settings['sensitivity']['font-family']}}!important;
    }
    .commercial_name{
        color:{{$reports_settings['commercial_name']['color']}}!important;
        font-size:{{$reports_settings['commercial_name']['font-size']}}px!important;
        font-family:{{$reports_settings['commercial_name']['font-family']}}!important;
    }
    
    /*.raportTable h4 {*/
    /*   margin-bottom:20px !important;*/
    /*}*/
    
 
    /*.data2 {*/
    /*    font-size:30px !important;*/
    /*}*/
    
    .data3 {
         font-family:{{$reports_settings['patient_data']['font-family']}}!important;
            font-weight:bold;
            font-size: 15px !important;
    }
    
    /*.raportTable td {*/
    /*    margin-bottom: 30px !important;*/
    /*}*/
    
  .raportTable {
        border-collapse: collapse;
        width: 100%;
        margin-bottom:30px;
    }

    .raportTable tr {
        border-bottom: 1px solid #ccc;
    }

    .raportTable h4 {
        margin: 10px 0; /* Add spacing above and below the headings */
    }

    .raportTable td {
        padding: 10px;
    }

    .spacer-row td {
        padding: 0; /* Remove padding for spacer rows */
    }

    .title1 {
        display: block; /* Ensure proper line breaks for content */
        text-align: right; /* Align text to the right */
    }
    
        @media print {
            body {
                /*width: 210mm;*/
                /*height: 297mm;*/
                /*margin: 0; */
            }
        }
        
    /* .page-section {*/
    /*    page-break-before: always;*/
    /*}*/
    .page-section {
    page-break-inside: avoid;
}

    
    
</style>


    
    @if(isset($visit['patient']))

        <table class="table test2">
            <!--<table class="table test2 beak-page">-->
                        <tr>
                            <th class="data2">
                                <h5>{{__('SPECIALIST VISIT REPORT')}}</h5>
                            </th>
                        </tr>
            </table>
        
        <p></p>
<table class="raportTable">
    <!-- Anamneza -->
    <tr>
        <td colspan="2">
            <h4 class="data3">{{__('Anamneza')}}</h4>
        </td>
    </tr>
<tr>
    <td colspan="2">
        <span class="title1">
            {!! nl2br(str_replace('<', '&lt;', $visit['anamnesis'])) !!}
        </span>
    </td>
</tr>


    <tr class="spacer-row">
        <td colspan="2"></td>
    </tr>
    <div class="page-section">
    <!-- Examination -->
    <tr>
        <td colspan="2">
            <h4 class="data3">{{__('Examination')}}</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <span class="title1">
                {!! str_replace("\n", '<br />', $visit['examination']) !!}
            </span>
        </td>
    </tr>
    <tr class="spacer-row">
        <td colspan="2"></td>
    </tr>
    </div>
    <div class="page-section">
    <!-- Diagnosis -->
    <tr>
        <td colspan="2">
            <h4 class="data3">{{__('Diagnosis')}}</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <span class="title1">
                {!! str_replace("\n", '<br />', $visit['diagnosis']) !!}
            </span>
        </td>
    </tr>
    <tr class="spacer-row">
        <td colspan="2"></td>
    </tr>
    </div>
    <div class="page-section">
    <!-- Therapy -->
    <tr>
        <td colspan="2">
            <h4 class="data3">{{__('Therapy')}}</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <span class="title1">
                {!! str_replace("\n", '<br />', $visit['therapy']) !!}
            </span>
        </td>
    </tr>
    <tr class="spacer-row">
        <td colspan="2"></td>
    </tr>
    </div>
    <div class="page-section">
    <!-- Recommendation -->
    <tr>
        <td colspan="2">
            <h4 class="data3">{{__('Recommendation')}}</h4>
        </td>
    </tr>
    <tr  style="max-width: 80%; margin-bottom:30px !important;">
        <td colspan="2">
            <span class="title1">
                {!! str_replace("\n", '<br />', $visit['recommendation']) !!}
            </span>
        </td>
    </tr>
    </div>
</table>
        
    @endif


@endsection