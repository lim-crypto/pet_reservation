@extends('layouts.app')

@section('style')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/select2/css/select2.min.css')}}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/daterangepicker/daterangepicker.css')}}">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

@endsection
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header text-success">Appointment Form</h1>

                <div class="card-body">
                    <form action="{{route('appointment.store')}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <!-- first name -->
                                <div class="form-group">
                                    <label for="">First name</label>
                                    <input type="text" class="form-control" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- last name -->
                                <div class="form-group">
                                    <label for="">Last name</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Enter your last name" value="{{ old('last_name') ? old('last_name') : auth()->user()->last_name}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <!-- email -->
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" placeholder="Enter your email" value="{{ old('email') ? old('email') : auth()->user()->email}}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- contact number -->
                                <div class="form-group">
                                    <label for="">Contact number</label>
                                    <input type="tel" class="form-control" name="contact_number" placeholder="Enter your contact number" value="{{ old('contact_number') ? old('contact_number') : auth()->user()->contact_number}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <!-- select purpose -->
                                <div class="form-group">
                                    <label for="">Purpose</label>
                                    <select class="form-control" name="purpose" required>
                                        <option value="">Select purpose</option>
                                        <!-- Pet Grooming -->
                                        <option value="Pet Grooming" {{ old('purpose') == 'Pet Grooming' ? 'selected' : ''}}>Pet Grooming</option>
                                        <!-- Pet Boarding -->
                                        <option value="Pet Boarding" {{ old('purpose') == 'Pet Boarding' ? 'selected' : ''}}>Pet Boarding</option>
                                        <!-- Pet Breeding -->
                                        <option value="Pet Breeding" {{ old('purpose') == 'Pet Breeding' ? 'selected' : ''}}>Pet Breeding</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- Date and time -->
                                <div class="form-group">
                                    <label>Date and time:</label>
                                    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="date" data-target="#reservationdatetime" data-toggle="datetimepicker" required />
                                        <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn custom-bg-color float-right">Book now</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<!-- InputMask -->
<script src="{{ asset('Adminlte/plugins/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('Adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>
<script>
    $(function() {
        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            minDate: new Date(),
            sideBySide: true,

        });
    });
</script>


@endsection