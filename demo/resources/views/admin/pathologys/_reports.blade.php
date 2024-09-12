@if ($pathology['report'] == 'Pathology')
    <p style="color: #85a18f!important">{{ $pathology['report'] }}</p>
    @elseif($pathology['report'] == 'Cytology')
    <p style="color: #f6dda7!important">{{ $pathology['report'] }}</p>
    @elseif($pathology['report'] == 'Pap Test')
    <p style="color: #b3827b!important">{{ $pathology['report'] }}</p>
@endif
