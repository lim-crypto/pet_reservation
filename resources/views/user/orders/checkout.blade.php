@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-4 order-md-2  mb-4 p-3">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your Order Summary</span>
                <span class="badge badge-secondary badge-pill">{{$products->count()}}</span>
            </h4>
            <ul class="list-group mb-3">
                @foreach($products as $product)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{$product->name}}</h6>
                        <small class="text-muted">&#8369; {{$product->price}}</small>
                        <small class="text-muted">Qty : {{$product->quantity}}</small>
                    </div>
                    <span class="text-muted"> &#8369; {{$product->price * $product->quantity}} </span>
                </li>
                @endforeach

                <li class="list-group-item d-flex justify-content-between bg-light">
                    <div class="text-primary">
                        <h6 class="my-0"> Sub total </h6>
                    </div>
                    <span class="text-primary"> &#8369; {{$cartSubTotal}} </span>
                </li>
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <div class="text-info">
                        <h6 class="my-0">Shipping Fee</h6>
                    </div>
                    <span class="text-info"> &#8369; {{$shippingFee}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (PHP)</span>
                    <strong> &#8369; {{$cartFinalTotal}} </strong>
                </li>
            </ul>
        </div>
        <div class="col-md-8 order-md-1 border shadow p-3">
            <h4 class="mb-3">Shipping address</h4>
            <form class="needs-validation" novalidate="" action="{{route('checkout')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" id="firstName" placeholder="" value="{{Auth::user()->first_name}}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="{{Auth::user()->last_name}}" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="{{Auth::user()->email}}" disabled>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="houseNumber">House number</label>
                        <input type="text" id="houseNumber" name="houseNumber" class="form-control" id="houseNumber" value="{{$shippingAddress ? $shippingAddress->houseNumber : ''}}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" name="street" id="street" value="{{$shippingAddress ? $shippingAddress->street : ''}}">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="brgy">BRGY</label><span style="color: red !important; display: inline; float: none;">*</span>
                        <input type="text" class="form-control" id="brgy" name="brgy" required value="{{$shippingAddress  ? $shippingAddress->brgy : ''}}">
                        <div class="invalid-feedback">
                            Barangay is required.
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="city">City</label><span style="color: red !important; display: inline; float: none;">*</span>
                        <input type="text" class="form-control" id="city" name="city" required value="{{$shippingAddress ? $shippingAddress->city : ''}}">
                        <div class="invalid-feedback">
                            City required.
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="province">Province / State</label><span style="color: red !important; display: inline; float: none;">*</span>
                        <input type="text" class="form-control" name="province" id="province" required value="{{$shippingAddress ? $shippingAddress->province : '' }}">
                        <div class="invalid-feedback">
                            Please provide a valid state.
                        </div>
                    </div>
                   <div class="col-md-4 mb-3">
                        <label for="country">Country</label><span style="color: red !important; display: inline; float: none;">*</span>
                        <input type="text" id="country" name="country" class="form-control" id="country" required value="{{$shippingAddress ? $shippingAddress->country : ''}}">
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info" name="saveInfo">
                    <label class="custom-control-label" for="save-info">Save this information for next time</label>
                </div>
                <hr class="mb-4">

                <button class="btn btn-primary btn-lg btn-block" type="submit">Place order now</button>

            </form>
        </div>
        <!-- <div class="col-md-12 order-md-3">
        </div> -->
    </div>
</div>
@endsection

@section('pluginsjs')
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@endsection

@section('js')
<script src="{{asset('js/jquery-validation.js')}}"></script>
@endsection