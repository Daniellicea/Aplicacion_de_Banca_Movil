<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - Bankario</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #374151;
            line-height: 1.6;
        }
        table {
            border-collapse: collapse;
        }
        a {
            text-decoration: none;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff !important;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
            transition: background-color 0.3s;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                padding: 0 15px !important;
            }
            .content-area {
                padding: 20px !important;
            }
            .header-text {
                font-size: 24px !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f3f4f6;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f3f4f6;">
    <tr>
        <td align="center" style="padding: 40px 0;">
            <table class="container" role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05); overflow: hidden;">

                {{-- HEADER --}}
                <tr>
                    <td align="center" style="padding: 30px 0 20px; background-color: #ffffff; border-bottom: 3px solid #eff6ff;">
                        <h1 style="color: #1e40af; font-size: 36px; font-weight: bold; margin: 0; letter-spacing: -1px;">
                            Bankario
                        </h1>
                        <p style="color: #6b7280; font-size: 14px; margin: 5px 0 0 0; text-transform: uppercase; letter-spacing: 2px;">
                            Banca Móvil
                        </p>
                    </td>
                </tr>

                {{-- CONTENIDO --}}
                <tr>
                    <td class="content-area" style="padding: 40px;">

                        <h2 style="font-size: 28px; color: #1f2937; margin-top: 0; font-weight: bold;">
                            Solicitud de Restablecimiento
                        </h2>

                        <p style="margin-bottom: 25px; font-size: 16px; color: #4b5563;">
                            Hola 👋,
                        </p>

                        <p style="margin-bottom: 30px; font-size: 16px; color: #4b5563;">
                            Recibiste este correo porque solicitaste restablecer tu contraseña para tu cuenta
                            <strong>Bankario</strong>. Haz clic en el botón de abajo para continuar con el proceso.
                        </p>

                        {{-- BOTÓN DE RECUPERACIÓN --}}
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td align="center" style="padding: 10px 0 40px;">
                                    <a href="{{ url('/reset-password/' . $token . '?correo=' . urlencode($usuario->correo)) }}"
                                       class="button"
                                       target="_blank">
                                        Restablecer Contraseña
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin-bottom: 20px; font-size: 16px; color: #4b5563;">
                            Si no solicitaste este cambio, por favor ignora este mensaje; tu contraseña seguirá siendo la misma.
                        </p>

                    </td>
                </tr>

                {{-- FOOTER --}}
                <tr>
                    <td style="padding: 20px 40px; background-color: #f9fafb; border-top: 1px solid #e5e7eb;">
                        <p style="font-size: 12px; color: #9ca3af; margin: 0; text-align: center;">
                            © {{ date('Y') }} Bankario — Todos los derechos reservados.
                        </p>
                        <p style="font-size: 12px; color: #9ca3af; margin: 5px 0 0 0; text-align: center;">
                            Este es un correo automatizado; por favor, no respondas.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
