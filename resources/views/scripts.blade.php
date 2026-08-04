@push('scripts')
<script>
    var data = @json($unit);
    document.addEventListener('DOMContentLoaded', function() {
        @if(empty($unit))
        $(document).on('selected-unit', function(e, raw_data) {
            data = raw_data["unit"];
            selected_unit_id = data["id"];
            fill_data();
        });
        @else
        $(document).ready(function () {
            fill_data();    
        });
        @endif
        
    });
    function fill_data(){
        @if(!empty($is_open))
        $('#unit').val(data["id"]).trigger('change');
        @endif
        @stack('before_fill') 
        @stack('fill')
        @stack('after_fill')
    }
</script>
@endpush
@if(isset($imp) && get_class($imp) == 'Ro749\ListingUtils\ImageMapPro\SingleImageMapPro')
@include('listing-utils::ImageMapPro.image-map-pro',['imp'=>$imp])
@endif