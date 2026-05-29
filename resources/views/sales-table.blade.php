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
        $(document).on('change','#asesor_id',function(){

            $.ajax({
                url: "{{ route(name:'clients-asesor',absolute:false) }}",
                type: "GET",
                dataType: "json",
                data: {
                    asesor: $(this).val()
                },
                success: function (data) {
                    $('#client_id').empty();
                    $.each(data, function (key, value) {
                        $('#client_id').append(new Option(value.name, value.id));
                    });
                    $('#client_id').val(null).trigger('change');
                }
            })
        });
    </script>
    @endpush
</x-layout>