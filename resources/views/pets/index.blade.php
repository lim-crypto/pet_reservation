index
@if(session()->has('success'))
{{session()->get('success')}}
@endif

@foreach ($pets as $pet)
    <li>
        <a href="{{route('pets.show',$pet->id)}}">
    {{$pet->id}} </a></li>
<li>{{ $pet->name }}</li>
<li>{{$pet->age}}</li>
@endforeach
<br>

<a href="{{route('pets.create')}}">create</a>