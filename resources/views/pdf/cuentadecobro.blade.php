<!DOCTYPE html>
<html>

<head>
    <title>Cuenta de Cobro</title>

</head>

<body>
    <table width="100%">
        <tr>
          <td>
            <table width="100%">
             <tr>
              <td>
               <img src="{{ asset('images/logon13.png') }}" width="85px" height="85px"></br>
               <center><font size="3">{{$email}}</font></center>
               <br>
             </td>
              </tr>
              <tr>
                <td align="center">
                        <font size="2"> <b>Santiago de Cali : {{$fecha_impresion}}</b></font>
                    </td>
                </tr>
          </table>
            </td>
   
            <td>
                <table width="100%">
                    <tr>
                        <td align="center">
                            <h2>{{$nombre_nota}}</b></h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <font size="3">Dra. {{$nombre_notario}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <font size="3">Nit. {{$nit}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <font size="2">{{$direccion_nota}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            {{$nombre_reporte}} Nro: <h3>{{$id_cuentacobro}}</h3>
                        </td>
                    </tr>
            </table>
        </td>
       
    </tr>
</table>


<div  style="text-align: center;">
    <h4>{{$cliente}}</h4>
</div>

<div  style="text-align: center;">
     {{$id_cliente}}
</div>

<div  style="text-align: center;">
     {{$direccion}}
</div>

<div  style="text-align: center;">
    Debe a:
 </div>

<div  style="text-align: center;">
    Dra. {{$nombre_notario}} - {{$nombre_nota}}
</div>

<div  style="text-align: left;">
    Para realizar el tramite de Beneficiencia y Registro de las escrituras solcicitadas por ustedes. Se debe depositar
</div> 

<hr>
<table width="100%">
    <thead>
        <tr>
            <th><font size="2">No.Bono</font></th>
            <th><font size="2">Esc</font></th>
            <th><font size="2">Fact</font></th>
            <th><font size="2">Fecha</font></th>
            <th><font size="2">Valor</font></th>

        </tr>
    </thead>
    <tbody id="datos">
         {{-- Inicializar una variable para alternar colores --}}
            @php
                $colorAlternado = true;
            @endphp
        @foreach($CuentaCobro as $item)
         {{-- Alternar colores de fondo --}}
            @php
            $colorFondo = $colorAlternado ? '#ffffff' : '#f2f2f2';
            @endphp
        <tr style="background-color: {{ $colorFondo }}">
            <td>
                <font size="2">{{ $item['codigo_bono'] }}</font>
            </td>
            <td align="center">
                <font size="2">{{ $item['num_escr'] }}</font>
            </td>
            <td align="center">
                <font size="2">{{ $item['id_fact'] }}</font>
            </td>
             <td align="center">
                <font size="1">{{ Carbon\Carbon::parse($item['fecha_bono'])->format('d/m/Y') }} </font>
            </td>
            <td align="right">
                <font size="2">{{ number_format($item['valor_bono'], 2) }}</font>
            </td>
        </tr>
        {{-- Alternar el valor de la variable para el próximo ciclo --}}
                @php
                $colorAlternado = !$colorAlternado;
                @endphp
        @endforeach
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td align="right">
                ---------------------
            </td>
        </tr>
        <tr>
            <td>
            </td>
             <td>
            </td>
             <td>
            </td>
            <td align="right">
                <b>Total a Pagar:</b>
            </td>
            <td align="right">
                <b>{{number_format($Total, 2)}}</b>
            </td>
        </tr>

    </tbody>
</table>
<hr>
<div  style="text-align: left;">
   {{$mensaje_pago_cc}}
</div> 

<div  style="text-align: left;"><br><br>
    __________________________<br>
    {{$responsable_cartera}}<br>
    Dpto de Cartera
</div> 

</body>

</html>
