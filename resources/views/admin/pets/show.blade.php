@extends('admin.layouts.app')
@section('style')
<style>
iframe {
    height: 100vh;
    width: 100%;
}
</style>
@endsection
@section('main-content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <iframe src="{{route('petDetails',$pet->slug)}}"  >
    </iframe>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection