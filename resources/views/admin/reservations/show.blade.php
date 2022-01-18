@extends('admin.layouts.app')

@section('style')
<!-- fullCalendar -->
<script src="{{asset('Adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/fullcalendar/main.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />

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

@section('main-content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper py-4">
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
            <div class="card card-primary card-outline ">
                <header class="card-header">
                    <h4 class="card-title">Reservation ID: {{$reservation->id}}</h4>

                    <div class="card-tools">
                        @if($reservation->status == 'pending' || $reservation->status == 'approved')
                        <form action="{{route('reservation.status',$reservation->id)}}" method="post" class="float-right">
                            @csrf
                            @method('PUT')
                            <select name="status" id="" class=" form-control-sm">
                                <option value="pending" {{$reservation->status == 'pending' ?   'selected': ''}}>Pending</option>
                                <option value="approved" {{$reservation->status == 'approved' ?   'selected': ''}}>Approve</option>
                                <option value="rejected" {{$reservation->status == 'rejected' ?   'selected': ''}}>Reject</option>
                                <option value="completed" {{$reservation->status == 'completed' ?   'selected': ''}}>Completed</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
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
                            <small class="text-muted" >{{$reservation->created_at}}</small>
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

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection