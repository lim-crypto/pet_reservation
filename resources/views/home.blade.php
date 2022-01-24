@extends('layouts.app')

@section('style')
<style>
  .jumbotron {
    background-image: url("{{asset('images/Labrador_Grass.jpg')}}");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    color: white;
  }

  #about {
    background-image: url("{{asset('images/cat.jpg')}}");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    color: white;
  }
</style>
@endsection
@section('content')
<div class="jumbotron" id="home">
  <div class="container">
    <h1 class="display-3" data-aos="fade-right">We care <br> <b>As you care</b></h1>
    <p data-aos="fade-right">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
    <p><a class="btn custom-bg-color " href="#about" role="button" data-aos="fade-up">Learn more &raquo;</a></p>
  </div>
</div>
<div class="container py-4">
  @if(App\Model\Type::all()->count() > 0)
  <section id="pets" class="row justify-content-center pt-5">
    <div class="col-12">
      <h1 class="text-center text-success">Our Pets</h1>
    </div>
    @foreach(App\Model\Type::all() as $type)

    <div class="col-lg-3 col-md-5 col-8 p-4" data-aos="zoom-in">
      <a href="{{route('petType',$type->slug)}}">
        <div class="card custom-border custom-bg-color h-100">
          <div class="card-body text-center">
            <h2 class="card-text ">
              {{$type->name}}
            </h2>
          </div>
        </div>
      </a>
    </div>

    @endforeach
  </section>
  @endif
  @if(App\Model\Service::all()->count() > 0)
  <section id="services" class="row justify-content-center pt-5">
    <div class="col-12 text-center">
      <h1 class="text-center custom-color">Pet Services</h1>
    </div>
    @foreach(App\Model\Service::all() as $service)
    <div class="col-lg-3 col-md-5 col-8 p-4" data-aos="fade-up">
      <div class="card custom-border h-100">
        <img src="{{asset('storage/images/service/'.$service->image)}}" class="card-img-top" style="object-fit:cover;" height="250px" alt="">
        <div class="card-body">
          <!-- pet boarding -->
          <h5 class="card-title">
            <i class="fas fa-paw"></i>
            {{$service->service}}
          </h5>
          <p class="card-text text-truncate">{{$service->description}}</p>
        </div>
        <div class="card-footer">
        <a href="{{route('serviceDetails', $service->id)}}" class="btn btn-sm custom-bg-color">Read more</a>

        </div>

      </div>
    </div>
    @endforeach
    <div class="col-12 text-center py-5">
      <a href="{{route('appointment.create')}}" class="btn btn-lg custom-bg-color"> Book appointment now </a>
    </div>
  </section>
  @endif

  <!-- ======= About Us Section ======= -->
  <section id="about">
    <div class="container pt-5">

      <div class="section-title pb-3" data-aos="fade-up">
        <h1 class="display-3">About Us</h1>
      </div>

      <div class="row content ">
        <div class="col-lg-6 p-3" data-aos="fade-up" data-aos-delay="300">
          <p>
            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.
          </p>

        </div>
      </div>
    </div>
  </section>
  <!-- End About Us Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" data-aos="fade-up">
    <div class="container py-5">
      <div class="section-title text-center pb-5">
        <h1>Contact Us</h1>
      </div>
      <div class="row justify-content-md-center">
        <div class="col-md-6">
          <div class="row">
            <div class="col-6">
              <h2 class="font-weight-bold">
                <i class="fas fa-envelope text-success"></i>
                Email
              </h2>

              <p>info@example.com</p>
            </div>

            <div class="col-6">
              <h2 class="font-weight-bold">
                <i class="fas fa-phone  text-success "></i>
                Phone
              </h2>
              <p>+1 5589 55488 55s</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-6">
              <h2 class="font-weight-bold ">
                <i class="fas fa-map-marker-alt text-success"></i>
                Location
              </h2>
              <p>A108 Adam Street<br>New York, NY 535022</p>
            </div>

            <div class="col-6 ">
              <h2 class="font-weight-bold">
                <i class="fas fa-clock text-success"></i>
                Working Hours
              </h2>

              <p>8:00 AM - 5:00 PM </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Contact Section -->

  <!-- ======= Footer ======= -->
  <section id="footer">
    <div class="container pt-5">
      <div class="copyright">
        <strong>Copyright &copy; {{Carbon\carbon::now()->year}}
          <a href="#" target="_blank">PremiumKennel</a>
        </strong>
        All rights reserved.
      </div>
    </div>

  </section>
</div>
@endsection