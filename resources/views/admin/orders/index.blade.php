@extends('admin.layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection
@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Orders</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Orders</h3>
                        </div>
                        <div class="card-body">
                            <table id="orders-table" class="table table-sm table-hover table-head-fixed">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th>Payment Method</th>
                                        <th>Payment status</th>
                                        <th>Order Status</th>
                                        <th>Placed order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->getName() }}</td>
                                        <td>{{ $order->shipping_address }}</td>
                                        <td> &#8369; {{ $order->total }}</td>
                                        <td>{{ $order->payment_method  }}</td>
                                        <td>{{ $order->payment_status  }}</td>
                                        <td>
                                            @if($order->status == 'pending')
                                            <span class="badge badge-pill badge-warning   py-1 px-2">{{$order->status}}</span>
                                            @elseif($order->status == 'packed')
                                            <span class="badge badge-pill badge-info   py-1 px-2">{{$order->status}}</span>
                                            @elseif($order->status == 'shipped')
                                            <span class="badge badge-pill badge-secondary   py-1 px-2">{{$order->status}}</span>
                                            @elseif($order->status == 'delivered')
                                            <span class="badge badge-pill badge-success   py-1 px-2">{{$order->status}}</span>
                                            @elseif($order->status == 'cancelled')
                                            <span class="badge badge-pill badge-danger   py-1 px-2">{{$order->status}}</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('order', $order->id) }}" class="btn btn-sm btn-primary">View</a>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<!-- DataTables  & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- buttons -->
<script src="{{ asset('Adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('Adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(function() {
        $("#orders-table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": [{
                    "extend": 'copy',
                    "exportOptions": {
                        "columns": ':visible'
                    }
                },
                {
                    "extend": 'csv',
                    "exportOptions": {
                        "columns": ':visible'
                    }
                }, {
                    "extend": 'excel',
                    "exportOptions": {
                        "columns": ':visible'
                    }
                },
                {
                    "extend": 'pdf',
                    "exportOptions": {
                        "columns": ':visible'
                    }
                },
                {
                    "extend": 'print',
                    "exportOptions": {
                        "columns": ':visible'

                    }

                },


                'colvis'
            ]
        }).buttons().container().appendTo('#orders-table_wrapper .col-md-6:eq(0)');

    });
</script>
@endsection