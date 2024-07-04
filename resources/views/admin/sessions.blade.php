<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
</head>
<body>
    <h1>Welcome to the Homepage</h1>
    <p>Total Visits: {{ $visits }}</p>
    <p>Sessoes:
    {{ json_encode($sessions) }}</p>
</body>
</html>
