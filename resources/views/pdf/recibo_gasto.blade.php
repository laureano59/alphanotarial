<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recibo de Gasto</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .receipt-container {
      position: relative;
    }
    .receipt {
      width: 100%;
      margin: 0 auto;
      padding: 20px;
      box-sizing: border-box;
    }
    .receipt h2 {
      text-align: center;
      margin-top: 1px;
    }
    .receipt .info {
      margin-bottom: 20px;
    }
    .receipt .info p {
      margin: 5px 0;
    }
    .receipt .items {
      border-collapse: collapse;
      width: 100%;
    }
    .receipt .items th, .receipt .items td {
      border: 1px solid #000;
      padding: 8px;
      text-align: left;
    }
    .receipt .items th {
      background-color: #f2f2f2;
    }
    .logo {
      position: absolute;
      top: 20px;
      right: 10px;
      width: 70px; /* Ajusta el ancho según el tamaño de tu logo */
      height: auto;
    }
  </style>
</head>
<body>
  <div class="receipt-container">
    <div align="right">
    <img class="logo" src="{{ asset('images/logoposn13.png') }}" width="85px" height="85px">
  </div>
    <div class="receipt">
      <h2>Recibo No. {{$id_gas}}</h2>
      <div class="info">
        <p><strong>Fecha:</strong> {{$fecha_gas}}</p>
        <p><strong>Aprobado por:</strong> {{$autorizado_por}}</p>
        <p><strong>La cantidad de:</strong> {{$valor_letras}} PESOS MCTE  (${{ number_format($valor_gas, 2) }})</p>
      </div>
      <table class="items">
        <thead>
          <tr>
            <th>Concepto</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$concepto_gas}}</td>
            <td> ${{ number_format($valor_gas, 2) }}</td>
          </tr>
        </tbody>
      </table>
      <p><strong>Nombre y Firma de quien recibe:</strong></p>
    </div>
  </div>
</body>
</html>