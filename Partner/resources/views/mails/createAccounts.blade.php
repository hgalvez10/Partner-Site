<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Validación de Cuenta</title>
</head>
<body>
    <p>Hola! Se ha reportado el registro de una nueva cuenta a nombre de {{$user->name}}.</p>
    <p>Estos son los datos del usuario que se ha registrado en la cuenta:</p>
    <ul>
        <li>Nombre: {{ $user->name }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Contraseña: {{ $password }}</li>
    </ul>
    <p>Por favor no responder a este email.</p>
</body>
</html>