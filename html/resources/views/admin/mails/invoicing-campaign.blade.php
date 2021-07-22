<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="background: #F1F1E6;">
<div class="container" style="width: 100%; margin:auto;">
    <div align='center' style="background: #000528">
    </div>

    <h2 align='center' style="font-family: Verdana, Geneva, Tahoma, sans-serif">
        La campaña <b>{{ $campaign->name }}</b>, tiene una nueva factura.
    </h2>
    <h2 align='center' style="font-family: Verdana, Geneva, Tahoma, sans-serif">
        <b><a class="btn btn-primary btn-sm" href="{{ asset('/storage/facturas/campaign') }}{{ $campaign->id }}/{{ $campaign->fileName }}" target="_blank">Ver factura</a></b>
    </h2>
    <hr>
    <br>
    <br>
    <br>
</div>
</body>
</html>
