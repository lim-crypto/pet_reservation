@extends('layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Your Orders</h2>
                </div>
                <div class="panel-body">
                    <table id="orders-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order number</th>

                                <th>Order Status</th>
                                <th>Payment method</th>
                                <th>Total</th>
                                <th>Placed order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="text-capitalize">{{ $order->status }}
                                    @if($order->status == 'pending')
                                    <span class="text-xs text-muted font-weight-light ">{{$order->created_at->format('d M  Y h:i:s A')}}</span>
                                    @elseif($order->status == 'packed')
                                    <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->packed_at))}}</span>
                                    @elseif($order->status == 'shipped')
                                    <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->shipped_at))}}</span>
                                    @elseif($order->status == 'delivered')
                                    <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->delivered_at))}} </span>
                                    @elseif($order->status == 'cancelled')
                                    <span class="text-xs text-muted font-weight-light "> {{date('d M Y h:i:s A', strtotime($order->cancelled_at))}} </span>
                                    @endif

                                </td>
                                <td>{{ $order->payment_method  }}</td>
                                <td> &#8369; {{ $order->total }}</td>
                                <td>{{ $order->created_at->diffForHumans() }}
                                    <span class="text-xs text-muted font-weight-light ">{{$order->created_at->format('d M  Y h:i:s A')}}</span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-default">View</a>
                                    <button title="Cancel order" href="#!" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger{{$order->id}}" {{$order->status =='pending' ? '' : 'disabled'}}>Cancel</button>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-danger{{$order->id}}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h4 class="modal-title">Confirmation</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to cancel order <b> {{ $order->id}} ?</b></p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <form action="{{route('orders.cancel' , $order->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="submit" value="Confirm" class="btn btn-danger" />
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>


<script>
    $(function() {
        $("#orders-table").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,

        });

    });
</script>
@endsection