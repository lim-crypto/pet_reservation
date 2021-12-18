edit pet
@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<form action="{{route('pets.update',$pet->id)}}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name">

    <input type="submit">
</form>