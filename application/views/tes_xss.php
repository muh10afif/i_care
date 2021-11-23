<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Tanpa XSS 
    username: <?= $tanpa_xss['username'] ?>, password: <?= $tanpa_xss['password'] ?>
    <br>
    <br>
    Dengan XSS 
    username: <?= $gun_xss['username'] ?>, password: <?= $gun_xss['password'] ?>
</body>
</html>