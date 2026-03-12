<x-layout>
    <style>
        .filter-on{
            background-color: gray;
        }
    </style>
    @include(config('overrides.views.header-admin'))
    <div style="height: 60px"></div>
    <div style="padding: 1.5rem">
    @include('sharedutils::components.tables.smartTable', ['table' => $table])
    </div>
    @push('scripts')
    <script>
        $(document).on('change','#asesor',function(){
            $.ajax({
                url: "{{ route('clients-asesor') }}",
                type: "GET",
                dataType: "json",
                data: {
                    asesor: $(this).val()
                },
                success: function (data) {
                    $('#client').empty();
                    $.each(data, function (key, value) {
                        $('#client').append(new Option(value.name, value.id));
                    });
                    $('#client').val(null).trigger('change');
                }
            })
        });
    </script>
    @endpush
</x-layout>