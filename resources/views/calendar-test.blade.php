<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FullCalendar (via Vite + npm)</title>

    <!-- Vite va injecter tout ton CSS et JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background:#111; color:white; font-family:sans-serif;">
<h1 style="text-align:center;">✅ Testcdcd FullCalendar (version npm)</h1>

<!-- Le calendrier s’initialise sur cette div -->
<div id="calendar"
     style="max-width:900px; margin:40px auto; background:white; color:black; border-radius:10px; padding:10px;">
</div>
</body>
</html>
