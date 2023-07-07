<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{$version->name}} | {{config('motor-cms-frontend.name')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://use.typekit.net/ize5lgw.css" />

    <link href="{{ mix('/css/motor-frontend.css') }}" rel="stylesheet" type="text/css"/>
    <link href="/css/evoke2023.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
    <link rel=icon href="/favicon.png" type="image/x-icon">
    @yield('view-styles')
    <style lang="text/css">
        {{ config('partymeister-frontend.css') }}
    </style>
</head>
<body>
@include('motor-cms::layouts.frontend.partials.navigation')
<div class="grid-container" style="margin-bottom: 8rem; margin-top: 1rem;">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>
<div class="columns shrink footer text-center" style="position: fixed; bottom: 0; width: 100%;">
</div>
<script src="{{mix('js/partymeister-frontend.js')}}"></script>
@yield('view-scripts')
<script>
    $(document).foundation();
</script>
</body>
</html>
