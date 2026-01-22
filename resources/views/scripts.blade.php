@push('script-includes')
<script src="js/vendors.js"></script>
<script src="js/designesia.js"></script>
<script src="js/validation-booking.js"></script>
<script src="js/swiper.js"></script>
<script src="js/custom-swiper-2.js"></script>
@endpush

@push('scripts')
<script>
    var data = @json($unit);
    $(function () {
      $("#date").datepicker({ 
            autoclose: true, 
            todayHighlight: true
      }).datepicker('update', new Date());
    });
    @if(empty($unit))
    $(document).on('selected-unit', function(e, raw_data) {
        data = raw_data["unit"];
        selected_unit_id = data["id"];
        fill_data();
    });
    @else
    fill_data();
    @endif
    function fill_data(){
        @stack('before_fill') 
        @stack('fill')
        @stack('after_fill')
    }
</script>
@endpush
@if(isset($imp))
@include('listing-utils::ImageMapPro.image-map-pro',['imp'=>$imp])
@endif
@stack('script-includes')
@stack('scripts')