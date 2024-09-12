<style>
    table {
        width: 548.75pt;
        border-collapse: collapse;
        border: none;
    }

    td {
        width: 134.9pt;
        border: 1pt solid black;
        padding: 0in 5.4pt;
        vertical-align: top;
    }

    .patientInfo {
        margin-bottom: 20px;
    }

    .header {
        margin-bottom: 25px
    }

    .titleOfBlood {
        background-color: #70bf7e;
        text-align: center;
        color: white;
        font-size: 15px;
        display: inline-block;
    }

    /* .resultTable {
        margin-top: 10px
    } */
    .resultTable td {
        padding: 5px
    }

    .resultTable table,
    td,
    tr {
        border: 0.5px solid #dee2e6;
    }

    .resultTable tr:last-child {
        border: none;
    }

    .doneBy {
        margin-top: -107px;
        margin-left: 70%;
        width: 200px;
    }


    /* .commentContainer {
        border-top: none;
    } */
    /* body {
        margin: 0;
        padding: 0;
        height: 100%;
    } */
    /* .printable {
        position: relative;
        min-height: 100vh;
    } */
    /* .endOfPage {
        margin-top: 50%
    } */

    .description {
        font-size: 10px !important;
        /* Adjust the font size as needed */
    }
</style>
<div class="printable">
    @php
        $count_categories = 0;
    @endphp
    <div class="header">
        {{-- <img src="C:\Users\Administrator\Desktop\header.jpg" alt="header"> --}}
        @if ($reports_settings['show_header'] && isset($group['branch']))
            @if ($group['branch']['show_header_image'])
                <table width="100%" style="padding:0px">
                    <tbody>
                        <tr>
                            <td align="center" style="padding:0px">
                                <img src="{{ url('uploads/branches/' . $group['branch']['header_image']) }}"
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
                                    {{ $group['branch']['name'] }}
                                </p>
                                <p class="branch_info">
                                    <img src="{{ url('img/report_phone.png') }}" width="12px" alt="">
                                    @if (isset($group['branch']))
                                        {{ $group['branch']['phone'] }}
                                    @endif
                                </p>
                                <p class="branch_info">
                                    <img src="{{ url('img/report_address.png') }}" width="12px" alt="">
                                    @if (isset($group['branch']))
                                        {{ $group['branch']['address'] }}
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
                                @if (isset($group['patient']) && $reports_settings['show_avatar'])
                                    <img src="@if (!empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }} @else {{ url('img/avatar.png') }} @endif"
                                        max-width="100px" max-height="100px">
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @endif
    </div>
    <div class="patientInfo">
        <table>
            <tr>
                <td>
                    {{ __('Patient Name') }}:
                </td>
                <td>
                    @if (isset($group['patient']))
                        {{ $group['patient']['name'] }}
                    @endif
                </td>
                <td>{{ __('Barcode') }}:</td>
                <td> {{ $group['barcode'] }}
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type']) }}"
                        alt="barcode" class="margin" width="100" />
                    {{ $group['protokoll_no'] }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ __('Patient Code') }}:
                </td>
                <td>
                    @if (isset($group['patient']))
                        {{ $group['patient']['code'] }}
                    @endif
                </td>
                <td>{{ __('Registration Date') }}:</td>
                <td> {{ date('Y-m-d H:i', strtotime($group['created_at'])) }}</td>
            </tr>
            <tr>
                <td>
                    {{ __('Age') }}:
                </td>
                <td>
                    @if ($group['contract_id'] == 9)
                        N/A
                    @elseif(isset($group['patient']))
                        {{ $group['patient']['age'] }}
                        ({{ $newDate = date('d-m-Y', strtotime($group['patient']['dob'])) }})
                    @endif
                </td>
                <td>{{ __('Result Date Validation') }}:</td>
                <td> {{ date('Y-m-d H:i', strtotime($group['pdf_update'])) }}</td>
            </tr>
            <tr>
                <td>
                    {{ __('Gender') }}:
                </td>
                <td>
                    @if (isset($group['patient']))
                        {{ __($group['patient']['gender']) }}
                    @endif
                </td>
                <td>{{ __('Printing Date') }}:</td>
                <td> {{ $date = date('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td>
                    {{ __('Residence') }}: </td>
                <td>
                    @if (isset($group['patient']))
                        {{ __($group['patient']['address']) }}
                    @endif
                </td>
                <td>{{ __('Reference') }}:</td>
                <td> {{ __($group['reference']) }}</td>
            </tr>
        </table>
    </div>
    {{-- <div class="titleOfBlood">
        <h5>Gjaku Periferik</h5>
    </div> --}}
    <div class="title">
        <table class="table test2 beak-page">
            <tr>
                <th class="titleOfBlood">
                    <h5>RAPORTI GJENETIK</h5>
                </th>
            </tr>
        </table>
    </div>
    <div class="resultTable">

        @foreach ($group->all_tests as $test)

            {{-- show === 1 per show --}}
            @if ($test['test_id'] == 790)
              
                    <table>

                        <tr class="titlesOfTable">
                            <td>
                                Gjeni
                            </td>
                            <td>
                                Varianti
                            </td>
                            <td>
                                ID-SNP
                            </td>
                            <td>
                                Rezultati
                            </td>
                            <td>
                                Genotype
                            </td>
                        </tr>
                        <tr>

                            <td>
                                {{ $test->results[0]['component']['name'] ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $test->results[0]['component']['unit'] ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $test->results[0]['idsnp'] ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $test->results[0]['result'] ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $test->results[0]['genotype'] ?? 'N/A' }}
                            </td>
                        </tr>
                        @if (isset($test->comment))
                            <tr>
                                <td colspan="5">
                                    {!! str_replace("\n", '<br />', $test->comment) !!}
                                </td>
                            </tr>
                        @endif
                    </table>

                    @if (isset($test->description))
                        <p class="description">
                            {{-- {!! str_replace("\n", '<br />', $test->description) !!} --}}
                            {!! $test->description !!}
                        </p>
                    @endif
                @endif
          
        @endforeach

        <div class="endOfPage">
            <div class="doneBy">
                @if ($reports_settings['show_signature'])
                    @if (!empty($group['signed_by']))
                        <p>
                            <img src="{{ url('uploads/signature/' . $group['signed_by_user']['signature']) }}"
                                alt="" style=' max-width: 200px !important;'>
                        </p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
