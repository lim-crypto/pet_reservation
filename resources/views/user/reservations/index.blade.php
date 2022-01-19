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
        <div class="col-lg-10 col-md-12  order-lg-2">
            <div class="h1">Reservations</div>

            <div class="row">
                @foreach($reservations as $reservation)

                <div class=" col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 ">

                        <a href="{{route('petDetails', $reservation->pet->slug)}}">
                            <img src="{{asset('storage/images/pets/'.$reservation->pet->images[0])}}" class="card-img-top" alt="{{$reservation->pet->name}}" title="view info" style="height:250px; object-fit:cover;">
                        </a>
                        <div class="card-body pb-0">
                            <h5 class="card-title">{{$reservation->pet->breed->name}}</h5>
                            @if($reservation->status == 'pending')
                            <span class="badge badge-warning float-right">Pending</span>
                            @elseif($reservation->status == 'cancelled')
                            <span class="badge badge-danger float-right">Cancelled</span>
                            @elseif($reservation->status == 'rejected')
                            <span class="badge badge-danger float-right">Rejected</span>
                            @elseif($reservation->status == 'approved')
                            <span class="badge badge-success float-right">Approved</span>
                            @else
                            <span class="badge badge-success float-right">Completed</span>
                            @endif
                            <p class="card-text">{{$reservation->pet->name}}</p>
                            <p class="card-text text-muted small ">{{$reservation->pet->type->name}}</p>
                            @if($reservation->status == 'pending')
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-danger btn-sm cancelModal float-right" data-toggle="modal" data-target="#cancelModal" data-reservation="{{$reservation->pet->breed->name.' '.$reservation->pet->name}}" data-link="{{route('reservation.cancel',$reservation->id)}}">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                    <button type="button" class="btn  btn-outline-secondary btn-sm editModal" data-toggle="modal" data-target="#editModal" data-date="{{$reservation->date}}" data-link="{{route('reservation.update',$reservation->id)}}">
                                        <i class="fas fa-calendar"></i>
                                        Edit
                                    </button>
                                </div>
                                <small class="text-muted">{{date( 'm/d/y', strtotime($reservation->date))}}</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @endforeach
                @if($reservations->count() == 0)
                <div class="col-12 text-center">
                    <div class="card bg-secondary">

                        <div class="card-body">
                            <h4>No <strong>
                                    @if(session()->has('status'))
                                    {{session()->get('status')}}
                                    {{session()->forget('status')}}
                                    @endif

                                </strong> reservation</h4>

                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="d-flex justify-content-center pt-4">
                {!! $reservations->links() !!}
            </div>
        </div>
        <div class="col-md-2 col-sm-12 mt-2 order-lg-1">
            <div class="card mt-md-5">
                <div class="card-header">
                    <h4>
                        Filter
                    </h4>
                </div>
                <div class="card-body">
                    <a class="btn custom-bg-color btn-block" href="{{route('user.reservations')}}">All</a>
                    <a class="btn custom-bg-color btn-block" href="{{route('getReservationByStatus','pending')}}">Pending</a>
                    <a class="btn custom-bg-color btn-block" href="{{route('getReservationByStatus','approved')}}">Approved</a>
                    <a class="btn custom-bg-color btn-block" href="{{route('getReservationByStatus','cancelled')}}">Cancelled</a>
                    <a class="btn custom-bg-color btn-block" href="{{route('getReservationByStatus','rejected')}}">Rejected</a>
                    <a class="btn custom-bg-color btn-block" href="{{route('getReservationByStatus','completed')}}">Completed</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cancel modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Confirm Cancellation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="cancelModalText">Are you sure you want to cancel this?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <form id="cancel-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="sumbit" class="btn btn-danger">Yes</button>
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
                <div class="modal-body row">
                    <div class="col-6">
                        <!-- Date -->
                        <div class="form-group">
                            <label>Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" data-toggle="datetimepicker" required>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- time -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="time">Time:</label>
                            <div class="input-group">
                                <select class="form-control" name="time" id="time">
                                    <option value="07:00 AM">7:00 AM</option>
                                    <option value="08:00 AM">8:00 AM</option>
                                    <option value="09:00 AM">9:00 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="01:00 PM">1:00 PM</option>
                                    <option value="02:00 PM">2:00 PM</option>
                                    <option value="03:00 PM">3:00 PM</option>
                                    <option value="04:00 PM">4:00 PM</option>
                                    <option value="05:00 PM">5:00 PM</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
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
        //Date picker
        $('#reservationdate').datetimepicker({
            minDate: new Date(new Date().getTime() + (1 * 24 * 60 * 60 * 1000)),
            maxDate: new Date(new Date().getTime() + (7 * 24 * 60 * 60 * 1000)),
            format: 'L'
        });
    });
</script>
<script>
    // cancel
    $('.cancelModal').click(function() {
        const reservation = $(this).attr('data-reservation');
        const link = $(this).attr('data-link');
        $('#cancelModalText').text(`Are you sure you want to cancel ${reservation}?`);
        $('#cancel-form').attr('action', link);
    });
    // edit
    $('.editModal').click(function() {
        const date = $(this).attr('data-date');
        const link = $(this).attr('data-link');
        const dateFormat = moment(date).format('MM/DD/YYYY');
        const time = moment(date).format('hh:mm A');
        $('#edit-form').attr('action', link);
        $('#date').val(dateFormat);
        $('#time').val(time);
        $('#time').find('option').each(function() {
            if ($(this).val() == time) {
                $(this).attr('selected', 'selected');
            }
        });
    });
</script>
@endsection