<!DOCTYPE html>
<html>
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>
        @yield('title')
    </title>
    <style>
        @if($type==3||$type==4||$type==5||$type==6||$type==7)
        @page {
                margin-top: {{$reports_settings['margin-top']}}px;
                margin-right: {{$reports_settings['margin-right']}}px;
                margin-left: {{$reports_settings['margin-left']}}px;
                margin-bottom: {{$reports_settings['margin-bottom']}}px;
            }
        @else
            @page {
                header: page-header;
                footer: page-footer;
                
                margin-left: {{$reports_settings['margin-left']}}px;
                margin-right: {{$reports_settings['margin-right']}}px;
                
                margin-top: {{$reports_settings['content-margin-top']}}px;
                margin-header: {{$reports_settings['margin-top']}}px;
 
                margin-bottom: {{$reports_settings['content-margin-bottom']}}px;
                margin-footer: {{$reports_settings['margin-bottom']}}px;
 
                @if($visit['branch']['show_watermark_image'])
                    background:url("{{url('uploads/branches/'.$visit['branch']['watermark_image'])}}") no-repeat;
                    background-position: center;
                @endif
            }
        @endif
 
        .table-bordered {
            border: 0.5px solid #dee2e6;
            border-collapse: collapse;
            background-color: white!important;
        }
 
        .table-bordered,
        .table-bordered td {
            border: 0.5px solid #dee2e6;
        }
 
        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 0.5px;
        }  
 
        .table-bordered th,
        .table-bordered td {
            border: 0.5px solid #ddd !important;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        table2{
            margin: auto;
            width: 100%;
            background-color: #80C342;
            border-collapse: collapse;
        }
        table td,th{
            padding: 0px;
        }
        .title{
            background-color: #fff;
        }
        .branch_name{
            color:{{$reports_settings['branch_name']['color']}}!important;
            font-size:{{$reports_settings['branch_name']['font-size']}}!important;
            font-family:{{$reports_settings['branch_name']['font-family']}}!important;
        }
        .branch_info{
            color:{{$reports_settings['branch_info']['color']}}!important;
            font-size:{{$reports_settings['branch_info']['font-size']}}!important;
            font-family:{{$reports_settings['branch_info']['font-family']}}!important;
        }
        .title{
            color:{{$reports_settings['patient_title']['color']}}!important;
            font-size:{{$reports_settings['patient_title']['font-size']}}!important;
            font-family:{{$reports_settings['patient_title']['font-family']}}!important;
        }
        .data{
            color:{{$reports_settings['patient_data']['color']}}!important;
            font-size:{{$reports_settings['patient_data']['font-size']}}!important;
            font-family:{{$reports_settings['patient_data']['font-family']}}!important;
            font-weight:bold;
        }
        .data2{
            color: #fff!important;
            font-size: 18px;
            font-family:{{$reports_settings['patient_data']['font-family']}}!important;
            font-weight:bold;
            background-color: #70bf7e;
            
        }
        .header{
            border:{{$reports_settings['report_header']['border-width']}} solid {{$reports_settings['report_header']['border-color']}};
            background-color:{{$reports_settings['report_header']['background-color']}};
            text-align:{{$reports_settings['report_header']['text-align']}}!important;
        }
        .footer{
            border:{{$reports_settings['report_footer']['border-width']}} solid {{$reports_settings['report_footer']['border-color']}};
            background-color:{{$reports_settings['report_footer']['background-color']}};
            color:{{$reports_settings['report_footer']['color']}}!important;
            font-size:{{$reports_settings['report_footer']['font-size']}}!important;
            font-family:{{$reports_settings['report_footer']['font-family']}}!important;
            text-align:{{$reports_settings['report_footer']['text-align']}}!important;
        }
        .signature{
            color:{{$reports_settings['signature']['color']}}!important;
            font-size:{{$reports_settings['signature']['font-size']}}!important;
            font-family:{{$reports_settings['signature']['font-family']}}!important;
        }
        @if(session('rtl'))
            .pdf-header{
                direction:rtl;
            }
        @endif
    </style>
 
</head>
 
