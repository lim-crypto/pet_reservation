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
                <h1 class="card-header text-success">Reservation Form</h1>

                <div class="card-body">
                    <form action="{{route('reservation.store')}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        <input type="hidden" value="{{$pet->id}}" name="pet_id" required>
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
                            <div class="col-12">
                                <!-- Date and time -->
                                <div class="form-group">
                                    <label>Date and time:</label> <span class="text-info small">please pick a date within 7 days from now</span>
                                    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="date" data-target="#reservationdatetime" data-toggle="datetimepicker" required />
                                        <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-info small float-right mb-1"><i>note: your reservation will expire after 7days on the day of reservation date if not process</i></span>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success float-right">Confirm</button>

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
            maxDate: new Date(new Date().getTime() + (7 * 24 * 60 * 60 * 1000)),
            sideBySide: true,

        });
    });
</script>


@endsection