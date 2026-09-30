<x-layout class="{{ config('listing.class') ?? '' }}">
    <style>
        .dialog-footer {
            display: flex;
            justify-content: center !important  ;
            gap: 6px;
        }
    </style>
    <div id="wrapper">
        @if(config('listing.show_scrollbar', false))
        <div class="float-text show-on-scroll">
            <span><a href="#">Scroll to top</a></span>
        </div>
        @endif
        <div class="scrollbar-v show-on-scroll"></div>
        
        <!-- page preloader begin -->
        <div id="de-loader"></div>
        <!-- page preloader close -->

        @include(config('overrides.views.header'))
        @if(view()->exists('pre-data'))
        @include('pre-data')
        @endif

        @include('disponibilidad-data')

        @include('post-data')

        @if(isset($asesor_area))
        @include(config('overrides.views.asesor-area'))
        @endif
        @if(!empty($is_open))
        @include(config('overrides.views.contact-form'),['form'=>$form])
        @endif
    </div>
</x-layout>