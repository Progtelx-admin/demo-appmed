<ul class="pl-3">
@foreach($group['all_cultures'] as $culture)
    <li class="@if($culture['done']) text-success @endif">{{$culture['culture']['name']}}</li>
@endforeach
</ul>