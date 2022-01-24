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
        <div class="col-md-8" data-aos="zoom-in">
            <div class="card">
                <h1 class="card-header text-success">Appointment Form</h1>

                <div class="card-body">
                    <form action="{{route('appointment.store')}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <!-- first name -->
                                <div class="form-group">
                                    <label for="">First name</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- last name -->
                                <div class="form-group">
                                    <label for="">Last name</label> <span class="text-danger">*</span>
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
                                    <label for="">Contact number</label> <span class="text-danger">*</span>
                                    <input type="tel" class="form-control" name="contact_number" placeholder="Enter your contact number" value="{{ old('contact_number') ? old('contact_number') : auth()->user()->contact_number}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <!-- Date -->
                                <div class="form-group">
                                    <label>Date:</label> <span class="text-danger">*</span>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input id="date" type="text" name="date" class="form-control datetimepicker-input" data-target="#reservationdate" data-toggle="datetimepicker" required>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- time -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="time">Time:</label> <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <select class="form-control" name="time" id="time"  required disabled>
                                            <option disabled selected value="">Select time</option>
                                            <option value="7:00 AM">7:00 AM</option>
                                            <option value="8:00 AM">8:00 AM</option>
                                            <option value="9:00 AM">9:00 AM</option>
                                            <option value="10:00 AM">10:00 AM</option>
                                            <option value="11:00 AM">11:00 AM</option>
                                            <option value="12:00 PM">12:00 PM</option>
                                            <option value="1:00 PM">1:00 PM</option>
                                            <option value="2:00 PM">2:00 PM</option>
                                            <option value="3:00 PM">3:00 PM</option>
                                            <option value="4:00 PM">4:00 PM</option>
                                            <option value="5:00 PM">5:00 PM</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <!-- select purpose -->
                                <div class="form-group">
                                    <label for="service">Service</label> <span class="text-danger">*</span>
                                    <select id="service" class="form-control" name="purpose" required>
                                        <option selected disabled value="">Select Service</option>
                                        @foreach ($services as $service)
                                        <option value="{{$service->service}}">{{$service->service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="offer">Offer</label> <span class="text-danger">*</span>
                                    <select class="form-control" name="offer" id="offer" required disabled>
                                        <option selected disabled data-service="" value="">Select offer</option>
                                        @foreach($services as $service)
                                        @foreach($service->offer as $offer)
                                        <option data-service="{{$service->service}}" value="{{$offer->offer}}">{{$offer->offer }}&nbsp;&nbsp;&nbsp; &#8369; &nbsp;{{$offer->price }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>
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
var disabledDates = {!! $disabledDates!!};
    $('#reservationdate').datetimepicker({
        minDate: new Date(),
        format: 'L',
        disabledDates: disabledDates,
    });

    var dates = {!! $dates !!};
    $('#date').blur( function() {
        var date = $(this).val();
        if (date == moment().format('L')) {
            $(this).val(''); // if today is selected, clear the field
        }
        var date_format = moment(date, 'MM-DD-YYYY').format('YYYY-MM-DD');
        $('#time').removeAttr('disabled');
        $('div.form-group').find('#time').find('option').each(function() {
            if ($(this).val() != '') { // if not empty || <option disabled value="">Select time</option>
                var time = $(this).val();
                var time_format = moment(time, 'hh:mm A').format('HH:mm:ss');
                if (dates.includes(date_format + ' ' + time_format)) {
                    $(this).attr('disabled', 'disabled').text(time + ' not available');
                    $('#time').val('');
                } else {
                    $(this).removeAttr('disabled').text(time);
                }
            }
        });
    });
    $('#service').change(function() {
        $('#offer').removeAttr('disabled').val('');

        var service = $(this).val().toLowerCase();
        $('div.form-group').find('#offer').find('option').each(function() {
            if ($(this).attr('data-service').toLowerCase() == service) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
</script>
@endsection