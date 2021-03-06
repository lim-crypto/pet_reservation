@extends('admin.layouts.app')

@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Service </h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('services.index')}}">Service </a></li>
                        <li class="breadcrumb-item active">add Service</li>
                    </ol>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">

                    <!-- general form elements -->
                    <div class="card card-success card-outline">
                        <!-- form start -->
                        <form action="{{route('services.update',$service->id)}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="service">Service</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="service" id="service" placeholder="Service" required value="{{$service->service}}">
                                    <span class="invalid-feedback" role="alert">
                                        Service name is required
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label><span class="text-danger">*</span>
                                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="description" required>{{$service->description}}</textarea>
                                    <span class="invalid-feedback" role="alert">
                                        Description is required
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label> <span class="text-danger">*</span>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input  {{ $errors->has('image') ? ' is-invalid'  :''  }}" accept="image/*">
                                        <label class="custom-file-label" for="gallery-photo-add">Choose Image</label>
                                        <div class="invalid-feedback">
                                            Please choose image
                                        </div>
                                    </div>
                                </div>

                                <div class="offers-container">
                                    <div class="form-group">

                                        <label for="offer">Offer</label> <span class="text-danger">*</span>
                                        <span class="btn btn-success add-more float-right">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        @foreach($service->offer as $offer)
                                        <div class="input-group mt-3">
                                            <input type="text" class="form-control offers" name="offer[]" required multiple="multiple" placeholder="Offer" value="{{$offer->offer}}">
                                            <input type="number" step="any" class="form-control price" name="price[]" required multiple="multiple" placeholder="Price" value="{{$offer->price}}">
                                            <div class="input-group-append">
                                                <span class="btn btn-danger remove-offer "><i class="fas fa-times"></i></span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="form-group">
                                    <a href="{{route('services.index')}}" class="btn btn-warning"> <i class="fas fa-angle-double-left"></i> Back</a>
                                    <button type="submit" class="btn btn-success float-right">Save</button>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                    <!-- /.card -->
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

<!-- bs-custom-file-input -->
<script src="{{asset('Adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>


<!-- specific script -->
<script>
    $('form').submit(function() {
        $(this).find('button[type=submit]').attr('disabled', true);
    });
    $('input').on('keydown', function() {
        $('button[type=submit]').removeAttr('disabled');
    });
    $('input').on('change', function() {
        $('button[type=submit]').removeAttr('disabled');
    });
    $('select').on('change', function() {
        $('button[type=submit]').removeAttr('disabled');
    });
    $('textarea').on('keydown', function() {
        $('button[type=submit]').removeAttr('disabled');
    });


    $(function() {
        bsCustomFileInput.init();
    });

    // add another input field of offer
    $(document).on('click', '.add-more', function() {
        var html = '<div class="input-group mt-3"><input type="text" class="form-control offers" name="offer[]" required multiple="multiple" placeholder="Offer">   <input type="number" class="form-control price" name="price[]" required multiple="multiple" placeholder="Price" ><div class="input-group-append"><span class="btn btn-danger remove-offer "><i class="fas fa-times"></i></span></div></div>';
        $('.offers-container .form-group').append(html);
    });
    // remove input field of offer
    $(document).on('click', '.remove-offer', function() {
        $(this).parent().parent().remove();
    });
</script>
@endsection