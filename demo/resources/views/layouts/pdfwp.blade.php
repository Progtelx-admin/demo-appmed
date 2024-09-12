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

                @if($group['branch']['show_watermark_image'])
                    background:url("{{url('uploads/branches/'.$group['branch']['watermark_image'])}}") no-repeat;
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
        table td,th{
            padding: 0px;
        }
        .title{
            background-color: #fff;
            font-weight:bold;
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
            
            @if($reports_settings['show_header']&&isset($group['branch']))
                @if($group['branch']['show_header_image'])
                    <table width="100%" style="padding:0px">
                        <tbody>
                            <tr>
                                <td align="center" style="padding:50px">
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
                                    {{ $group['branch']['name'] }}
                                </p>
                                <p class="branch_info">
                                    <img src="{{url('img/report_phone.png')}}" width="12px" alt="">
                                    @if(isset($group['branch']))
                                        {{ $group['branch']['phone'] }}
                                    @endif
                                </p>
                                <p class="branch_info">
                                    <img src="{{url('img/report_address.png')}}" width="12px" alt=""> 
                                    @if(isset($group['branch']))
                                        {{$group['branch']['address'] }}
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
                                @if(isset($group['patient'])&&$reports_settings['show_avatar'])
                                    <img src="@if(!empty($group['patient']['avatar'])) {{url('uploads/patient-avatar/'.$group['patient']['avatar'])}} @else {{url('img/avatar.png')}} @endif" max-width="100px" max-height="100px">
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
                @endif
            @endif

            @if(isset($group['patient']))
                <table width="100%" class="table table-bordered pdf-header">
                    <tbody>
                        
                        <tr>
                            <td width="50%">
                                <span class="title">{{__('Patient Name')}}:</span> <span
                                    class="data">
                                    @if(isset($group['patient']))
                                        {{ $group['patient']['name'] }}
                                    @endif
                                </span>
                            </td>
                            <td width="50%">
                                <span class="title">{{__('Barcode')}}:</span>
                                <span class="data">
                                    {{$group['barcode']}}
                                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type'])}}" alt="barcode" class="margin" width="100"/>       {{$group['protokoll_no']}}<br>
                                </span>
                            
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <span class="title">{{__('Patient Code')}}:</span> <span
                                    class="data">
                                    @if(isset($group['patient']))
                                        {{ $group['patient']['code'] }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="title">{{__('Registration Date')}}:</span> 
                                <span class="data">
                                    {{ date('Y-m-d H:i',strtotime($group['created_at'])) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{__('Age')}}:</span> 
                                  <span class="data">
                                    @if ($group['contract_id'] == 9999)
                                        N/A                                 
                                    @elseif(isset($group['patient']))
                                        {{$group['patient']['age']}} ({{ $newDate = date("d-m-Y", strtotime($group['patient']['dob'])) }})   
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="title">{{__('Sample collection')}}:</span> 
                                <span class="data">
                                    {{ date('Y-m-d H:i',strtotime ($group['sample_collection_date'])) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{__('Gender')}}:</span> <span
                                    class="data">
                                    @if(isset($group['patient']))
                                        {{ __($group['patient']['gender']) }}
                                    @endif
                                </span>
                            </td>
                            
                            <td>
                                <span class="title">{{__('Result Date Validation')}}:</span> 
                                <span class="data">
                                    {{ date('Y-m-d H:i',strtotime($group['pdf_update'])) }}
                                </span>
                            </td>
                             
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{__('Address')}}:</span> <span
                                    class="data">
                                    @if(isset($group['patient']))
                                        {{ __($group['patient']['address']) }}
                                    @endif
                                </span>
                            </td>
                            <td width="50%">
                                <span class="title">{{__('Reference')}}:</span> <span
                                    class="data">
                                    @if(isset($group['reference']))
                                        {{ $group['reference'] }}
                                    @endif
                                </span>
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
                        <td width="20%" align="center">
                            @if($group['branch_id']=='10')
                            @if($reports_settings['show_qrcode'])
                                <p class="signature">
                                    {{__('QR Code')}}
                                </p>
                            @endif
                            @endif
                        </td>
                        
                    </tr>
                    <tr>
                        
                        <!--<td width="20%" align="center">-->
                        <!--    @if($group['branch_id']<>'34'||$group['branch_id']<>'13')-->
                        <!--    @if($reports_settings['show_qrcode'])-->
                        <!--        @if(isset($group['patient']))-->
                        <!--            <img src="https://chart.googleapis.com/chart?chs={{$reports_settings['qrcode-dimension']}}x{{$reports_settings['qrcode-dimension']}}&cht=qr&chl={{url('uploads/pdf/'.'report_'.$group['id'].''.$group['patient_id'].'.pdf')}}&choe=UTF-8" title="Link to Google.com" />-->
                        <!--        @endif-->
                        <!--    @endif-->
                        <!--    @endif-->
                        <!--</td>-->
                        <td width="50%"></td>
                        <td width="40%" align="center">
                            @if($reports_settings['show_signature'])
                                @if(!empty($group['signed_by']))
                                    <p>
                                        <img src="{{url('uploads/signature2/'.$group['signed_by_user']['signature2'])}}" alt="" height="300">
                                    </p>
                                @endif
                            @endif
                        </td>
                    
                    </tr>
                </tbody>
            </table>
            @endif
        @endif
        
    </htmlpagefooter>

</body>

</html>