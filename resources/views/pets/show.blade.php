@if(session()->has('success'))
{{session()->get('success')}}
@elseif(session()->has('error'))
{{session()->get('error')}}
@endif
<p>{{$pet->name}}</p>
<br>
{{$pet->description}}
<a href="{{route('pets.edit', $pet->id)}}">edit</a>

<form action="{{route('pets.destroy', $pet->id)}}" method="POST">
    @csrf
    @method('DELETE')
    <input type="submit" value="delete">
</form>