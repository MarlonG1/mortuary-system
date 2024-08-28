@php
    $date = date('d/m/Y H:i:s');
@endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Compra</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background-color: #fff;
            padding: 10px 0;
            margin: 0;
        }

        .ticket {
            width: 100%;
            max-width: 250px;
            margin: 0 auto;
            padding: 10px;
            border: 1px dashed #000;
            text-align: center;
            box-sizing: border-box;
        }

        .header {
            margin-bottom: 10px;
        }

        .header .logo {
            font-size: 18px;
            font-weight: bold;
            padding: 0 0 5px 0;
        }

        .info {
            text-align: left;
            margin-bottom: 10px;
        }

        .items {
            width: 100%;
            margin-bottom: 10px;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Alineación vertical centrada */
            margin-bottom: 5px;
        }

        .total {
            text-align: right;
            margin-top: 10px;
        }

        .footer {
            margin-top: 10px;
            font-size: 10px;
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .bold {
            font-weight: bold;
            padding: 10px 0 0 10px;
        }
    </style>
</head>
<body>
<div class="ticket">
    <div class="header">
        <div class="logo">Funeraria La Auxiliadora</div>
        <div>Casa frente al inge</div>
        <div>Los Abogados</div>
    </div>

    <div class="info">
        <div>Print date: {{$date}}</div>
        <div>Ticket #: {{$sale->id}}</div>
        <div>Customer: {{$sale->customer->name . ' ' . $sale->customer->lastname}}</div>
        <div>Department: {{$sale->office->location}}</div>
        <div style="margin: 8px 0; padding: 5px 0 0 0;border-top: 1px dashed #000;">
            <table width="100%">
                <tr>
                    <td style="text-align: left;">Sale date: {{$sale->sale_date}}</td>
                    <td style="text-align: right;">Execution date: {{$sale->execution_date}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="items">
        @foreach($sale->services as $service)
            <div class="item">
                <table width="100%">
                    <tr>
                        <td style="text-align: left;">{{$service->name}}</td>
                        <td style="text-align: right;">${{number_format($service->serviceDetail->price, 2)}}</td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>

    <div class="total">
        <div>Taxes for bellaco (0%): :D</div>
        <div>Total: ${{$sale->total}}</div>
    </div>
    <div class="bold">**Payment receipt**</div>
    <div class="footer">
        If you read this<br>
        you are gay
    </div>
</div>
</body>
</html>
