<ul class="p-1">
    @foreach($instrument['branches'] as $branch)
    <li>
        @if(isset($branch['branch']))
            {{$branch['branch']['name']}}
        @endif
    </li>
    @endforeach
</ul>
