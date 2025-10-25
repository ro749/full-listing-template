<!DOCTYPE html>
<html>
<head>
    @include('head')
</head>


<body>
    @include('header')
    <div style="padding: 1.5rem">
    @include('sharedutils::components.tables.smartTable', ['table' => $table])
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
    @stack('script-includes')
    @stack('scripts')
</body>
</html>