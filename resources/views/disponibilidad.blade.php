<x-layout>
    <div id="wrapper">
        <div class="float-text show-on-scroll">
            <span><a href="#">Scroll to top</a></span>
        </div>
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
        @include(config('overrides.views.footer'))
    </div>
    @push('script-includes')
    <script src="js/vendors.js"></script>
    <script src="js/designesia.js"></script>
    <script src="js/validation-booking.js"></script>
    <script src="js/swiper.js"></script>
    <script src="js/custom-swiper-2.js"></script>
    @endpush
    @push('scripts')
    <script>
        window.addEventListener('resize', function() {
            $('body').css({
              width: '100%',
              height: '100%'
            });
        });
    </script>
    @endpush
    @include(config('overrides.views.scripts'))
</x-layout>