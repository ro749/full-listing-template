@php
    $user = auth()->guard('asesor')->user();
@endphp
<button style="width: 100%;" class="d-flex justify-content-center align-items-center rounded-circle" type="button" id="{{ $name }}-button">
    <img src="
    @if(!empty($user->pfp))
    {{ asset('storage/uploads/' . $user->pfp) }}
    @else
    https://propstudios.mx/img/default_user.jpeg
    @endif
    " alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
</button>

@push('scripts')
<script>
    $('#{{ $name }}-button').on('click',function () {
        $('#{{ $name }}').click();
    });
</script>
@endpush