@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @livewireStyles
    <meta name="description"
          content="Application de gestion d'équipes sportives permettant la gestion des joueurs, entraînements, matchs et présences.">
    <meta name="author" content="Dylan Piquin">
    <meta name="keywords" content="football, équipe, entraînement, match, gestion">

    <title>{{ $title ? $title . ' - ' . config('app.name', 'SportTeams') : config('app.name', 'SportTeams') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @include('partials.vite-or-fallback-styles')
</head>
<body x-data="{ open: false }" :class="{ 'overflow-hidden': open }">
<h1 class="sr-only">Pfe - SportTeams</h1>
<header class="bg-[#192443]">
    <div class="">
        <x-nav></x-nav>
    </div>

</header>
<main>
    {{ $slot  }}
</main>
<x-toast />
@livewireScripts
</body>
</html>
