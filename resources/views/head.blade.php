@include('listing-utils::head')
@push('styles')
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
<style>
    /* correct head */
    .plan-div p, .plan-div span, .sender-popup p, .sender-popup h4, .sender-popup h5{
        color: black;
    }
    .plan-title{
        margin-top: 1rem;
        margin-bottom: 2rem;
    }
    .characteristic-icon{
        width: 2em;
        height: 2em;
    }
    .characteristic{
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 1em;
    }
    #characteristics{
        display: flex;
        flex-direction: column;
        gap: 0.5em;
    }
    .characteristic-text{
        margin:0;
    }
    @media (max-width: 991px) {
        .imp-ui-top-right{
            top: -20px !important;
        }
    }
    .menu-item{
        color:  #c5693b !important;
    }
    #ClientComment-button{
        display: flex;
        justify-content: center;
        padding: 1rem;
    }
    #ClientComment-button button{
        background-color: var(--neutral-900);
        color: #fff;
    }

    #client-info h4, #client-info h5{
        color: black;
    }
</style>
@endpush