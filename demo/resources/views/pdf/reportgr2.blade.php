@extends('layouts.pdf2')
@section('title')
    {{__('Report')}}-#{{$group['id']}}-{{date('Y-m-d')}}
@endsection
@section('content')
<style>
    .test_title{
        font-size: 25px;
        border: 1px solid white!important;
    }
    .beak-page{
        page-break-inside: always!important;
    }
    .subtitle{
        font-size: 15px;
    }
   .test{
       margin-top: 3px;
    }
    .test2{
       margin-top: 20px;
    }
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
        margin-top: 20px;
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
        font-weight: bold;
    }
    .status{
        color:{{$reports_settings['status']['color']}}!important;
        font-size:{{$reports_settings['status']['font-size']}}px!important;
        font-family:{{$reports_settings['status']['font-family']}}!important;
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
</style>
<div class="printable">
    @php 
        $count_categories=0
    @endphp
    @foreach($categories as $category)
        @if(count($category['tests'])||count($category['cultures']))
            @php 
                $count_categories++;
                $count=0;
            @endphp
            @if($count_categories>1)
                <pagebreak>
                </pagebreak>
            @endif
            <table class="table test2 beak-page">
                        <tr>
                            
                        </tr>
            </table>
            <table class="table test2 beak-page">            
                        @if($category['name']<>"Biokimi-2")
                            <tr class="transparent">
                                <th colspan="5"></th>
                            </tr>
                            <tr class="test_head2">
                                <th width="30%" class="text-left">{{__('Test')}}</th>
                                <th width="17.5%">{{__('Result')}}</th>
                                <th width="17.5%">{{__('Unit')}}</th>
                                <th width="17.5%">{{__('Normal Range')}}</th>
                                <th width="17.5%">{{__('Status')}}</th>
                            </tr>
                            @endif
            </table>
            @if(count($category['tests']))
                @foreach($category['tests'] as $test)
                    
                    
                    
                    <table class="table test beak-page">
                        <thead>
                            
                            <tr>
                                @if($category['name']=="Biokimi-2")
                                <th  class="test_title" align="center" colspan="5">
                                    <h5>{{$test['test']['name2']}}</h5>
                                </th>
                                @endif
                            </tr>
                            @if($category['name']=="Biokimi-2")
                            <tr class="transparent">
                                <th colspan="5"></th>
                            </tr>
                            <tr class="test_head">
                                <th width="30%" class="text-left">{{__('Test')}}</th>
                                <th width="17.5%">{{__('Result')}}</th>
                                <th width="17.5%">{{__('Unit')}}</th>
                                <th width="17.5%">{{__('Normal Range')}}</th>
                                <th width="17.5%">{{__('Status')}}</th>
                            </tr>
                                
                            @else
                            <tr class="transparent">
                                <th colspan="5"></th>
                            </tr>
                            <tr class="transparent">
                                <th width="30%">{{__('')}}</th>
                                <th width="17.5%">{{__('')}}</th>
                                <th width="17.5%">{{__('')}}</th>
                                <th width="17.5%">{{__('')}}</th>
                                <th width="17.5%">{{__('')}}</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody class="table-bordered">
                            @foreach($test["results"] as $result)
                                <!-- Title -->
                                @if(isset($result['component']))
                                    @if($result['component']['title'])
                                        
                                    @else
                                    <tr>
                                        <td class="text-captitalize test_name">{{$result["component"]["name2"]}}</td>
                                        <td align="center" class="result">{{$result["result"]}}</td>
                                        <td align="center" class="unit">{{$result["component"]["unit"]}}</td>
                                        <td align="left" class="reference_range">
                                            {!! $result["component"]["reference_range2"] !!}
                                        </td>
                                        @if($result['status']=="High")
                                        <td align="center" class="status">
                                            {{__('High')}}
                                        </td>
                                        @elseif($result['status']=="Low")
                                        <td align="center" class="status">
                                            {{__('Low')}}
                                        </td>
                                        @else
                                        <td align="center" class="status">
                                            {{__('')}}
                                        </td>
                                        @endif
                                    </tr>
                                    @endif
                                @endif
                            @endforeach
                            <!-- Comment -->
                            @if(isset($test['comment']))
                                <tr class="comment">
                                    <td colspan="5">
                                        <table class="comment">
                                            <tbody>
                                                <tr>
                                                    <th width="80px">
                                                        <b>{{__('Comment')}} :</b>
                                                    </th>
                                                    <td>
                                                        {!! str_replace("\n", '<br />',  $test['comment']) !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endif 
                            <!-- /comment -->
                        </tbody>
                    </table>
                @endforeach
            @endif
            
            @if(count($category['cultures']))
                @foreach($category['cultures'] as $culture)
                    @php 
                        $count++;
                    @endphp
                    @if($count>1)
                    <pagebreak>
                    @endif
            

            
                    
                    
                    <!-- culture title -->
                    
                    <!-- /culture title -->
<!-- Comment -->
                    <table class="table table-bordered sensitivity" width="100%">
                        <thead class="test_head">
                                <tr>
                                <th align="left">{{__('Microbiology Examination')}}</th><td>
                                    {{$culture['culture']['sample_type']}}
                                </td>
                                </tr>
                            <tr>
                                <th align="left">{{__('Clinic Culture')}}</th><td>
                                    {{$culture['culture']['name']}}
                                </td></tr>
                                <tr><th align="left">{{__('Result')}}</th><td>
                                    {!! str_replace("\n", '<br />',  $culture['comment']) !!}
                                </td></tr>
                            </tr>
                        </thead>
                        </table>
                    <!-- culture options -->
                    <table class="table" width="100%">
                        <tbody>
                            @foreach($culture['culture_options'] as $culture_option)
                                @if(isset($culture_option['value'])&&isset($culture_option['culture_option']))
                                    <tr>
                                        <th class="no-border test_name" width="10px" nowrap="nowrap" align="left">
                                            <span class="option_title">{{$culture_option['culture_option']['value']}} :</span>
                                        </th>
                                        <td class="no-border result">
                                            {{$culture_option['value']}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /culture options -->

                    <!-- sensitivity -->
                    
                    <table class="table table-bordered sensitivity" width="100%">
                        
                        <thead class="test_head">
                            <tr>
                                <th align="left">{{__('Antibiotics')}}</th>
                                <th align="center">{{__('Microorganism*(1)')}}</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            @foreach($culture['high_antibiotics'] as $antibiotic)
                                <tr>
                                    <td width="200px" nowrap="nowrap" align="left" class="antibiotic_name">
                                        {{$antibiotic['antibiotic']['name2']}}
                                    </td>
                                    <td width="120px" nowrap="nowrap" align="center" class="sensitivity">
                                        {{$antibiotic['sensitivity']}}
                                    </td>
                                </tr>
                                @endforeach
                            

                            @foreach($culture['moderate_antibiotics'] as $antibiotic)
                                <tr>
                                    <td width="200px" nowrap="nowrap" align="left">
                                        {{$antibiotic['antibiotic']['name2']}}
                                    </td>
                                    <td width="120px" nowrap="nowrap" align="center">
                                        {{$antibiotic['sensitivity']}}
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($culture['resident_antibiotics'] as $antibiotic)
                            <tr>
                                <td width="200px" nowrap="nowrap" align="left">
                                    {{$antibiotic['antibiotic']['name2']}}
                                </td>
                                <td width="120px" nowrap="nowrap" align="center">
                                    {{$antibiotic['sensitivity']}}
                                </td>
                                
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>

                    
                        
                        
                        
                    @if(isset($culture['comment']))
                    <table width="100%"  class="comment">
                        <tbody>
                            <tr>
                                <td width="10px" nowrap="nowrap"><b></b></td>
                                
                            </tr>
                        </tbody>
                    </table>     
                    @endif
                    <!-- /comment -->
                    @if($count>1)
                    </pagebreak>
                    @endif
                @endforeach
            @endif
        @endif
    @endforeach

</div>

@endsection