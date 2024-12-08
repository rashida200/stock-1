@props(['class' => null])
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Default Title')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/styles.css'])

</head>

<body {{ $class ? "class=$class" : '' }}>
    {{ $slot ?? '' }}

    @vite(['resources/js/script.js'])
</body>

</html>