<body>
 
    @if($type!==3&&$type!==4&&$type!==5&&$type!==6&&$type!==7)
        <htmlpageheader name="page-header">
            
            @if($reports_settings['show_header']&&isset($visit['branch']))
                @if($visit['branch']['show_header_image'])
                    <table width="100%" style="padding:0px">
                        <tbody>
                            <tr>
                                <td align="center" style="padding:0px">
                                    <img src="{{url('uploads/branches/'.$visit['branch']['header_image'])}}" alt="" max-height="200">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                <table width="100%" class="pdf-header header">
                    <tbody>
                        <tr>
                            <td width="15%" align="left">
                                <img src="{{url('img/reports_logo.png')}}" width="100px"/>
                            </td>
                            <td width="70%" align="{{$reports_settings['report_header']['text-align']}}">
                                <p class="branch_name">
                                    {{ $visit['branch']['name'] }}
                                </p>
                                <p class="branch_info">
                                    <img src="{{url('img/report_phone.png')}}" width="12px" alt="">
                                    @if(isset($visit['branch']))
                                        {{ $visit['branch']['phone'] }}
                                    @endif
                                </p>
                                <p class="branch_info">
                                    <img src="{{url('img/report_address.png')}}" width="12px" alt=""> 
                                    @if(isset($visit['branch']))
                                        {{$visit['branch']['address'] }}
                                    @endif
                                </p>
                                <p class="branch_info">
                                    <img src="{{url('img/report_email.png')}}" width="12px" alt=""> 
                                    {{$info_settings['email']}}
                                </p>
                                <p class="branch_info">
                                    <img src="{{url('img/report_website.png')}}" width="12px" alt="">
                                    {{ $info_settings['website'] }}
                                </p>
                            </td>
                            <td align="right" width="15%">
                                @if(isset($visit['patient'])&&$reports_settings['show_avatar'])
                                    <img src="@if(!empty($visit['patient']['avatar'])) {{url('uploads/patient-avatar/'.$visit['patient']['avatar'])}} @else {{url('img/avatar.png')}} @endif" max-width="100px" max-height="100px">
                                @endif
                            </td>
                        </tr>
 
                    </tbody>
                </table>
                @endif
            @endif
 
            @if(isset($visit['patient']))
                <table width="100%" class="table table-bordered pdf-header">
                    <tbody>
                        
                        <tr>
                            <td width="50%">
                                <span class="title">{{__('Visit ID:')}}:</span> <span
                                    class="data">
 
                                        {{ $visit['id'] }}
 
                                </span>
                            </td>
                            <td width="50%">
                                <span class="title">{{__('Patient Code')}}:</span> <span
                                    class="data">
                                    @if(isset($visit['patient']))
                                        {{ $visit['patient']['code'] }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <span class="title">{{__('Patient Name')}}:</span> <span
                                    class="data">
                                    @if(isset($visit['patient']))
                                        {{ $visit['patient']['name'] }}
                                    @endif
                                </span>
                            </td>
                           <td>
                                <span class="title">{{__('Age')}}:</span> 
                                  <span class="data">
                               
                                    @if(isset($visit['patient']))
                                        {{$visit['patient']['age']}} 
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{__('Gender')}}:</span> <span
                                    class="data">
                                    @if(isset($visit['patient']))
                                        {{ __($visit['patient']['gender']) }}
                                    @endif
                                </span>
                            </td>
                           <td>
                                <span class="title">{{__('Birth date')}}:</span> 
                                  <span class="data">
                               
                                    @if(isset($visit['patient']))
                                      ({{ $newDate = date("d-m-Y", strtotime($visit['patient']['dob'])) }})   
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{__('Printing Date')}}:</span> 
                                <span class="data">
                                   {{ date('Y-m-d H:i',strtotime($visit['updated_at'])) }}
                                </span>
                            </td>
                            
                         <td>
                                <span class="title">{{__('Residence')}}:</span> <span
                                    class="data">
                                    @if(isset($visit['patient']))
                                        {{ __($visit['patient']['address']) }}
                                    @endif
                                </span>
                        </td>
                             
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{__('Registration Date')}}:</span> 
                                <span class="data">
                                    {{ date('Y-m-d H:i',strtotime($visit['created_at'])) }}
                                </span>
                            </td>
                            <td>
                                    <!--add nomthing-->
                            </td>
                        </tr>
                        
                    </tbody>
                    
                    
                </table> 
                
            @endif
 
        </htmlpageheader>
    @endif
    
    @yield('content')
   
    <htmlpagefooter name="page-footer" class="page-footer">
        @if($type==1)
            @if($reports_settings['show_signature']||$reports_settings['show_qrcode'])
            <table>
                <tbody>
                    <tr>
 
                        
                    </tr>
                    <tr>
 
                        <td width="50%"></td>
                        <td width="40%" align="center">
                            @if($reports_settings['show_signature'])
                                @if(!empty($visit['signed_by']))
                                    <p>
                                        <img src="{{url('uploads/signature/'.$visit['signed_by_user']['signature'])}}" alt="" height="190">
                                    </p>
                                @endif
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif
        @endif
        @if($reports_settings['show_footer'])
            @if($type==1||$type==2)
                @if($visit['branch']['show_footer_image'])
                    <img src="{{url('uploads/branches/'.$visit['branch']['footer_image'])}}" alt="" max-height="200">
                @else
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td class="footer">
                                    {!! str_replace(["\r\n", "\n\r", "\r", "\n"], "<br>", $visit['branch']['report_footer'])!!}
                                </td>   
                            </tr>
                        </tbody>
                    </table>
                @endif
            @endif
        @endif
    </htmlpagefooter>
 
</body>
 
</html>