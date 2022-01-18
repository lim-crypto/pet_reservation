@extends('admin.layouts.app')


@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Breed of Pets</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('breed.index')}}">breed of Pets</a></li>
                        <li class="breadcrumb-item active">Create breed</li>
                    </ol>
                </div>
            </div>
            <!-- <a href="{{route('breed.index')}}" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Back</a> -->
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">

                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <!-- form start -->
                        <form action="{{route('breed.update', $breed->slug)}}" method="POST" class="needs-validation" novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="breed">Breed of Pets</label>
                                    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="breed" placeholder="name" value="{{$breed->name}}" required>

                                    @if($errors->has('name'))
                                    <span class="invalid-feedback">{{$errors->first('name')}}</span>
                                    @else
                                    <span class="invalid-feedback" role="alert">
                                        Breed name is required
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="type">Type of Pets</label>
                                    <select name="type_id" id="type" class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}" required>
                                        <option value="" disabled>Select type</option>
                                        @foreach($types as $type)
                                        <option value="{{$type->id}}" @if(old('type_id')==$type->id)
                                            selected
                                            @elseif(isset($breed) && $breed->type_id == $type->id)
                                            @endif
                                            >{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('type_id'))
                                    <span class="invalid-feedback">{{$errors->first('type_id')}}</span>
                                    @else
                                    <span class="invalid-feedback" role="alert">
                                        Type name is required
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-->
            </div>
            <!-- ./row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
@section('script')
<script src="{{ asset('Adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/jquery-validation/jquery-validation.js') }}"></script>
@endsection