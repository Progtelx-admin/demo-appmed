@extends('layouts.pdf')
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
       margin-top: 30px;
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
</style>


<body><htmlpageheader name="page-header">
            
            @if($reports_settings['show_header']&&isset($group['branch']))
                @if($group['branch']['show_header_image'])
                    <table width="100%" style="padding:0px">
                        <tbody>
                            <tr>
                                <td align="center" style="padding:0px">
                                    <img src="{{url('uploads/branches/'.$group['branch']['header_image'])}}" alt="" max-height="200">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            @endif
    
    <h2 class="text-center"></h2>
    
    @if(isset($group['patient']))
        <table width="100%" class="table table-bordered pdf-header">
            <tbody>
                <tr>
                    <td width="50%">
                        <span class="title">{{__('Visit id')}} :</span> 
                        <span class="data">
                            {{$group['id']}}
                        </span>
                    </td>
                    <td width="50%">
                        <span class="title">{{__('Patient Code')}} :</span> <span
                            class="data">
                            @if(isset($group['patient']))
                                {{ $group['patient']['code'] }}
                            @endif
                        </span>

                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <span class="title">{{__('Patient Name')}} :</span> <span
                            class="data">
                            @if(isset($group['patient']))
                                {{ $group['patient']['name'] }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="title">{{__('Age')}} :</span> 
                        <span class="data">
                            @if(isset($group['patient']))
                                {{$group['patient']['age']}}
                            @endif
                        </span>

                    </td>
                </tr>
                <tr>
                    
                    <td>
                        <span class="title">{{__('Gender')}} :</span> <span
                            class="data">
                            @if(isset($group['patient']))
                                {{ __($group['patient']['gender']) }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="title">{{__('Birth date')}} :</span> 
                        <span class="data">
                            @if(isset($group['patient']))
                                {{$group['patient']['dob']}}
                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    
                    <td>
                        <span class="title">{{__('Printing Date')}} :</span> <span
                            class="data">
                        <span class="data">
                            {{ get_system_date() }}
                        </span>
                    </td>
                     <td>
                        <span class="title">{{__('Address')}} :</span> 
                        <span class="data">
                            @if(isset($group['patient']))
                                {{$group['patient']['address']}}
                            @endif
                        </span>
                    </td>
                </tr>
                <tr><td>
                                <span class="title">{{__('Registration Date')}} :</span> 
                                <span class="data">
                                    {{ date('Y-m-d H:i',strtotime($group['created_at'])) }}
                                </span>
                            </td>
                            <td>
                                <span class="title">{{__('Visit Validation')}} :</span> 
                                <span class="data">
                                    {{ date('Y-m-d H:i',strtotime($group['updated_at'])) }}
                                </span>
                            </td>
                </tr>

                

            </tbody>
            
        </table> 
        <table class="table test2 beak-page">
                        <tr>
                            <th class="data2">
                                <h5>{{__('SPECIALIST VISIT REPORT')}}</h5>
                            </th>
                        </tr>
            </table>
        
        <p></p>
        <table class="table table-bordered pdf-header"><tr><td>
        <h4 class="data">{{__('Lloji i Vizites')}}</h4>
        <ul>
            <li class="title">
                {{__('Vizite ')}}{{$group['visit_type']}}</li>
                
            </ul></td></tr><br></br>
            <tr><td>
               
        <h4 class="data">{{__('Anamneza-Gjendja e pacientit')}}</h4>
        <ul><p></p>
            <li class="title">
                {!! str_replace("\n", '<br />', $group['anamnesis']) !!}
            </li>
            </ul></td></tr><br></br>
            <tr><td>
            <h4 class="data">{{__('Diagnoza')}}</h4>
        <ul>
            <li class="title">
                {!! str_replace("\n", '<br />', $group['diagnosis']) !!}
            </li>
            </ul>
            </td></tr><br></br>
           <tr><td>
        <h4 class="data">{{__('Terapia')}}</h4>
        
            <ul><li class="title">{!! str_replace("\n", '<br />', $group['therapy']) !!}</li></ul></td></tr><br></br>
            <tr><td>
                <h4 class="data">{{__('Rekomandimi')}}</h4>
                <ul><li class="title">
                {!! str_replace("\n", '<br />', $group['recommendation']) !!}
                
            </li></ul></td></tr><br></br>
           <tr><td>
        <h4 class="data">{{__('Testet laboratorike te rekomanduara')}}</h4>
        <ul>
            @foreach($group['tests'] as $test)
            <li class="title">
                {{$test['test']['name']}}
            </li>
            @endforeach
            @foreach($group['cultures'] as $culture)
            <li class="title">
                {{$culture['culture']['name']}}
            </li>
            @endforeach
            @foreach($group['packages'] as $package)
            <li class="title">
                {{$package['package']['name']}}
                <ul>
                    @foreach($package['tests'] as $test)
                    <li class="title">
                        {{$test['test']['name']}}
                    </li>
                    @endforeach
                    @foreach($package['cultures'] as $culture)
                    <li class="title">
                        {{$culture['culture']['name']}}
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul></td></tr></table>
        
    @endif
    

 
</body>


                  
</html>

@endsection