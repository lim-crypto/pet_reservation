@extends('layouts.app')
@section('style')

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
        background: green;
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
        background: green;
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
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 order-md-2">
            <div class="h1">Reservations</div>
            <div class="card card-primary card-outline ">
                <header class="card-header">
                    <h4 class="card-title">Reservation ID: {{$reservation->id}}</h4>
                    <div class="card-tools">
                        @if($reservation->status == 'pending')
                        <form action="{{route('reservation.cancel', $reservation->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="submit" class="btn btn-sm btn-danger" value="cancel">
                        </form>
                        @endif

                    </div>
                </header>
                <div class="card-body pb-5">
                    <div class="track">
                        @if($reservation->status == 'cancelled')
                        <div class="step active">
                            <span class="icon"> <i class="fa fa-times"></i> </span>
                            <span class="text">Cancelled</span>
                        </div>
                        @elseif($reservation->status == 'rejected')
                        <div class="step active">
                            <span class="icon"><i class="fas fa-thumbs-down"></i></span>
                            <span class="text">Rejected</span>
                        </div>
                        @else
                        <div class="step active">
                            <span class="icon"><i class="fas fa-clock"></i></span>
                            <span class="text">Pending</span>
                        </div>
                        <div class="step {{$reservation->status=='approved' ? 'active' : ($reservation->status=='completed' ? 'active' : '') }}">
                            <span class="icon"> <i class="fas fa-thumbs-up"></i></span>
                            <span class="text"> Approved </span>
                        </div>
                        <div class="step {{$reservation->status=='completed' ? 'active':''}}">
                            <span class="icon"> <i class="fa fa-clipboard-check"></i> </span>
                            <span class="text">Completed</span>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Name: {{$reservation->user->getName()}}</p>
                            <p>Email: {{$reservation->user->email}}</p>
                            <p>Phone: {{$reservation->user->contact_number}}</p>
                        </div>
                        <div class="col-md-6">
                            <h2>{{$reservation->pet->name}}</h2>

                            <div class="row">
                                <div class="col">
                                    <div class="card-columns">
                                        @foreach($reservation->pet->images as $image)
                                        <div class="card">
                                            <img src="{{asset('storage/images/pets/'.$image)}}" class="card-img" alt="...">
                                        </div>
                                        @endforeach
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
</div>
@endsection