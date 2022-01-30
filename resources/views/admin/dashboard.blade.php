<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('admin.layouts.head')
  @include('admin.layouts.script')
  <!-- fullCalendar -->
  <script src="{{asset('Adminlte/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('Adminlte/plugins/fullcalendar/main.min.js')}}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"><a href="{{route('admin.home')}}">Dashboard</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{$reservation}}</h3>

                  <p>Reservations</p>
                </div>
                <div class="icon">
                  <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{route('reservations')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{$appointment}}</h3>
                  <p>Appointments</p>
                </div>
                <div class="icon">
                  <i class="fas fa-calendar-check nav-icon"></i>
                </div>
                <a href="{{route('appointments')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-secondary">
                <div class="inner">
                  <h3>{{$pets}}</h3>

                  <p>Pets</p>
                </div>
                <div class="icon">
                  <i class="fas fa-paw"></i>
                </div>
                <a href="{{route('pets.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$users}}</h3>

                  <p>User Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-sm-6 mb-4">
                  <div class="card card-outline card-primary h-100">
                    <div class="card-header">
                      <h1 class="card-title">
                        Latest Reservations
                      </h1>
                    </div>
                    <div class="card-body">
                      @foreach($latestReservations as $reservation)
                      <a href="{{route('reservation', $reservation->id)}}">
                        <span class="text-muted small">{{ $reservation->created_at->diffForHumans()}}</span>
                        <p class="card-text mb-2"> {{date('m/d/Y h a',strtotime($reservation->date))}}
                          @if($reservation->status == 'pending')
                          <span class="badge badge-warning">Pending</span>
                          @elseif($reservation->status == 'approved')
                          <span class="badge badge-success">Approved</span>
                          @elseif($reservation->status == 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                          @elseif($reservation->status == 'cancelled')
                          <span class="badge badge-danger">Cancelled</span>
                          @elseif($reservation->status == 'expired')
                          <span class="badge badge-danger">Expired</span>
                          @else
                          <span class="badge badge-success">Completed</span>
                          @endif
                        </p>
                      </a>
                      <hr class="mb-2">
                      @endforeach

                    </div>
                    <div class="card-footer">
                      <a href="{{route('reservations')}}" class="btn btn-primary">View All</a>
                    </div>
                  </div>

                </div>
                <div class="col-sm-6 mb-4">
                  <div class="card card-outline card-success h-100">
                    <div class="card-header">
                      <h1 class="card-title">
                        Latest Appointment
                      </h1>
                    </div>
                    <div class="card-body">
                      @foreach($latestAppointments as $appointment)
                      <span class="text-muted small">{{ $appointment->created_at->diffForHumans()}}</span>
                      <p class="card-text mb-2"> {{date('m/d/Y h a',strtotime($appointment->date))}}
                        @if($appointment->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                        @elseif($appointment->status == 'approved')
                        <span class="badge badge-success">Approved</span>
                        @elseif($appointment->status == 'rejected')
                        <span class="badge badge-danger">Rejected</span>
                        @elseif($appointment->status == 'cancelled')
                        <span class="badge badge-danger">Cancelled</span>
                        @elseif($appointment->status == 'expired')
                        <span class="badge badge-danger">Expired</span>
                        @else
                        <span class="badge badge-success">Completed</span>
                        @endif
                      </p>
                      <hr class="mb-2">
                      @endforeach

                    </div>
                    <div class="card-footer">
                      <a class="btn btn-success" href="{{route('appointments')}}">View All</a>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-md-6 mb-4">
              <div class="card card-outline card-secondary">
                {!! $calendar->calendar() !!}
                {!! $calendar->script() !!}
              </div>
            </div>
          </div>

        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    @include('admin.layouts.footer')
  </div>
</body>

</html>