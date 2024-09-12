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
        @if ($type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7)
            @page {
                margin-top: {{ $reports_settings['margin-top'] }}px;
                margin-right: {{ $reports_settings['margin-right'] }}px;
                margin-left: {{ $reports_settings['margin-left'] }}px;
                margin-bottom: {{ $reports_settings['margin-bottom'] }}px;
            }
        @else
            @page {
                header: page-header;
                footer: page-footer;

                margin-left: {{ $reports_settings['margin-left'] }}px;
                margin-right: {{ $reports_settings['margin-right'] }}px;

                margin-top: {{ $reports_settings['content-margin-top'] }}px;
                margin-header: {{ $reports_settings['margin-top'] }}px;

                margin-bottom: {{ $reports_settings['content-margin-bottom'] }}px;
                margin-footer: {{ $reports_settings['margin-bottom'] }}px;

                @if ($pathology['branch']['show_watermark_image'])
                    background: url("{{ url('uploads/branches/' . $pathology['branch']['watermark_image']) }}") no-repeat;
                    background-position: center;
                @endif
            }
        @endif

        .table-bordered {
            border: 0.5px solid #dee2e6;
            border-collapse: collapse;
            background-color: white !important;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table2 {
            margin: auto;
            width: 100%;
            background-color: #80C342;
            border-collapse: collapse;
        }

        table td,
        th {
            padding: 0px;
        }

        .title {
            background-color: #fff;
        }

        .branch_name {
            color: {{ $reports_settings['branch_name']['color'] }} !important;
            font-size: {{ $reports_settings['branch_name']['font-size'] }} !important;
            font-family: {{ $reports_settings['branch_name']['font-family'] }} !important;
        }

        .branch_info {
            color: {{ $reports_settings['branch_info']['color'] }} !important;
            font-size: {{ $reports_settings['branch_info']['font-size'] }} !important;
            font-family: {{ $reports_settings['branch_info']['font-family'] }} !important;
        }

        .title {
            color: {{ $reports_settings['patient_title']['color'] }} !important;
            font-size: {{ $reports_settings['patient_title']['font-size'] }} !important;
            font-family: {{ $reports_settings['patient_title']['font-family'] }} !important;
        }

        .data {
            color: {{ $reports_settings['patient_data']['color'] }} !important;
            font-size: {{ $reports_settings['patient_data']['font-size'] }} !important;
            font-family: {{ $reports_settings['patient_data']['font-family'] }} !important;
            font-weight: bold;
        }

        .data2 {
            color: #fff !important;
            font-size: 15px;
            font-family: {{ $reports_settings['patient_data']['font-family'] }} !important;
            font-weight: bold;
            background-color: #70bf7e;

        }

        .header {
            border: {{ $reports_settings['report_header']['border-width'] }} solid {{ $reports_settings['report_header']['border-color'] }};
            background-color: {{ $reports_settings['report_header']['background-color'] }};
            text-align: {{ $reports_settings['report_header']['text-align'] }} !important;
        }

        .footer {
            border: {{ $reports_settings['report_footer']['border-width'] }} solid {{ $reports_settings['report_footer']['border-color'] }};
            background-color: {{ $reports_settings['report_footer']['background-color'] }};
            color: {{ $reports_settings['report_footer']['color'] }} !important;
            font-size: {{ $reports_settings['report_footer']['font-size'] }} !important;
            font-family: {{ $reports_settings['report_footer']['font-family'] }} !important;
            text-align: {{ $reports_settings['report_footer']['text-align'] }} !important;
        }

        .signature {
            color: {{ $reports_settings['signature']['color'] }} !important;
            font-size: {{ $reports_settings['signature']['font-size'] }} !important;
            font-family: {{ $reports_settings['signature']['font-family'] }} !important;
        }

        @if (session('rtl'))
            .pdf-header {
                direction: rtl;
            }
        @endif
    </style>

</head>

<body>

    @if ($type !== 3 && $type !== 4 && $type !== 5 && $type !== 6 && $type !== 7)
        <htmlpageheader name="page-header">

            @if ($reports_settings['show_header'] && isset($pathology['branch']))
                @if ($pathology['branch']['show_header_image'])
                    <table width="100%" style="padding:0px">
                        <tbody>
                            <tr>
                                <td align="center" style="padding:0px">
                                    <img src="{{ url('uploads/branches/' . $pathology['branch']['header_image']) }}"
                                        alt="" max-height="200">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <table width="100%" class="pdf-header header">
                        <tbody>
                            <tr>
                                <td width="15%" align="left">
                                    <img src="{{ url('img/reports_logo.png') }}" width="100px" />
                                </td>
                                <td width="70%" align="{{ $reports_settings['report_header']['text-align'] }}">
                                    <p class="branch_name">
                                        {{ $pathology['branch']['name'] }}
                                    </p>
                                    <p class="branch_info">
                                        <img src="{{ url('img/report_phone.png') }}" width="12px" alt="">
                                        @if (isset($pathology['branch']))
                                            {{ $pathology['branch']['phone'] }}
                                        @endif
                                    </p>
                                    <p class="branch_info">
                                        <img src="{{ url('img/report_address.png') }}" width="12px" alt="">
                                        @if (isset($pathology['branch']))
                                            {{ $pathology['branch']['address'] }}
                                        @endif
                                    </p>
                                    <p class="branch_info">
                                        <img src="{{ url('img/report_email.png') }}" width="12px" alt="">
                                        {{ $info_settings['email'] }}
                                    </p>
                                    <p class="branch_info">
                                        <img src="{{ url('img/report_website.png') }}" width="12px" alt="">
                                        {{ $info_settings['website'] }}
                                    </p>
                                </td>
                                <td align="right" width="15%">
                                    @if (isset($pathology['patient']) && $reports_settings['show_avatar'])
                                        <img src="@if (!empty($pathology['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $pathology['patient']['avatar']) }} @else {{ url('img/avatar.png') }} @endif"
                                            max-width="100px" max-height="100px">
                                    @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                @endif
            @endif

            @if (isset($pathology['patient']))
                <table width="100%" class="table table-bordered pdf-header">
                    <tbody>

                        <tr>
                            <td width="50%">
                                <span class="title">{{ __('Institucioni referues') }}:</span> <span class="data">

                                    {{ $pathology['id'] }}

                                </span>
                            </td>
                            <!--<td width="50%">-->
                            <!--    <span class="title">{{ __('Patient Code') }}:</span> <span-->
                            <!--        class="data">-->
                            <!--        @if (isset($pathology['patient']))
-->
                            <!--            {{ $pathology['patient']['code'] }}-->
                            <!--
@endif-->
                            <!--    </span>-->
                            <!--</td>-->
                            <td width="50%">
                                <span class="title">{{ __('Place') }}:</span> <span class="data">
                                    @if (isset($pathology['patient']))
                                        {{ $pathology['patient']['code'] }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <span class="title">{{ __('Patient Name') }}:</span> <span class="data">
                                    @if (isset($pathology['patient']))
                                        {{ $pathology['patient']['name'] }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="title">{{ __('Reference') }}:</span>
                                <span class="data">

                                    @if (isset($pathology['patient']))
                                        {{ $pathology['patient']['age'] }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{ __('Birth date') }}:</span>
                                <span class="data">

                                    @if (isset($pathology['patient']))
                                        ({{ $newDate = date('d-m-Y', strtotime($pathology['patient']['dob'])) }})
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="title">{{ __('Printing Date') }}:</span>
                                <span class="data">
                                    {{ $date = date('Y-m-d H:i') }}
                                </span>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{ __('Gender') }}:</span> <span class="data">
                                    @if (isset($pathology['patient']))
                                        {{ __($pathology['patient']['gender']) }}
                                    @endif
                                </span>
                            </td>

                            <td>
                                <span class="title">{{ __('Residence') }}:</span> <span class="data">
                                    @if (isset($pathology['patient']))
                                        {{ __($pathology['patient']['address']) }}
                                    @endif
                                </span>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{ __('Registration Date') }}:</span>
                                <span class="data">
                                    {{ date('Y-m-d H:i', strtotime($pathology['created_at'])) }}
                                </span>
                            </td>
                            <td width="50%">
                                <span class="title">{{ __('Visit ID') }}:</span> <span class="data">
                                    @if (isset($pathology['patient']))
                                        {{ $pathology['patient']['code'] }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="title">{{ __('Referring physician') }}:</span>
                                <span class="data">
                                    {{ $pathology['reference'] }}
                                </span>
                            </td>
                            <td width="50%">
                                <span class="title">{{ __('Clinical diagnosis') }}:</span> <span class="data">
                                    {{ $pathology['clinical_diagnosis'] }}
                                </span>
                            </td>
                        </tr>
                </table>

                <table style="border:none;">
                    <tr>
                        <td>
                            <span class="title">Lindje</span>
                            <span class="data">
                                {{ $pathology['births'] }}
                            </span><br>
                            <span class="title">Abort</span>
                            <span class="data">
                                {{ $pathology['abortions'] }}
                            </span><br>
                            <span class="title">Menstruacioni i fundit</span>
                            <span class="data">
                                {{ $pathology['menstrual_cycle'] }}
                            </span><br>
                            <span class="title">Pap-teste te mehershme</span>
                            <span class="data">
                                {{ $pathology['pap_tests'] }}
                            </span><br>
                        </td>
                        <td width="50%">
                            <span class="title">Hysterektomia:</span> <span class="data">
                                {{ $pathology['hysterectomy'] }}
                            </span><br>
                            <span class="title">Kimioterapi</span>
                            <span class="data">
                                {{ $pathology['chemotherapy'] }}
                            </span><br>
                            <span class="title">Rrezatim</span>
                            <span class="data">
                                {{ $pathology['radiation'] }}
                            </span><br>
                            <span class="title">Terapi hormonale</span>
                            <span class="data">
                                {{ $pathology['hormonal_therapy'] }}
                            </span><br>
                        </td>
                    </tr>
                </table>


                </tbody>
            @endif

        </htmlpageheader>
    @endif



    <div class="content" style="padding-top:20px">
        <h2>RAPORTI PAPTEST</h2>
    </div>

    <div class="pjesa1">
        <div class="boxone">
            <h4 class="text">I. LLOJI I MOSTRËS</h4>
            @if ($pathology['paptest']['sample_conventional'] == 1)
                <input type="checkbox" checked="" id="sample_conventional" name="sample_conventional" />Mostër
                konvencionale<br>
            @else
                <input type="checkbox" id="sample_conventional" name="sample_conventional" />Mostër
                konvencionale<br>
            @endif

            @if ($pathology['paptest']['sample_other'] != '')
                <input type="checkbox" checked="" />Tjetër: <span
                    class="line3">{{ $pathology['paptest']['sample_other'] }}
                </span>
            @else
                <input type="checkbox" />Tjetër: <span class="line3">{{ $pathology['paptest']['sample_other'] }}
                </span>
            @endif

        </div>
        <div class="boxtwo">
            <h4 class="text">II. MOSTRA</h4>

            @if ($pathology['paptest']['sample_satisfactory'] == 1)
                <input type="checkbox" checked="" id="sample_satisfactory" name="sample_satisfactory" /> E
                kënaqshme për evaluim<br>
            @else
                <input type="checkbox" id="sample_satisfactory" name="sample_satisfactory" /> E kënaqshme për
                evaluim<br>
            @endif

            @if ($pathology['paptest']['sample_unsatisfactory'] != '')
                <input type="checkbox" checked="" /> E pakënaqshme<span
                    class="line3">{{ $pathology['paptest']['sample_unsatisfactory'] }}
                </span>
            @else
                <input type="checkbox" /> E pakënaqshme<span
                    class="line3">{{ $pathology['paptest']['sample_unsatisfactory'] }}
                </span>
            @endif

        </div>
        <div class="boxthree">
            <h4 class="text">III. REZULTATI</h4>

            @if ($pathology['paptest']['sample_negative'] == 1)
                <input type="checkbox" checked="" /> Negativ per lesion intraepitelial apo malinjitet (NILM) <br>
            @else
                <input type="checkbox" /> Negativ per lesion intraepitelial apo malinjitet (NILM) <br>
            @endif

            @if ($pathology['paptest']['sample_abnormal'] == 1)
                <input type="checkbox" checked="" /> Abnormalitetet e qelizave epiteliale (shiko përshkrimin)
            @else
                <input type="checkbox" /> Abnormalitetet e qelizave epiteliale (shiko përshkrimin)
            @endif

        </div>
        <div class="boxfive">
            <h4 class="text">IV. PËRSHKRIMI</h4>
            <h4><span class="line3"> Mikroorganizmat:</span></h4>

            @if ($pathology['paptest']['reactive_changes'] == 1)
                <input type="checkbox" checked="" /> Ndryshime reaktive qelizore të shoqëruara me:
            @else
                <input type="checkbox" /> Ndryshime reaktive qelizore të shoqëruara me:
            @endif
            <div style="margin-left: 10px">

                @if ($pathology['paptest']['inflammation'] == 1)
                    <input type="checkbox" checked="" class="titull" /> inflamacion
                @else
                    <input type="checkbox" class="titull" /> inflamacion
                @endif

                @if ($pathology['paptest']['iud'] == 1)
                    <input type="checkbox" checked="" style="margin-left: 30%;" /> IUD
                @else
                    <input type="checkbox" style="margin-left: 30%;" /> IUD
                @endif
            </div>
            <div style="margin-left: 20px">
                @if ($pathology['paptest']['repair_changes'] == 1)
                    <input type="checkbox" checked="" class="nentitull" /> ndryshime reparatore
                @else
                    <input type="checkbox" class="nentitull" /> ndryshime reparatore
                @endif

                @if ($pathology['paptest']['radiation'] == 1)
                    <input type="checkbox" checked="" style="margin-left: 7.7%;" /> radiacion<br>
                @else
                    <input type="checkbox" style="margin-left: 7.7%;" /> radiacion<br>
                @endif


                @if ($pathology['paptest']['cylinder_cells'] == 1)
                    <input type="checkbox" checked="" class="nentitull" /> Qelizat cilindrike pas histerektomisë
                @else
                    <input type="checkbox" class="nentitull" /> Qelizat cilindrike pas histerektomisë
                @endif
            </div>

            @if ($pathology['paptest']['squamous_metaplasia'] == 1)
                <input type="checkbox" checked="" class="titull" /> Metaplazion squamoz
            @else
                <input type="checkbox" class="titull" /> Metaplazion squamoz
            @endif


            @if ($pathology['paptest']['atrophy'] == 1)
                <input type="checkbox" checked="" class="titull" /> Atrofi<br>
            @else
                <input type="checkbox" class="titull" /> Atrofi<br>
            @endif

            @if ($pathology['paptest']['pregnancy_related'] == 1)
                <input type="checkbox" checked="" class="titull" /> Ndryshime të
                lidhura me shtatëzani
            @else
                <input type="checkbox" class="titull" /> Ndryshime të
                lidhura me shtatëzani
            @endif
            <br>
            @if ($pathology['paptest']['hormonal_status'] == 1)
                <input type="checkbox" checked="" class="titull" /> Statusi citohormonal s'i përgjigjet moshës
                <br>
            @else
                <input type="checkbox" class="titull" /> Statusi citohormonal s'i përgjigjet moshës <br>
            @endif


            @if ($pathology['paptest']['endometrial_cells'] == 1)
                <input type="checkbox" checked="" class="titull" /> Qeliza endometriale (te femrat ≥40 vjeç)
            @else
                <input type="checkbox" class="titull" /> Qeliza endometriale (te femrat ≥40 vjeç)
            @endif
        </div>



        <div class="pjesa2"></div>
        <div class="boxsix">
            <h4 class="text" style="font-weight: bold">
                Abnormalitetet e qelizave epiteliale
            </h4>


            @if ($pathology['paptest']['squamous_cells'] == 1)
                <input type="checkbox" checked="" /> <span class="line4"> Qelizat squamoze</span><br>
            @else
                <input type="checkbox" /> <span class="line4"> Qelizat squamoze</span><br>
            @endif

            <div style="margin-left: 10px;">

                @if ($pathology['paptest']['atypical_squamous'] == 1)
                    <input type="checkbox" checked="" class="titull" />Qeliza squamoze
                    atipike
                @else
                    <input type="checkbox" class="titull" /> Qeliza squamoze
                    atipike
                @endif

            </div>
            <div style="margin-left: 20px;">

                @if ($pathology['paptest']['ascus'] == 1)
                    <input type="checkbox" checked="" class="nentitull" />me rëndësi
                    të papërcaktuar (ASC–US) <br>
                @else
                    <input type="checkbox" class="nentitull" /> me rëndësi
                    të papërcaktuar (ASC–US) <br>
                @endif

                @if ($pathology['paptest']['asc_h'] == 1)
                    <input type="checkbox" checked="" class="nentitull" /> nuk mund të përjashtohet
                    HSIL (ASC–H)
                @else
                    <input type="checkbox" class="nentitull" /> nuk mund të përjashtohet
                    HSIL (ASC–H)
                @endif

            </div>

            @if ($pathology['paptest']['lsil'] == 1)
                <input type="checkbox" checked="" class="titull" /> Lezion intraepitelial squamoz i shkallës
                së ulët
                (LSIL)
                (dizplazia e lehtë/HPV/CIN 1) <br>
            @else
                <input type="checkbox" class="titull" /> Lezion intraepitelial squamoz i shkallës
                së ulët
                (LSIL)
                (dizplazia e lehtë/HPV/CIN 1) <br>
            @endif



            @if ($pathology['paptest']['hsil'] == 1)
                <input type="checkbox" checked="" class="titull" /> Lezion intraepitelial
                squamoz i shkallës së lartë
                (HSIL)
                (displazi e mesme ose e rëndë) <br>
            @else
                <input type="checkbox" class="titull" /> Lezion intraepitelial
                squamoz i shkallës së lartë
                (HSIL)
                (displazi e mesme ose e rëndë) <br>
            @endif

            @if ($pathology['paptest']['suspicious_patterns'] == 1)
                <input type="checkbox" checked="" class="titull" /> Me tipare që japin
                dyshim për invazion<br>
            @else
                <input type="checkbox" class="titull" /> Me tipare që japin
                dyshim për invazion<br>
            @endif


            @if ($pathology['paptest']['squamous_carcinoma'] == 1)
                <input type="checkbox" checked="" class="titull" /> Carcinoma squamocelulare
                <br>
            @else
                <input type="checkbox" class="titull" /> Carcinoma squamocelulare
                <br>
            @endif

            @if ($pathology['paptest']['glandular_cells'] == 1)
                <input type="checkbox" checked="" /> <span class="line4"> Qelizat glandulare</span><br>
            @else
                <input type="checkbox" /><span class="line4"> Qelizat glandulare</span><br>
            @endif


            <div style="margin-left: 10px;">


                @if ($pathology['paptest']['atypical_glandular'] == 1)
                    <input type="checkbox" checked="" class="titull" /> Qeliza atipike:
                @else
                    <input type="checkbox" class="titull" /> Qeliza atipike:
                @endif

            </div>
            <div style="margin-left: 20px;">


                @if ($pathology['paptest']['endocervical'] == 1)
                    <input type="checkbox" checked="" class="nentitull" /> endocervikale
                @else
                    <input type="checkbox" class="nentitull" /> endocervikale
                @endif


                @if ($pathology['paptest']['endometrial'] == 1)
                    <input type="checkbox" checked="" style="margin-left: 10%;" /> endometriale
                @else
                    <input type="checkbox" style="margin-left: 10%;" /> endometriale
                @endif


                @if ($pathology['paptest']['glandular'] == 1)
                    <input type="checkbox" checked="" class="nentitull" /> glandulare<br>
                @else
                    <input type="checkbox" class="nentitull" /> glandulare<br>
                @endif


                @if ($pathology['paptest']['neoplastic_cells'] == 1)
                    <input type="checkbox" checked="" class="nentitull" /> glanduare, i
                    përngjajnë qelizave neoplastike (AGC)
                @else
                    <input type="checkbox" class="nentitull" /> glanduare, i
                    përngjajnë qelizave neoplastike (AGC)
                @endif

            </div>



            @if ($pathology['paptest']['endocervical_in'] == 1)
                <input type="checkbox" checked="" class="titull" /> Adenocarcinoma
                endocervikale in situ<br>
            @else
                <input type="checkbox" class="titull" /> Adenocarcinoma
                endocervikale in situ<br>
            @endif

            @if ($pathology['paptest']['adenocarcinoma'] == 1)
                <input type="checkbox" checked="" class="titull" /> Adenocarcinoma
            @else
                <input type="checkbox" class="titull" /> Adenocarcinoma
            @endif


            <div style="margin-left: 20px;">


                @if ($pathology['paptest']['endocervical_ade'] == 1)
                    <input type="checkbox" checked=""class="nentitull" /> endocervikale
                @else
                    <input type="checkbox" class="nentitull" /> endocervikale
                @endif



                @if ($pathology['paptest']['endometrial_ade'] == 1)
                    <input type="checkbox" checked=""style="margin-left: 10%;" /> endometriale<br>
                @else
                    <input type="checkbox" style="margin-left: 10%;" /> endometriale<br>
                @endif




                @if ($pathology['paptest']['other_neoplasm'] != '')
                    <input type="checkbox" checked="" class="nentitull" /> Tjetër neoplazi malinje:<span
                        class="line3">{{ $pathology['paptest']['other_neoplasm'] }} </span>
                @else
                    <input type="checkbox" class="nentitull" /> Tjetër neoplazi malinje:<span
                        class="line3">{{ $pathology['paptest']['other_neoplasm'] }} </span>
                @endif
            </div>
        </div>
        <div class="boxseven">


            @if ($pathology['paptest']['repeat_treatment'] == 1)
                <input type="checkbox" checked="" /> Të përsëritet analiza pas tretmanit
            @else
                <input type="checkbox" /> Të përsëritet analiza pas tretmanit
            @endif

            <br>

            @if ($pathology['paptest']['repeat_date'] != '')
                <input type="checkbox" checked="" /> Të përsëritet analiza pas: <span
                    class="line3">{{ $pathology['paptest']['repeat_date'] }} </span><br>
            @else
                <input type="checkbox" /> Të përsëritet analiza pas: <span
                    class="line3">{{ $pathology['paptest']['repeat_date'] }} </span><br>
            @endif       

            @if ($pathology['paptest']['hpv_typing1'] == 1)
                    <input type="checkbox" checked=""class="nentitull" /> Të bëhet
                @else
                    <input type="checkbox" class="nentitull" /> Të bëhet
                @endif
            @if ($pathology['paptest']['hpv_typing2'] == 1)
                    <input type="checkbox" checked=""class="nentitull" />HPV tipizimi
                @else
                    <input type="checkbox" class="nentitull" />HPV tipizimi
                @endif
            @if ($pathology['paptest']['hpv_typing3'] == 1)
                    <input type="checkbox" checked=""class="nentitull" />Kolposkopia:
                @else
                    <input type="checkbox" class="nentitull" />Kolposkopia:
                @endif
            @if ($pathology['paptest']['biopsy'] == 1)
                    <input type="checkbox" checked=""class="nentitull" />Biopsia:
                @else
                    <input type="checkbox" class="nentitull" />Biopsia:
                @endif          
            
        </div>
        <div class="boxeight">
            <p> <strong>Komenti:</strong> <br> {{ $pathology['paptest']['comment'] }}
            </p>
        </div>

    </div>

    <htmlpagefooter name="page-footer" class="page-footer">
        <span>Patologu: {{ $pathology['pathologist'] }} </span>
        <table>
            <tr>
                <td class="d">

                </td>
            </tr>
        </table><br><br>
        <table style="border-style: none; text-align:center;">
            <tr>
                <td class="dr" style="border-style: solid solid none none;">Laboratori i patologjisë “Pathology”
                    <br>Lagjja Ulpiana, D-8 H3, Nr.10 | 10 000 Prishtine, Kosovë</th>
                <td style="border-style:solid none none none;"> w: www.patologjia.com | @: info@patologjia.com <br> T:
                    +383 (0) 45 250 475
                </td>
            </tr>
        </table><br>

    </htmlpagefooter>

</body>

</html>

<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 18px;
    }

    .content {
        text-align: center;
        padding-top: -7%;
    }

    hr {
        width: 70%;
    }

    .logo {
        text-align: center;
        padding: 40px 0 30px 0;
    }

    p {
        padding-bottom: -2%;
    }


    .dr {
        width: 50%;
        border-bottom: 1px solid #ffffff;
        border-left: 1px solid transparent;
    }

    .d {
        width: 50%;
        border-left: 1px solid #ffffff;
        border-right: 1px solid #ffffff;
        border-bottom: 1px solid #ffffff;
    }

    .line1 {
        border: none;
        border-bottom: 1px solid black;
        outline: none;
        display: inline;
        position: relative;
    }

    .boxone {
        background-color: rgb(228, 228, 228);
        margin-left: 10px;
        margin-right: 55%;
        /* margin-bottom:2%; */
    }

    .line2 {
        width: 25%;
        border-top: 0.2px solid black;
        margin-left: 123px;
        margin-top: -5px;
    }

    .boxtwo {
        margin-left: 10px;
        margin-right: 55%;
    }

    .boxthree {
        margin-left: 10px;
        margin-right: 55%;
        background-color: rgb(228, 228, 228);
    }

    /* .header2 {
        margin-top: 45px;
        padding-top: 15px;
    }
*/


    .boxfive {
        margin-left: 10px;
        margin-right: 55%;
        margin-bottom: 55px;
        position: relative;
        /* display: flex; */
        /* margin-top: 55px;  */
    }

    .boxfive .line3 {
        display: block;
        width: 100%;
        border-bottom: 1px solid black;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    .boxone .line3 {
        display: block;
        width: 100%;
        border-bottom: 1px solid black;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    .boxtwo .line3 {
        display: block;
        width: 100%;
        border-bottom: 1px solid black;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    .boxsix .line3 {
        display: block;
        width: 100%;
        border-bottom: 1px solid black;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    .boxseven .line3 {
        display: block;
        width: 100%;
        border-bottom: 1px solid black;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    /* .line3 {
        flex-grow: 1;
} */

    /*
     .box1 {
        margin-left: 75px;
    }

    .box2 {
        margin-left: 55%;
        margin-top: -615px;
    }
*/
    /* .boxfour {
        margin-right: 10px;
        margin-left: 50%;
        margin-top: -610px;
    } */

    .boxsix {
        margin-right: 10px;
        margin-left: 50%;
        margin-bottom: 30px;
        margin-top: -675px;
    }

    .line4 {
        /* margin-top: 0px;
        width: 23%;
        margin-left: 22px; */
        /* margin-bottom: -10px; */
        text-decoration: underline;
    }

    .boxseven {
        margin-right: 10px;
        margin-left: 50%;
        margin-top: -610px;
        /* margin-top: 10%; */
        background-color: rgb(228, 228, 228);
        /* margin-right: 10px; */
    }

    .boxeight {
        border: 1.5px solid rgb(0, 0, 0);
        /* margin-top: 25px; */
        /* margin-right: 60px; */
        padding-right: 5px;
        padding-left: 5px;
        /* padding-bottom: 10px; */
        padding-top: -10px;
        margin-right: 10px;
        margin-left: 50%;
        margin-top: 10px;

    }

    /* .titull {
        margin-left: 5%;
    } */


    /* .nentitull {
        margin-left: 30%;
    } */

    .resizable-input {
        width: auto;
        max-width: 100%;
        box-sizing: border-box;
    }
</style>
