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
        @if($reservations->count() > 0)
        <div class="col-lg-10 col-md-12">

            <div class="float-right btn-group mt-2">
                <div class="dropdown">
                    <button class="btn btn-sm custom-bg-color" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sliders-h"></i> Filters
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="all"> All items </a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="pending"> Pending</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="approved"> Approved</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="cancelled"> Cancelled</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="rejected"> Rejected</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="expired"> Expired</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-filter="completed"> Completed</a>
                    </div>
                </div>
                <select class="custom-select" style="width: auto; display:none;" data-sortOrder>
                    <option value="sortData"> Sort by Custom Data </option>
                </select>
                <a class="btn btn-sm btn-default sort-btn asc" href="javascript:void(0)" data-sortAsc> <i class="fas fa-sort"></i> Sort </a>
                <a class="btn btn-sm btn-default sort-btn desc d-none" href="javascript:void(0)" data-sortDesc> <i class="fas fa-sort"></i> Sort </a>
            </div>
            <div class="h1">Reservations</div>
            <div class="filter-container">
                @foreach($reservations as $reservation)
                <div class="filtr-item col-lg-3 col-md-4 col-6" data-category="{{$reservation->status}}" data-sort="{{date( 'm/d/y', strtotime($reservation->created_at))}}">
                    <div class="card h-100 ">
                        <a href="{{route('petDetails', $reservation->pet->slug)}}">
                            <img src="{{asset('storage/images/pets/'.$reservation->pet->images[0])}}" class="card-img-top" alt="{{$reservation->pet->name}}" title="view info" style="height:250px; object-fit:cover;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{$reservation->pet->breed->name}} </h5>
                            @if($reservation->status == 'pending')
                            <span class="badge badge-warning float-right">Pending</span>
                            @elseif($reservation->status == 'cancelled')
                            <span class="badge badge-danger float-right">Cancelled</span>
                            @elseif($reservation->status == 'rejected')
                            <span class="badge badge-danger float-right">Rejected</span>
                            @elseif($reservation->status == 'approved')
                            <span class="badge badge-success float-right">Approved</span>
                            @elseif($reservation->status == 'expired')
                            <span class="badge badge-danger float-right">Expired</span>
                            @else
                            <span class="badge badge-success float-right">Completed</span>
                            @endif
                            <p class="card-text custom-color mb-0">{{$reservation->pet->name}} </p>
                            <p class="text-muted small mb-0">{{$reservation->pet->type->name}}</p>
                            <p class="text-muted small mb-0">{{date( 'm/d/y h a', strtotime($reservation->date))}}</p>
                            <span class="text-muted small">{{ $reservation->created_at->diffForHumans()}}</span>
                            @if($reservation->status == 'pending')
                            <div class="btn-group float-right">
                                <button title="cancel" type="button" class="btn btn-outline-danger btn-xs cancelModal float-right" data-toggle="modal" data-target="#cancelModal" data-reservation="{{$reservation->pet->breed->name.' '.$reservation->pet->name}}" data-link="{{route('reservation.cancel',$reservation->id)}}">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                                <button title="edit" type="button" class="btn  btn-outline-secondary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-date="{{$reservation->date}}" data-link="{{route('reservation.update',$reservation->id)}}">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </div>
                            @endif

                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="col-lg-10 col-md-12">
            <div class="d-flex justify-content-center pt-4">
                <div class="h1">You don't have reservation</div>
            </div>
        </div>
        @endif
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
<!-- Filterizr-->
<script src="{{ asset('Adminlte/plugins/filterizr/jquery.filterizr.min.js') }}"></script>

<script>
    $('.filter-container').filterizr({
        gutterPixels: 3
    });
    $('.btn[data-filter]').on('click', function() {
        $('.btn[data-filter]').removeClass('active');
        $(this).addClass('active');
    });
    // sort toggle
    $('.sort-btn').on('click', function() {
        console.log(1);
        if ($(this).hasClass('asc')) {
            $('.asc').hide();
            $('.desc').show();
            $('.desc').removeClass('d-none')
        } else {
            $('.desc').hide();
            $('.asc').show();
        }

    });


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