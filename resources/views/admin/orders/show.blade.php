@extends('admin.layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<style>
  .track {
    position: relative;
    background-color: #ddd;
    height: 7px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 60px;
    margin-top: 50px
  }

  .track .step {
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    width: 25%;
    margin-top: -18px;
    text-align: center;
    position: relative
  }

  .track .step.active:before {
    background: #14a800;
  }

  .track .step::before {
    height: 7px;
    position: absolute;
    content: "";
    width: 100%;
    left: 0;
    top: 18px
  }

  .track .step.active .icon {
    background: #14a800;
    color: #fff
  }

  .track .icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    position: relative;
    border-radius: 100%;
    background: #ddd
  }

  .track .step.active .text {
    font-weight: 400;
    color: #000
  }

  .track .text {
    display: block;
    margin-top: 7px
  }
</style>
@endsection
@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Order</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="container">
        <div class="row">
          <div class="col-12">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <img src="{{ asset('images/kennel-logo.png') }}" width="40" alt="" class="float-left">
                  <h4 class="align-middle">
                    {{ config('app.name', 'PremiumKennel') }}
                    <small class="float-right">Date: {{$order->created_at->format('d M  Y ')}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>

              <!-- /.row -->
              <div class="card mt-3">
                <header class="card-header">
                  <h4 class="card-title"> Orders / Tracking</h4>
                  <div class="card-tools">
                    @if($order->status == 'pending')
                    <span class="text-xs text-muted">{{$order->created_at->format('d M  Y h:i:s A')}}</span>
                    <span class="badge badge-pill badge-warning ml-2 py-1 px-2">{{$order->status}}</span>
                    @elseif($order->status == 'packed')
                    <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->packed_at))}}</span>
                    <span class="badge badge-pill badge-info ml-2 py-1 px-2">{{$order->status}}</span>
                    @elseif($order->status == 'shipped')
                    <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->shipped_at))}}</span>
                    <span class="badge badge-pill badge-secondary ml-2 py-1 px-2">{{$order->status}}</span>
                    @elseif($order->status == 'delivered')
                    <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->delivered_at))}} </span>
                    <span class="badge badge-pill badge-success ml-2 py-1 px-2">{{$order->status}}</span>
                    @elseif($order->status == 'cancelled')
                    <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->cancelled_at))}} </span>
                    <span class="badge badge-pill badge-danger ml-2 py-1 px-2">{{$order->status}}</span>
                    @endif

                  </div>
                </header>
                <div class="card-body pb-5">
                  @if($order->status != 'cancelled')
                  <form action="{{route('orders.updateStatus',$order->id)}}" method="post" class="float-right">
                    @csrf
                    @method('PUT')
                    <select name="status" id="" class=" form-control-sm">
                      <option value="pending" {{$order->status == 'pending' ?   'selected': ''}}>Pending</option>
                      <option value="packed" {{$order->status == 'packed' ?   'selected' : ''}}>Packed</option>
                      <option value="shipped" {{$order->status == 'shipped' ?   'selected' : ''}}>Shipped</option>
                      <option value="delivered" {{$order->status == 'delivered' ?   'selected' : ''}}>Delivered</option>
                      <!-- <option value="cancelled" {{$order->status == 'cancelled' ?   'selected' : ''}} >Cancelled</option> -->
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                  </form>
                  @endif
                  <h6>Order ID: {{$order->order_id}}</h6>
                  <div class="track">
                    @if($order->status != 'cancelled')
                    <div class="step active">
                      <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                      <span class="text">Placed Order</span>
                      <span class="text-xs text-muted">{{$order->created_at->format('d M  Y h:i:s A')}}</span>
                    </div>
                    <div class="step {{$order->status != 'pending' ? 'active' : ''}}">
                      <span class="icon"><i class="fa fa-box"></i></span>
                      <span class="text">Packed</span>
                      <span class="text-xs text-muted"> {{$order->packed_at ? date('d M Y h:i:s A', strtotime($order->packed_at)) : ''}}</span>
                    </div>
                    <div class="step {{$order->status=='shipped' ? 'active' : ($order->status=='delivered' ? 'active' : '') }}">
                      <span class="icon"> <i class="fa fa-truck"></i> </span>
                      <span class="text"> On the way </span>
                      <span class="text-xs text-muted"> {{$order->shipped_at ? date('d M Y h:i:s A', strtotime($order->shipped_at)) : ''}}</span>
                    </div>
                    <div class="step {{$order->status=='delivered' ? 'active':''}}">
                      <span class="icon"> <i class="fa fa-check"></i> </span>
                      <span class="text">Delivered</span>
                      <span class="text-xs text-muted"> {{ $order->delivered_at ? date('d M Y h:i:s A', strtotime($order->delivered_at)) : ''}} </span>
                    </div>
                    @else
                    <div class="step active">
                      <span class="icon"> <i class="fa fa-times"></i> </span>
                      <span class="text">Cancelled</span>
                      <span class="text-xs text-muted"> {{date('d M Y h:i:s A', strtotime($order->cancelled_at))}} </span>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($order->products as $product)
                      <tr>
                        <td>
                          <img class="img-size-50" src="/storage/images/products/{{$product->attributes->image}}" alt="">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>&#8369; {{$product->price}}</td>
                        <td><span class="text-muted"></span> {{$product->quantity }}</td>
                        <td>&#8369; {{$product->price * $product->quantity  }}</td>
                      </tr>
                      @endforeach
                    </tbody>

                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <div class="col-sm-5 invoice-col">
                  <p class="lead">Shipping address</p>
                  <address>
                    <strong>{{$order->user->getName()}}</strong><br>
                    {{$order->shipping_address}}
                    <br> Email: {{$order->user->email}}
                    <br> {{$order->user->contact_number}}
                  </address>
                </div>

                <!-- accepted payments column -->
                <div class="col-sm-3">
                  <p class="lead">Payment Methods:</p>
                  @if($order->payment_method == 'COD')
                  <p class="h6">Cash on Delivery</p>
                  @else
                  <p class="h6">{{$order->payment_method}}</p>
                  <p class="lead">Payment Status:</p>
                  <p class="h6">{{$order->payment_status}}</p>
                  <p class="lead">Transaction id:</p>
                  <p class="h6">{{$order->transaction_id}}</p>
                  @endif
                </div>
                <div class="col-sm-4">
                  <p class="lead">Order Summary</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>&#8369; {{$order->subTotal}}</td>
                      </tr>
                      <tr>
                        <th>Shipping fee:</th>
                        <td>&#8369; {{$order->shippingFee}}</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td><strong> &#8369; {{$order->total}}</strong></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
@endsection