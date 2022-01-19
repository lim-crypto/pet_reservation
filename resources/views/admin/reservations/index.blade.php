@extends('admin.layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('main-content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Reservations</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="d-flex">
        <h4 class="text-muted">Filter : &nbsp; </h4>
        <div class="dropdown">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
            Status
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('reservationByStatus','pending')}}">Pending</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','approved')}}">Approved</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','cancelled')}}">Cancelled</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','rejected')}}">Rejected</a>
            <a class="dropdown-item" href="{{route('reservationByStatus','completed')}}">Completed</a>
            <a class="dropdown-item" href="{{route('reservations')}}">All</a>
          </div>
        </div>
      </div>

      <div class="card">

        <div class="card-body">
          <table id="table" class="table  table-striped table-hover ">
            <thead>
              <tr>
                <th>created at</th>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Pet name</th>
                <th>Status</th>


              </tr>
            </thead>
            <tbody>
              @foreach($reservations as $reservation)
              <tr class='clickable-row' data-href="{{route('reservation',$reservation->id)}}">
                <td>{{$reservation->created_at->diffForHumans()}}</td>
                <td>{{$reservation->id}}</td>
                <td>{{$reservation->user->getName()}}</td>
                <td>{{$reservation->user->email}}</td>
                <td>{{$reservation->user->contact_number}}</td>
                <td>{{$reservation->pet->name}}</td>
                <td>
                  @if($reservation->status == 'pending')
                  <span class="badge badge-warning">Pending</span>
                  @elseif($reservation->status == 'approved')
                  <span class="badge badge-success">Approved</span>
                  @elseif($reservation->status == 'rejected')
                  <span class="badge badge-danger">Rejected</span>
                  @elseif($reservation->status == 'cancelled')
                  <span class="badge badge-danger">Cancelled</span>
                  @else
                  <span class="badge badge-success  ">Completed</span>
                  @endif


                </td>

              </tr>
              @endforeach
            </tbody>

          </table>
        </div>
      </div>

    </div><!-- /.container-fluid -->

  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')

<!-- DataTables  & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>


<!-- Page specific script -->
<script>
  $(function() {
    $("#table").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false
    });
    //  on click of row
    $(".clickable-row").click(function() {
      window.location = $(this).data("href");
    }).css("cursor", "pointer");

  });
</script>
@endsection