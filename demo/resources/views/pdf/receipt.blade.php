@extends('layouts.pdf')
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
        <thead>
            <tr>
                <th colspan="2" width="85%">{{__('Test Name')}}</th>
                <th width="15%">{{__('Price')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group['tests'] as $test)
            <tr>
                <td colspan="2" class="print_title test_name">
                    @if(isset($test['test'])) 
                        {{$test['test']['name']}}
                    @endif
                </td>
                <td>{{formated_price($test['price'])}}</td>
            </tr>
            @endforeach

            @foreach($group['cultures'] as $culture)
            <tr>
                <td colspan="2" class="print_title test_name">
                    @if(isset($culture['culture']))
                        {{$culture['culture']['name']}}
                    @endif
                </td>
                <td>{{formated_price($culture['price'])}}</td>
            </tr>
            @endforeach

            @foreach($group['packages'] as $package)
            <tr>
                <td colspan="2" class="print_title test_name">
                    @if(isset($package['package']))
                        {{$package['package']['name']}}
                    @endif
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
                </td>
                <td>{{formated_price($package['price'])}}</td>
            </tr>
            @endforeach
            
            @foreach($group['antibiotics'] as $antibiotic)
            <tr>
                <td colspan="2" class="print_title test_name">
                    @if(isset($antibiotic['antibiotic']))
                        {{$antibiotic['antibiotic']['name']}}
                    @endif
                </td>
                <td>{{formated_price($antibiotic['price'])}}</td>
            </tr>
            @endforeach

            <tr class="receipt_title border-top">
                <td width="50%" class="no-right-border"></td>
                <td class="total">
                    <b>{{__('Subtotal')}}</b>
                </td>
                <td class="total">{{formated_price($group['subtotal'])}}</td>
            </tr>

            <tr class="receipt_title">
                <td width="50%" class="no-right-border"></td>
                <td class="total">
                   <b>
                        {{__('Discount')}}
                   </b>
                </td>
                <td class="total">{{formated_price($group['discount'])}}</td>
            </tr>



            <tr class="receipt_title">
                <td width="50%" class="no-right-border"></td>
                <td class="total">
                    <b>{{__('Due')}}</b>
                </td>
                <td class="total">{{formated_price($group['due'])}}</td>
            </tr>

        </tbody>
    </table>
</div>
 @endsection