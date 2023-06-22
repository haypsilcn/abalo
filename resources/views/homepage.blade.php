<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
</head>
<body>
    <div id="app">
        <div>
            <Site-Header></Site-Header>
            <Site-Body></Site-Body>
            <Site-Footer></Site-Footer>
        </div>

    </div>

    @vite('resources/js/app.js')
</body>

<script>
    const connection = new WebSocket("ws://localhost:8000/");
    connection.onopen = function() {
        console.log("Connection established");
    };

</script>
</html>
