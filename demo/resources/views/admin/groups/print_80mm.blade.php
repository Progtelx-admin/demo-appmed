<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Invoice</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />

</head>

<body>
    <table width="100%" class="table pdf-header">
        <tbody>

            <tr>
                <td class="left-td">
                    <span class="title">{{ __('Patient Name') }}:</span> <span class="data">
                        @if (isset ($group['patient']))
                            {{ $group['patient']['name'] }}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td class="left-td">
                    <span class="title">{{ __('Barcode') }}:</span>
                    <span class="data">
                        {{ $group['barcode'] }}
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($group['barcode'], $barcode_settings['type']) }}"
                            alt="barcode" class="margin" width="170" height="20" />
                        {{ $group['protokoll_no'] }}<br>
                    </span>

                </td>
            </tr>
            <!-- <tr>
                <td class="left-td">
                    <span class="title">{{ __('Patient Code') }}:</span> <span class="data">
                        @if (isset ($group['patient']))
                            {{ $group['patient']['code'] }}
                        @endif
                    </span>
                </td>
                <td>
                    <span class="title">{{ __('Registration Date') }}:</span>
                    <span class="data">
                        {{ date('Y-m-d H:i', strtotime($group['created_at'])) }}
                    </span>
                </td>
            </tr> -->
            <tr>
                <td class="left-td">
                    <span class="title">{{ __('Age') }}:</span>
                    <span class="data">
                        @if ($group['contract_id'] == 9999)
                            N/A
                        @elseif(isset ($group['patient']))
                            {{ $group['patient']['age'] }}
                            ({{ $newDate = date('d-m-Y', strtotime($group['patient']['dob'])) }})
                        @endif
                    </span>
                </td>
                <!-- <td>
                    <span class="title">{{ __('Sample collection') }}:</span>
                    <span class="data">
                        {{ date('Y-m-d H:i', strtotime($group['sample_collection_date'])) }}
                    </span>
                </td> -->
            </tr>
            <tr>
                <td class="left-td">
                    <span class="title">{{ __('Gender') }}:</span> <span class="data">
                        @if (isset ($group['patient']))
                            {{ __($group['patient']['gender']) }}
                        @endif
                    </span>
                </td>
