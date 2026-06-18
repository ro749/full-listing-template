@include('listing-utils::head')
@push('styles')
<!--full-listing-template css-->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
<link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/swiper.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css" >
<!-- custom-css -->
<link href="{{ asset('css/swiper-custom-1.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/datepicker.css') }}" rel="stylesheet" type="text/css" >
<!-- color scheme -->
<link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css" >
<link href="vendor/full-listing-template/css/style.css" rel="stylesheet" type="text/css" >
<!--end-full-listing-template css-->
@endpush