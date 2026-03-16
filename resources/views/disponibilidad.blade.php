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
        
        @include('pre-data')

        <div id="map-area">
            @if(isset($imp))
                <div id="image-map-pro"></div>
            @else
                <div style="display: flex; flex-direction: row; justify-content: center;">
                    <x-f-image :unit="$unit" id="ubicacion" src="UbicacionTorre/" data="unit" ext=".jpg" ></x-f-image>
                </div>
            @endif
        </div>

        @include('disponibilidad-data')

        @include('post-data')

        @if(isset($asesor_area))
        @include(config('overrides.views.asesor-area'))
        @endif
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
</x-layout>