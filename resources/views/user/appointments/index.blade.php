<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')
    @include('layouts.script')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

    <!-- fullCalendar -->
    <script src="{{asset('Adminlte/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('Adminlte/plugins/fullcalendar/main.min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 3px;
        }
    </style>
</head>

<body>
    <div id="loading">
        <img id="loading-image" src="https://help.presentations2go.eu/LTI/lib/Spinner.gif" alt="Loading..." />
    </div>
    <div id="app">
        @include('layouts.nav')
        <main>
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('appointment.create') }}" class="btn custom-bg-color float-right">
                                    <i class="fas fa-plus"></i>
                                    New Appointment
                                </a>
                                <h1 class="h2 mb-0">Appointments</h1>

                            </div>
                            <div class="card-body">
                                <table id="table" class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Service</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{++$loop->index}}</td>
                                            <td>{{$appointment->purpose}}</td>
                                            <td>{{$appointment->date}}</td>
                                            <td>
                                                @if($appointment->status == 'pending')
                                                <span class="badge badge-warning">{{$appointment->status}}</span>
                                                @elseif($appointment->status == 'approved')
                                                <span class="badge badge-success">{{$appointment->status}}</span>
                                                @elseif($appointment->status == 'rejected')
                                                <span class="badge badge-danger">{{$appointment->status}}</span>
                                                @elseif($appointment->status == 'cancelled')
                                                <span class="badge badge-danger">{{$appointment->status}}</span>
                                                @elseif($appointment->status == 'completed')
                                                <span class="badge badge-success">{{$appointment->status}}</span>
                                                @endif


                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm cancelModal" data-toggle="modal" data-target="#cancelModal" data-purpose="{{$appointment->purpose}}" data-link="{{route('appointment.cancel',$appointment->id)}}" @if ($appointment->status != 'pending' ) disabled @endif>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card card-outline card-primary ">
                            {!! $calendar->calendar() !!}
                            {!! $calendar->script() !!}
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
                                <button type="sumbit" class="btn btn-danger">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- DataTables  & Plugins -->
    <script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>


    <!-- Page specific script -->
    <script>
        // cancel
        $('.cancelModal').click(function() {
            const purpose = $(this).attr('data-purpose');
            const link = $(this).attr('data-link');
            $('#cancelModalText').text(`Are you sure you want to cancel ${purpose}?`);
            $('#cancel-form').attr('action', link);
        });
        $(function() {
            $("#table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            });

        });
    </script>
</body>

</html>