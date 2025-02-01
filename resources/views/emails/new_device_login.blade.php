<!DOCTYPE html>
<html>
<head>
    <title>Nuevo inicio de sesión detectado</title>
</head>
<body>
    <h2>¡Alerta de inicio de sesión!</h2>
    <p>Hemos detectado un inicio de sesión desde un nuevo dispositivo.</p>
    <p><strong>IP:</strong> {{ $ip }}</p>
    <p><strong>Dispositivo:</strong> {{ $userAgent }}</p>
    <p>Si no fuiste tú, puedes cerrar esta sesión haciendo clic en el siguiente enlace:</p>
    @if($logoutUrl)
    <p>Si no reconoces este dispositivo, puedes cerrar la sesión haciendo clic <a href="{{ $logoutUrl }}">aquí</a>.</p>
@endif
</body>
</html>
