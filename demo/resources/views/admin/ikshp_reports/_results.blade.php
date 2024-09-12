<ul class="pl-3">
@foreach ($group['tests'] as $test)
    @foreach ($test['results'] as $result)
        @if ($test['test']['id'] === 77 || $test['test']['id'] === 79 || $test['test']['id'] === 85)
        <li class="text-success">{{ $result['result'] }}</li>
        @endif
        @endforeach
        @endforeach
        
</ul>