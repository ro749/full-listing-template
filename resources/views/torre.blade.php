<x-layout>
    @include(config('overrides.views.header'))
    <div style="padding: 1.5rem">
    @include('sharedutils::components.tables.smartTable', ['table' => $table])
    </div>
    @push('script-includes')
    <script src="{{ asset('js/vendors.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>
    <script src="{{ asset('js/validation-booking.js') }}"></script>
    <script src="{{ asset('js/swiper.js') }}"></script>
    <script src="{{ asset('js/custom-swiper-2.js') }}"></script>
    @endpush
    @push('scripts')
    <script>
        $(document).ready(function () {
            setTimeout(function(){
                const event = new UIEvent('resize', {
                  bubbles: true,
                  cancelable: false,
                  view: window,
                  detail: 0
                });
                window.dispatchEvent(event);
            }, 1000);
        });
        window.addEventListener('resize', function() {
            $('body').css({
              width: '100%',
              height: '100%'
            });
        });
    </script>
    
    @endpush
</x-layout>