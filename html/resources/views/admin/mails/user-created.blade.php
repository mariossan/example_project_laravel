<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="background: #F1F1E6;"">
    <div class="container" style="width: 100%; margin:auto;">
        <div align='center' style="background: #000528">

        </div>

        <h2 align='center' style="font-family: Verdana, Geneva, Tahoma, sans-serif">
            Bienvenido <i>{{ $msg['name'] }}</i>
        </h2>

        <hr>

        <table width='100%'>
            <tr>
                <td colspan="2" align="center" style="font-size: 1.2rem">
                    Tus accesos son:
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td align="right" width='45%'><b>E-mail:</b></td>
                <td>{{ $msg["email"] }}</td>
            </tr>

            <tr>
                <td align="right"><b>Contraseña:</b></td>
                <td>{{ $msg["password"] }}</td>
            </tr>

            <tr>
                <td align="right"><b>Link:</b></td>
                <td>
                    <a href="{{ url("/") }}" target="_blank">
                        {{ url("/") }}
                    </a>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
    </div>
</body>
</html>
