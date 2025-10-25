<!DOCTYPE html>
<html>
<head>
    @include('listing-utils::head')
    @stack('styles')
    <style>
        .filter-on{
            background-color: gray;
        }
    </style>
</head>


<body>
    @include('header-admin')
    <div style="height: 60px"></div>
    <div style="padding: 1.5rem">
    @include('sharedutils::components.tables.smartTable', ['table' => $table])
    </div>
    @stack('script-includes')
    @stack('scripts')
</body>
</html>