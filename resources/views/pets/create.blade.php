create

<br>
<form action="{{route('pets.store')}}" method="POST" >
    @csrf
    <input type="hidden" name="breed_id" value="1" >
    <input type="text" name="name" >
    <input type="submit">
</form>