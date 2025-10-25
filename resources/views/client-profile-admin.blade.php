<!DOCTYPE html>
<html>
<head>
    @include('listing-utils::head')
    @stack('styles')
</head>


<body>
    @include('header-admin')
    <div style="height: 60px"></div>
    <div style="display:flex; flex-direction:row; justify-content:center;">
        <h4>{{ $client->name }}</h4>
    </div>
    <div style="display:flex; flex-direction:row; gap:18px; justify-content:center;">
        <h5>{{ $client->mail }}</h5>
        <h4></h4>
        <h5>{{ $client->phone }}</h5>
    </div>
    <div style="display:flex; flex-direction:row; justify-content:center;">
        <p style="text-align: center;">{{ $client->long_comment }}</p>
    </div>
    <div style="padding: 1.5rem">
    @include('sharedutils::components.tables.smartTable', ['table' => $table])
    </div>
    @stack('script-includes')
    @stack('scripts')
</body>
</html>