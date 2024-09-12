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
        .table-bordered td, .table-bordered th {
            padding: 3px;
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
                                    @if ($group['contract_id'] == 9)
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
                            <td>
                                <span class="title">{{__('Printing Date')}}:</span> 
                                <span class="data">
                                  {{  $date = date('Y-m-d H:i') }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                    
                </table> 
                
            @endif

        </htmlpageheader>
    @endif

   @foreach ($group['testResults'] as $key => $result)
    @if ($key == 0 || $result->test->category_id != $group->testResults[$key - 1]->test->category_id)
        @if ($key != 0)
            </tbody>
            </table>
            <div style="page-break-after: always;"></div>
        @endif
        <table width="100%" class="table table-bordered pdf-header">
            <thead>
                <tr>
                    @php
                        $shown_titles = [];
                    @endphp
                    @foreach ($group['all_tests2'] as $title)
                        @if (($result->test->category->name == 'Biokimi-2' || $result->test->category->name == 'Mikrobiologji') && $title->test->id == $result->test->parent_id && !in_array($title->test->name, $shown_titles))
                            <th class="test_title text-center" colspan="5">
                                <h4>{{ $title->test->name }}</h4>
                            </th>
                            @php
                                $shown_titles[] = $title->test->name;
                            @endphp
                        @endif
                    @endforeach
                </tr>
                <tr class="test_head">
                    <th width="33.33%" class="text-left">{{ __('Genetic factor') }}</th>
                    <th width="33.33%" class="text-center">{{ __('Result') }}</th>
                    <th width="33.33%" class="text-center">{{ __('Method') }}</th>
                </tr>
            </thead>
            <tbody>
    @endif
<tr>
    <td style="padding: 5px 5px;text-align: left;">{{ $result->test->name }}</td>
    <td style="padding: 5px 5px; text-align: center;">{{ $result->result }}</td>
    <td style="padding: 5px 5px; text-align: center;">{{ $result->test->unit }}</td>
</tr>

@endforeach
</tbody>
</table>
<p style="font-size: 10px; text-align: left; font-weight: bold;">
INTERPRETATION :
<br>
F2:_20210_G>A (F2 –Prothrombin –coagulation factor I):
<br>
•	G/G - No abnormalities
<br>
•	G/A - Increased gene expression. Plasma prothrombin levels increased by 30 %, which leads to increased thrombin formation and causes high risk of thrombosis.Early reproductive losses.
<br>
•	A/A - Increased gene expression. Plasma prothrombin levels increased by 70 %, which leads to increased thrombin formation and causes extremely high risk of thrombosis. Early reproductive losses
<br>
F5:_1691_G>A (F5-Proaccelerin – coagulation factor V)
<br>
•	G/G - No abnormalities
<br>
•	G/A- Activated protein C resistance, which normally breaks down activated factor V, thereby preventing uncontrolled expansion of blood coagulation (APC resistance).
<br>
•	A/A- Recurrent miscarriage, late fetal loss.For homozygotes, the risk of venous thrombosis is increased by 50-100 times
<br>
F7:_10976_ G>A (F7-Proconvertin or convertin-coagulation factor VII)
<br>
•	G/G - No abnormalities
<br>
•	G/A- 30% reduction in factor VIl expression in the blood, reduced risk of myocardial infarction, more severe haemophilia
<br>
•	A/A- 50% reduction in factor VIl expression in the blood, reduced risk of myocardial infarction, more severe haemophilia
<br>
  F13:_G>T (F13A1-Fibrinase-coagulation factor XIII)
<br> 
•	G/G - No abnormalities
<br>
•	G/T - T/T - Reduced plasma concentrations of factor XIlI. disorders in the structure and properties of fibrin clot, which can be a cause of delaved hemorrhage
<br>
FGB:_-455_G>A (FGB-Fibrinogen-coagulation factor I)
<br>
•	G/G - No abnormalities
<br>
•	G/A – A/A - Constant increase in gene expression, resulting in 10-30% increase in fibrinogen levels in the blood.Cardiovascular diseases
<br>
ITGA2:_807_C>T (ITGA2-Integrin ,a2-platelet collagen receptor)
<br>
•	C/C- No abnormalities
<br>
<br>
•	CT – TT - Changes in the primary structure of the subunit lead to changes in the properties of receptors and marked increase in platelet adhesion
<br>
ITGB3:_1565_ T>C (ITGB3-Integrin,b3-platelet fibrinogen receptor)
<br>
•	T/T - No abnormalities
<br>
•	T/C – C/C - Increased affinity to fibrinogen, increased cell adhesion, more intense fibrin clot retraction
<br>
PAI-1: -675_5G>4G(PAI-1 Serpin-tissue plasminogen activator inhibitor)
<br>
•	5G/5G - No abnormalities
<br>
•	5G/4G - Slight increase in PAI-1 levels in the blood, decreased blood fibrinolytic activity
<br>
•	4G/4G - Increased PAI-1 levels, decreased blood fibrinolytic activity.Decreased probability of embryo implantation during IVF.Increased risk of thrombosis in protein S deficiency
<br>
MTHFR:_677_C>T (Methylenetetra - hydrofolate)
<br>
•	C/C- No abnormalities
<br>
•	C/T- Reduction of functional enzyme activity to 65% of the average value.Elevated plasma homocysteine levels.
<br>
•	T/T- Reduction of functional enzyme activity to 35% of the average value.Elevated plasma homocysteine levels. In homozygotes, this increase is pronounced much more than in heterozygotes
<br>
MTHFR:_1298_A>C (Methylenetetra - hydrofolate)
<br>
•	A/A - No abnormalities
<br>
•	A/C - Combination of heterozygosity of 677T and 1298C alleles is accompanied not only by a decrease in enzyme activity, but also by an increase in plasma homocysteine levels and reduced folate levels
<br>
•	C/C- Reduced MTHFR activity to about 60 % of normal. Can cause lower plasma folate levels in pregnancy
<br>
MTR:_2756_A>G (B12-Dependent methionine synthase)
<br>
•	A/A - No abnormalities
<br>
•	A/G- Homocysteinemia, reduced plasma homocysteine levels in response to increased dietary folates
<br>
•	G/G - Homocysteinemia, reduced plasma homocysteine levels in response to increased dietary folates
<br>
    MTRR:_66_A>G (Methionine synthase reductase)
<br>
•	A/A - No abnormalities
<br>
•	A/G- Reduced functional enzyme activity, homocysteinemia, especially in combination with 2756 A>G
<br>
•	G/G- Reduced functional enzyme activity, homocysteinemia, especially in combination with 2756 A>G
</p>


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
                        <td width="20%" align="center">
                            @if($group['branch_id']<>'34'||$group['branch_id']<>'13')
                            @if($reports_settings['show_qrcode'])
                                @if(isset($group['patient']))
                                    <img src="https://chart.googleapis.com/chart?chs={{$reports_settings['qrcode-dimension']}}x{{$reports_settings['qrcode-dimension']}}&cht=qr&chl={{url('uploads/pdf/'.'report_'.$group['id'].''.$group['patient_id'].'.pdf')}}&choe=UTF-8" title="Link to Google.com" />
                                @endif
                            @endif
                            @endif
                        </td>
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