@extends('layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')

<div class="container">
  <div class="row mt-5">
    <div class="col-md-8">
      <h1>Cart</h1>


      <table id="cart-table" class="table table-sm table-head-fixed ">
        <thead>
          <tr>
            <th>Product image</th>
            <th>Product name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
          <tr class="text-center">
            <td>
              <a href="{{route('product',$product->id)}}">
                <img class="rounded img-fluid" src="{{ asset('storage/images/products/'. $product->attributes->image) }}" alt="image" style="height:100px; object-fit:cover;">
              </a>
            </td>
            <td> <a href="{{route('product',$product->id)}}"> {{ $product->name}} </a></td>
            <td> &#8369; {{$product->price}} </td>
            <td>
              <p class="d-none">{{ $product->quantity }}</p>
              <form action="{{ route('carts.update', $product->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="d-flex align-items-center">
                  <input class="form-control form-control-sm mr-2" type="number" min="1" name="quantity" value="{{ $product->quantity }}" style="width:50px">
                  <button type="submit" class="btn custom-bg-color btn-sm btn-save">Save</button>
                </div>
              </form>
            </td>
            <td> <a class="btn btn-outline-danger" id="remove" href="{{ route('carts.remove', $product->id) }}"><i class="fas fa-trash"></i></a> </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">
              <h5>No item in cart</h5>
              <a class="btn custom-bg-color mt-5" href="{{route('products')}}"> Shop Now </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if(count($products) > 0)
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3>Cart Summary</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p>Subtotal</p>
              <p>Shipping</p>
              <p>Total</p>
            </div>
            <div class="col-md-6">
              <p> &#8369; {{$cartSubTotal}}</p>
              <p> &#8369; {{number_format((float)$shippingFee, 2, '.', '')}}</p>
              <p> &#8369; {{$cartFinalTotal}}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <a href="{{route('checkout')}}" class="btn custom-bg-color btn-block">Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
@section('script')

<!-- DataTables  & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<script>
  $(function() {
    $("#cart-table").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "searching": false,
    });

  });
  $('#remove').click(function(){
    console.log('clicked');
    $(this).addClass('disabled');
  })
</script>
@endsection