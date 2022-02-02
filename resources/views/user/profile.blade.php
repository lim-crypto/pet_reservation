@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Profile</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('profile.update' , auth()->user()->id) }}" method="POST" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <!-- first name -->
                                <div class="form-group">
                                    <label for="firstname">First name</label>
                                    <input type="text" id="firstname" class="form-control" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- last name -->
                                <div class="form-group">
                                    <label for="lastname">Last name</label>
                                    <input type="text" id="lastname" class="form-control" name="last_name" placeholder="Enter your last name" value="{{ old('last_name') ? old('last_name') : auth()->user()->last_name}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <!-- email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control" placeholder="Enter your email" value="{{ old('email') ? old('email') : auth()->user()->email}}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- contact number -->
                                <div class="form-group">
                                    <label for="tel">Contact number</label>
                                    <input type="number" id="tel" step="any" class="form-control" name="contact_number" placeholder="Enter your contact number" value="{{ old('contact_number') ? old('contact_number') : auth()->user()->contact_number}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <a class="btn btn-outline-secondary" href="#" onclick="window.history.back()">Back</a>
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>

<script>
    $('form').submit(function() {
        $('button[type=submit]').attr('disabled', true);
    });
    $('input').on('keydown', function() {
        $('button[type=submit]').removeAttr('disabled');
    });
</script>
@endsection