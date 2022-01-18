@extends('admin.layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('main-content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Breed of Pets</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Breed of Pets</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Breed of Pets</h3>
                    <div class="card-tools my-2">
                        <form action="{{route('breed.store')}}" method="POST" class="needs-validation" novalidate="">
                            @csrf
                            <div class="input-group input-group-sm" style="width: 350px;">

                                <select name="type_id" id="type" class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}" required>
                                    <option value="" disabled selected>Select type</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}" @if(old('type_id')==$type->id) selected @endif >{{$type->name}}</option>
                                    @endforeach
                                </select>
                                <!-- <span class="invalid-feedback">
                                    Type is required
                                </span> -->
                                <div class="input-group-append input-group-sm">
                                    <input type="text" class="form-control float-right {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="type" placeholder="add pet Breed" required>
                                    <!-- <span class="invalid-feedback">
                                        Breed is required
                                    </span> -->
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus "></i></button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table" class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Type</th>
                                <th>Breed</th>
                                <th>Created At</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ( $breeds as $breed)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{ $breed->type->name}}</td>
                                <td>{{ $breed->name}}</td>
                                <td>{{ $breed->created_at->diffForHumans()}}</td>

                                <td>
                                    <button type="button" class="btn btn-primary  btn-sm editModal"   data-toggle="modal" data-target="#editModal" data-name="{{$breed->name}}" data-type-id="{{$breed->type_id}}" data-link="{{route('breed.update', $breed->slug)}}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger   btn-sm deleteModal"  data-toggle="modal" data-target="#deleteModal" data-name="{{$breed->name}}" data-link="{{route('breed.destroy', $breed->slug)}}"  @if ( $breed->pets->count() ) disabled @endif >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div><!-- /.container-fluid -->
        <!-- delete modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="deleteModalText">Are you sure you want to delete this?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <form id="delete-form" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="sumbit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editeModalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit-form" action="" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type_id" id="editType" class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}" required>
                                    <option value="" disabled selected>Select type</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}" @if(old('type_id')==$type->id) selected @endif >{{$type->name}}</option>
                                    @endforeach
                                </select>

                                <span class="invalid-feedback">
                                    Type is required
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="type">Breed</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="editBreed" placeholder="title" value="" required>
                                <span class="invalid-feedback">
                                    Breed is required
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="sumbit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')

<!-- DataTables  & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- jquery validation -->
<script src="{{ asset('Adminlte/plugins/jquery-validation/jquery-validation.js') }}"></script>

<!-- Page specific script -->
<script>

    // delete
    $('.deleteModal').click(function() {
        console.log(' delete clicked 2');
        const name = $(this).attr('data-name');
        const link = $(this).attr('data-link');
        $('#deleteModalText').text(`Are you sure you want to delete ${name}?`);
        $('#delete-form').attr('action', link);
    });

    // edit
    $('.editModal').click(function() {
        console.log('edit clicked 2');
        const name = $(this).attr('data-name');
        const link = $(this).attr('data-link');
        const type = $(this).attr('data-type-id');
        $('#editBreed').val(name);
        $('#editType').val(type);

        $('#edit-form').attr('action', link);
    });

    $(function() {
        $("#table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,


        });
    });
</script>
@endsection