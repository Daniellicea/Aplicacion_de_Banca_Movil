<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña - Bankario</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f9fafb; color:#333;">
<h2>Hola 👋</h2>
<p>Recibiste este correo porque solicitaste restablecer tu contraseña en <strong>Bankario</strong>.</p>

<p>
    <a href="{{ url('/reset-password/' . $token . '?correo=' . urlencode($correo)) }}"
       style="display:inline-block; background-color:#2563eb; color:white; padding:10px 20px; text-decoration:none; border-radius:8px;">
        Restablecer Contraseña
    </a>
</p>

<p>Si no solicitaste este cambio, simplemente ignora este mensaje.</p>

<hr>
<small>© {{ date('Y') }} Bankario — Sistema de Banca Móvil</small>
</body>
</html>
