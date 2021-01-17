<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    </head>
    <body>
        <div id="app">
            <file-upload></file-upload>
            <files-list></files-list>
        </div>
        <script src="https://unpkg.com/vue-infinite-loading@^2/dist/vue-infinite-loading.js"></script>
        <script src="/js/app.js"></script>
    </body>
</html>
