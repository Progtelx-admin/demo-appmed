<table>
    <tr><td align="center" width="100%">Raporti IKSHP</td></tr>
    </table>
    <table>
    <thead>
        
        <tr>
            <th align="center" width="10">{{__('#')}}</th>
            <th align="center" width="20">{{__('Patient Name')}}</th>
            <th align="center" width="20">{{__('Date of Birth')}}</th>
            <th align="center" width="20">{{__('Gender')}}</th>
            <th align="center" width="20">{{__('Profesion')}}</th>
            <th align="center" width="20">{{__('City')}}</th>
            <th align="center" width="20">{{__('Phone')}}</th>
            <th align="center" width="20">{{__('Country')}}</th>
            <th align="center" width="20">{{__('National Id')}}</th>
            <th align="center" width="20">{{__('Test Name')}}</th>
            <th align="center" width="20">{{__('Test Result')}}</th>
            <th align="center" width="20">{{__('Lloji i Vaksines')}}</th>
            <th align="center" width="20">{{__('Data e Vaksines 1')}}</th>
            <th align="center" width="20">{{__('Data e Vaksines 2')}}</th>
            <th align="center" width="20">{{__('Data e Vaksines 3')}}</th>
            <th align="center" width="20">{{__('Branch Name')}}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td align="center"></td>
            <td align="center">{{ $product['product']['name'] }}</td>
            <td align="center">{{ $groups['patient_id'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $tests['test_id'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $product['quantity'] }}</td>
            <td align="center">{{ $branches['id'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>