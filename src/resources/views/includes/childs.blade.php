<ul>

	@foreach ($childs as $child)
		
	<li> {{ $child->title }} </li>
        @if (count($child->childs))
            @include('includes.childs', ['childs' => $child->childs])
        @endif
	@endforeach
</ul>
