@extends('layouts.pdfwp')
@section('title')
    {{__('Receipt')}}-{{$group['id']}}-{{date('Y-m-d')}}
@endsection
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
   
</style>

<div class="invoice">
  
    <table class="table table-bordered" width="100%">
        @foreach ($group['all_tests'] as $test)
            <tr>
                <th class="test_title" align="center" colspan="3">
                    <h1>{{ $test['daily_count'] }}</h1>
                @break;
            </th>
        </tr>
    @endforeach
    <thead>
        <tr>
            <th colspan="2" width="85%">{{ __('Test Name') }}</th>
            <th width="15%">{{ __('Type') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($group->all_tests as $test)
            @if ($test->test->id == 755 || $test->test->id == 39 || $test->test->id == 437 || $test->test->id == 1116)
                <tr>
                    <td colspan="2" class="print_title test_name">
                        @if (isset($test['test']))
                            {{ $test['test']['name'] }}
                        @endif
                    </td>
                    <td>{{ $test['test']['sample_type'] }}</td>
                </tr>
            @else
                @foreach ($test->results as $result)
                    <tr>
                        <td colspan="2" class="print_title test_name">
                            @if (isset($result['test']['name']))
                                {{ $result['test']['name'] }}
                            @endif
                        </td>
                        <td>{{ $test['test']['sample_type'] }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    </tbody>
    </table>
    
    <br>
    
    <table class="table table-bordered" width="100%">
            @foreach($group['all_cultures'] as $culture)
        <tr>
            <th class="test_title" align="center" colspan="3">
                <h1>{{$culture['daily_count']}}</h1>
                @break;
            </th>
        </tr>
    @endforeach
        <thead>
            <tr>
                <th colspan="2" width="85%">{{__('Culture')}}</th>
                <th width="15%">{{__('Type')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group['all_cultures'] as $culture)
            <tr>
                <td colspan="2" class="print_title test_name">
                    @if(isset($culture['culture']))
                        {{$culture['culture']['name']}}
                    @endif
                </td>
                <td>{{$culture['culture']['sample_type']}}</td>
            </tr>
            @endforeach
         
        </tbody>
    </table>
    
    <br>
  
    <table class="table table-bordered" width="100%">
            @foreach($group['all_services'] as $service)
        <tr>
            <th class="test_title" align="center" colspan="3">
                <h1>{{$service['daily_count']}}</h1>
                @break;
            </th>
        </tr>
    @endforeach
        <thead>
            <tr>
                <th colspan="2" width="85%">{{__('Service')}}</th>
                <th width="15%">{{__('Type')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group['all_services'] as $service)
            <tr>
                <td colspan="2" class="print_title test_name">
                    @if(isset($service['service']))
                        {{$service['service']['name']}}
                    @endif
                </td>
               
            </tr>
            @endforeach
         
        </tbody>
    </table>
   
</div>



 @endsection
 
 
 
 <script>
    window.onload = function() {
        window.print();
    };
</script>