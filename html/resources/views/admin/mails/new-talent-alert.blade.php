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
        El talento <b>{{ $alert->influencer->full_name }}</b>, creo una nueva alerta.
    </h2>
    <h2 align='center' style="font-family: Verdana, Geneva, Tahoma, sans-serif">
        {{ $alert->title  }}
        <br>
        {!! $alert->description !!}
        <br>
        Comienza el {{ $alert->start_at->format('Y-m-d') }} y termina el {{ $alert->end_at->format('Y-m-d') }}
    </h2>
    <hr>
    <br>
    <br>
    <br>
</div>
</body>
</html>
