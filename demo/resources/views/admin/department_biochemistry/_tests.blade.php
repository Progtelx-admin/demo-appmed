<ul class="pl-3">
@foreach($group['all_tests'] as $test)
    <li class="@if($test['done']) text-success @endif">{{$test['test']['name']}}</li>
@endforeach
</ul>