<!-- 
                <td>
                    <span class="title">{{ __('Result Date Validation') }}:</span>
                    <span class="data">
                        {{ date('Y-m-d H:i', strtotime($group['pdf_update'])) }}
                    </span>
                </td> -->

            </tr>
            <tr>
            </tr>
            <tr>
                <td class="left-td">
                    <span class="title">{{ __('Address') }}:</span> <span class="data">
                        @if (isset ($group['patient']))
                            {{ __($group['patient']['address']) }}
                        @endif
                    </span>
                </td>
                <!-- <td>
                    <span class="title">{{ __('Reference') }}:</span> <span class="data">
                        @if (isset ($group['reference']))
                            {{ $group['reference'] }}
                        @endif
                    </span>
                </td> -->
            </tr>
            <tr>
                <td class="left-td">
                    <span class="title">{{ __('Registration Date') }}:</span>
                    <span class="data">
                        {{ date('Y-m-d H:i', strtotime($group['created_at'])) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="left-td">
                <span class="title">{{ __('Reference') }}:</span> <span class="data">
                        @if (isset ($group['reference']))
                            {{ $group['reference'] }}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
            <td class="left-td">
                <span class="title">{{ __('Printimi') }}:</span>
                <span class="data" id="currentDateTime">
                    <!-- Current date and time will be displayed here -->
                </span>
            </td>
            </tr>
        </tbody>

    </table>

    <div class="invoice">
    <br><br><br><br><br><br><br><br>
        <!-- Table for all_tests -->
        @foreach ($group['all_tests'] as $test)
            <tr>
                <th class="test_title" align="center" colspan="3">
                    <h1 style="text-align: center;">{{ $test['daily_count'] }}</h1>
                    <h3 style="text-align: center;">Testet</h3>
                @break

                </th>
            </tr>
        @endforeach
        <table  width="100%" style="font-size: 12px;">
        <thead>

        </thead>
            <tbody>
                @foreach ($group['all_tests'] as $test)
                    <tr style="border-bottom: 2px solid black;">
                        <td colspan="2" class="print_title test_name">
                            @if (isset ($test['test']))
                                {{ $test['test']['name'] }}
                            @endif
                        </td>
                        <td>{{ $test['test']['sample_type'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>


        @foreach ($group['all_cultures'] as $culture)
                        <tr>
                            <th class="test_title" align="center" colspan="3">
                                <h1 style="text-align: center;">{{ $culture['daily_count'] }}</h1>
                                <h3 style="text-align: center;">Kulturat</h3>
                            @break

                            </th>
                        </tr>
                @endforeach
        <table  width="100%" style="font-size: 12px;">
        <thead>

                </thead>
            <tbody>
                @foreach ($group['all_cultures'] as $culture)
                    <tr style="border-bottom: 2px solid black;">
                        <td colspan="2" class="print_title test_name">
                            @if (isset ($culture['culture']))
                                {{ $culture['culture']['name'] }}
                            @endif
                        </td>
                        <td>{{ $culture['culture']['sample_type'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        

        <!-- Table for all_services -->

            
        @if (!empty ($group['all_services']))
        <br><br><br><br><br><br><br><br>
        @foreach ($group['all_services'] as $service)
                        <tr>
                            <th class="test_title" align="center" colspan="3">
                                <h1 style="text-align: center;">{{ $service['daily_count'] }}</h1>
                                <h3 style="text-align: center;">Serviset</h3>
                            @break

                            </th>
                        </tr>
                @endforeach
        <table  width="100%" style="font-size: 12px;">
        <thead>

                </thead>
            <tbody>
                @foreach ($group['all_services'] as $service)
                    <tr style="border-bottom: 2px solid black;">
                        <td colspan="2" class="print_title test_name">
                            @if (isset($service['service']['name']))
                                {{ $service['service']['name'] }}
                            @endif
                        </td>
                        <td>{{ $service['service']['sample_type'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @endif

    </div>

    <br><br><br><br><br><br><br><br>
    {{--
    </div>

    </div> --}}

    <div>
        <h1 class="test" style="font-size: 24px; color: white !important">.</h1>
    </div>
</body>

</html>


<script type="text/javascript">
    (function() {
        try {
            if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
                var printStyle = document.createElement('style');
                printStyle.setAttribute('type', 'text/css');
                printStyle.innerHTML = '@media print { header, footer, #nav { display: none !important; } }';

            }

            window.print();

            setTimeout(function() {
                window.close();
            }, 1000);
        } catch (error) {
            console.log('Error occurred during printing: ', error);
        }
    })();
</script>

<script>
    // Get the span element
    var dataSpan = document.getElementById('currentDateTime');

    // Function to update the current date and time
    function updateDateTime() {
        var now = new Date();
        var dateTimeString = now.toLocaleString(); // Adjust the format as needed
        dataSpan.textContent = dateTimeString;
    }

    // Call the function initially to display current date and time
    updateDateTime();

    // Update date and time every second (1000 milliseconds)
    setInterval(updateDateTime, 1000);
</script>

<style>
    @media print {
        @page {
            size: 80mm;
            margin: 0;
        }

        body {
            width: 80mm;
            margin: 0;
        }

        .container {
            width: 100%;
        }

        .pdf-header {
            border: 2px solid black;
            border-collapse: collapse;
        }

        .inv-logo {
            width: 80%;
            margin: 0 auto;
            display: block;
            margin-bottom: 20px;
        }

        .inv-header,
        .inv-footer {
            flex-direction: column;
        }

        .inv-header,
        .inv-footer>div {
            width: 100%;
        }

        .inv-header>div {
            margin-bottom: 20px;
        }

        .inv-body table,
        .inv-footer table {
            width: 100%;
        }

        .tables, th, td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .test {
            color: white !important;
        }
        .left-td {
            text-align: left;
            font-size: 12px;
            color: black;
            font-weight: bold;
            border: 2px solid black;
        }

        .centered {
            text-align: center;
        }

        .test_name {
            text-align: left;
        }
    }

    ul {
        padding: 0;
        margin: 0 0 1rem 0;
        list-style: none;
    }

    body {
        font-family: "Inter", sans-serif;
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    table th,
    table td {
        border: 1px solid silver;
    }

    table th,
    table td {
        text-align: right;
        padding: 8px;
    }

    h1,
    h4,
    p {
        margin: 0;
    }

    .container {
        padding: 20px 0;
        width: 1000px;
        max-width: 90%;
        margin: 0 auto;
    }

    .inv-title {
        padding: 10px;
        border: 1px solid silver;
        text-align: center;
        margin-bottom: 30px;
    }

    /* header */
    .inv-header {
        display: flex;
        margin-bottom: 20px;
    }

    .inv-header> :nth-child(1) {
        flex: 2;
    }

    .inv-header> :nth-child(2) {
        flex: 1;
    }

    .inv-header h2 {
        font-size: 20px;
        margin: 0 0 0.3rem 0;
    }

    .inv-header ul li {
        font-size: 15px;
        padding: 3px 0;
    }

    /* body */
    .inv-body table th,
    .inv-body table td {
        text-align: left;
    }

    .inv-body {
        margin-bottom: 30px;
    }

    /* footer */
    .inv-footer {
        display: flex;
        flex-direction: row;
    }

    .inv-footer> :nth-child(1) {
        flex: 2;
    }

    .inv-footer> :nth-child(2) {
        flex: 1;
    }
</style>

{{-- <style>
.receipt_title td,
th {
border-color: white;
}

.receipt_title .total {
background-color: #ddd;
}

.table th {
color: {{ $reports_settings['test_head']['color'] }} !important;
font-size: {{ $reports_settings['test_head']['font-size'] }} !important;
font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
}

.total {
font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
}

.due_date {
font-family: {{ $reports_settings['test_head']['font-family'] }} !important;
}

.test_name {
color: {{ $reports_settings['test_name']['color'] }} !important;
font-size: {{ $reports_settings['test_name']['font-size'] }} !important;
font-family: {{ $reports_settings['test_name']['font-family'] }} !important;
}
</style> --}}