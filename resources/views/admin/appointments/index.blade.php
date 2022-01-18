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
          <h1 class="m-0">Starter Page</h1>
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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">DataTable with default features</h3>
        </div>

        <div class="card-body">
          <table id="table" class="table table-hover table-striped">
            <thead>
              <tr>
                <th>created at</th>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Purpose</th>
                <th>Date</th>
                <th>Status</th>

              </tr>
            </thead>
            <tbody>
              @foreach($appointments as $appointment)
              <tr  class='clickable-row' data-href="{{route('appointment',$appointment->id)}}" >
                <td>{{$appointment->created_at->diffForHumans()}}</td>
                <td>{{$appointment->id}}</td>
                <td>{{$appointment->user->getName()}}</td>
                <td>{{$appointment->user->email}}</td>
                <td>{{$appointment->user->contact_number}}</td>
                <td>{{$appointment->purpose}}</td>
                <td>{{date('F m, Y h:m:s a', strtotime($appointment->date))}}</td>
                <td>
                  @if($appointment->status == 'pending')
                  <span class="badge badge-warning">Pending</span>
                  @elseif($appointment->status == 'approved')
                  <span class="badge badge-success">Approved</span>
                  @elseif($appointment->status == 'rejected')
                  <span class="badge badge-danger">Rejected</span>
                  @elseif($appointment->status == 'cancelled')
                  <span class="badge badge-danger">Cancelled</span>
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