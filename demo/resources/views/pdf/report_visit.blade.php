@extends('layouts.pdf')

@section('content')
<style>
    .receipt_title td,th{
        border-color: white;
    }
    .receipt_title .total{
        background-color: #ddd;
    }
    .table th{
        color:{{$reports_settings['test_head']['color']}}!important;
        font-size:{{$reports_settings['test_head']['font-size']}}!important;
        font-family:{{$reports_settings['test_head']['font-family']}}!important;
    }
    .total{
        font-family:{{$reports_settings['test_head']['font-family']}}!important;
    }

    .due_date{
        font-family:{{$reports_settings['test_head']['font-family']}}!important;
    }

    .test_name{
        color:{{$reports_settings['test_name']['color']}}!important;
        font-size:{{$reports_settings['test_name']['font-size']}}!important;
        font-family:{{$reports_settings['test_name']['font-family']}}!important;
    }
    .test_head th{
        color:{{$reports_settings['test_head']['color']}}!important;
        font-size:{{$reports_settings['test_head']['font-size']}}px!important;
        font-family:{{$reports_settings['test_head']['font-family']}}!important;
    }
    .text-center{
        text-align: center;
        padding:125px!important;
    }
    .body, h1, h2, h3, h4, h5, h6, li, ul{
        font-family: Arial, Helvetica, sans-serif;
        vertical-align: top!important;
        text-align: left;
        padding:0px!important;
        
    }
}
   
</style>

<div class="invoice">
    
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
        <p></p>
        <table class="table table-bordered pdf-header"><tr><td>
        <h4>{{__('Lloji i Vizites')}}</h4>
        <ul>
            <li>
                {{__('Vizite ')}}{{$group['visit_type']}}</li>
                
            </ul></td></tr><br></br>
            <tr><td>
               
        <h4>{{__('Anamneza-Gjendja e pacientit')}}</h4>
        <ul><p></p>
            <li>
                {!! str_replace("\n", '<br />', $group['anamnesis']) !!}
            </li>
            </ul></td></tr><br></br>
            <tr><td>
            <h4>{{__('Diagnoza')}}</h4>
        <ul>
            <li>
                {!! str_replace("\n", '<br />', $group['diagnosis']) !!}
            </li>
            </ul>
            </td></tr><br></br>
           <tr><td>
        <h4>{{__('Terapia')}}</h4>
        
            <ul><li>{!! str_replace("\n", '<br />', $group['therapy']) !!}</li></ul></td></tr><br></br>
            <tr><td>
                <h4>{{__('Rekomandimi')}}</h4>
                <ul><li>
                {!! str_replace("\n", '<br />', $group['recommendation']) !!}
                
            </li></ul></td></tr><br></br>
           <tr><td>
        <h4>{{__('Testet laboratorike te rekomanduara')}}</h4>
        <ul>
            @foreach($group['tests'] as $test)
            <li>
                {{$test['test']['name']}}
            </li>
            @endforeach
            @foreach($group['cultures'] as $culture)
            <li>
                {{$culture['culture']['name']}}
            </li>
            @endforeach
            @foreach($group['packages'] as $package)
            <li>
                {{$package['package']['name']}}
                <ul>
                    @foreach($package['tests'] as $test)
                    <li>
                        {{$test['test']['name']}}
                    </li>
                    @endforeach
                    @foreach($package['cultures'] as $culture)
                    <li>
                        {{$culture['culture']['name']}}
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul></td></tr></table>
        
    @endif
</div>

@endsection