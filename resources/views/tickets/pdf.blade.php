<!DOCTYPE html>
<html>
<head>
    <title>Boleto</title>
    <style>
        body {
            font-family: 'Arial, sans-serif';
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details h2 {
            margin: 0 0 10px;
        }
        .details p {
            margin: 0 0 5px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ticket de Cine</h1>
        </div>
        <div class="details">
            <h2>Detalles del Ticket</h2>
            <p><strong>Película:</strong> {{ $ticket->screening->movie->titulo }}</p>
            <p><strong>Sala:</strong> {{ $ticket->screening->room->name }}</p>
            <p><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($ticket->screening->start_time)->format('d-m-Y H:i') }}</p>
            <p><strong>Asiento:</strong> {{ $ticket->seat_number }}</p>
            <p><strong>Precio:</strong> ${{ number_format($ticket->screening->price, 2) }}</p>
            <p><strong>Cliente:</strong> {{ $ticket->client->name }}</p>
        </div>
        <div class="footer">
            <p>Gracias por su compra. ¡Disfrute de la película!</p>
        </div>
    </div>
</body>
</html>
